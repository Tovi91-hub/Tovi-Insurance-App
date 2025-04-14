-- 1. Create the proper database with CamelCase
CREATE DATABASE IF NOT EXISTS ToviLife;
USE ToviLife;

-- 2. Create tables
CREATE TABLE IF NOT EXISTS roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role_id INT DEFAULT 2,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

CREATE TABLE IF NOT EXISTS login_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    success BOOLEAN,
    ip_address VARCHAR(45),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- 3. Insert roles
INSERT INTO roles (role_name) VALUES ('admin'), ('user');

-- 4. Insert a test user (replace password_hash with actual hash generated in PHP)
INSERT INTO users (username, email, password_hash, role_id)
VALUES ('testuser', 'testuser@tovilife.com', '$2y$10$HkJ8zXzO3vVw...hash...', 2);

CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(64) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE policies (
    policy_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    policy_name VARCHAR(100),
    policy_type VARCHAR(50),
    coverage_amount DECIMAL(10,2),
    status VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE claims (
    claim_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    description TEXT,
    claim_amount DECIMAL(10,2),
    claim_date DATETIME,
    status VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    payment_date DATETIME,
    amount DECIMAL(10, 2),
    status VARCHAR(20),
    method VARCHAR(50),
    bank_name VARCHAR(100) DEFAULT NULL,
    account_number_last4 CHAR(4) DEFAULT NULL,
	card_last4 VARCHAR(4),
    paypal_email VARCHAR(100) DEFAULT NULL,
    billing_address VARCHAR(255),
    zip_code VARCHAR(10),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

ALTER TABLE payments
ADD COLUMN city VARCHAR(100),
ADD COLUMN state VARCHAR(50);
