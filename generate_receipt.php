<?php
require_once('fpdf/fpdf.php');
require 'Database.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['payment_id'])) {
    die("Unauthorized access or missing payment ID.");
}

$user_id = $_SESSION['user_id'];
$payment_id = intval($_GET['payment_id']);

// Fetch payment and user
$stmt = $pdo->prepare("
    SELECT p.*, u.username, u.email 
    FROM payments p 
    JOIN users u ON p.user_id = u.user_id 
    WHERE p.payment_id = ? AND p.user_id = ?
");
$stmt->execute([$payment_id, $user_id]);
$payment = $stmt->fetch();

if (!$payment) {
    die("Payment not found.");
}

// Define custom PDF class
class ReceiptPDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Tovi Life Insurance', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Payment Receipt', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Thank you for your trust.', 0, 0, 'C');
    }
}

// Generate PDF
$pdf = new ReceiptPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, "Receipt ID: TLI-" . str_pad($payment['payment_id'], 5, "0", STR_PAD_LEFT), 0, 1);
$pdf->Cell(0, 10, "Name: " . $payment['username'], 0, 1);
$pdf->Cell(0, 10, "Date: " . $payment['payment_date'], 0, 1);
$pdf->Cell(0, 10, "Amount: $" . number_format($payment['amount'], 2), 0, 1);
$pdf->Cell(0, 10, "Method: " . $payment['method'], 0, 1);

$reference = $payment['paypal_email']
    ?? ($payment['card_last4'] ? '**** **** **** ' . $payment['card_last4'] : null)
    ?? ($payment['account_number_last4'] ? 'Acct ****' . $payment['account_number_last4'] : '-');

$pdf->Cell(0, 10, "Reference: " . $reference, 0, 1);
$pdf->MultiCell(0, 10, "Billing Address:\n" . $payment['city'] . ", " . $payment['state'] . " " . $payment['zip_code']);

$pdf->Output("I", "ToviLife_Receipt_" . $payment['payment_id'] . ".pdf");
exit;
