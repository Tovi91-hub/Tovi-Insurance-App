# Tovi Life Insurance App

# Tovi Life Insurance App

[![GitHub license](https://img.shields.io/github/license/Tovi91-hub/Tovi-Insurance-App)](https://github.com/Tovi91-hub/Tovi-Insurance-App/blob/main/LICENSE)
[![Last Commit](https://img.shields.io/github/last-commit/Tovi91-hub/Tovi-Insurance-App)](https://github.com/Tovi91-hub/Tovi-Insurance-App/commits/main)
[![Repo Size](https://img.shields.io/github/repo-size/Tovi91-hub/Tovi-Insurance-App)](https://github.com/Tovi91-hub/Tovi-Insurance-App)
[![Issues](https://img.shields.io/github/issues/Tovi91-hub/Tovi-Insurance-App)](https://github.com/Tovi91-hub/Tovi-Insurance-App/issues)
[![Stars](https://img.shields.io/github/stars/Tovi91-hub/Tovi-Insurance-App?style=social)](https://github.com/Tovi91-hub/Tovi-Insurance-App/stargazers)

Tovi Life Insurance is a web-based login interface designed to simulate a real-world insurance customer portal. The application allows users to log in, manage their credentials, and view a secure dashboard after authentication. This project is developed using HTML, CSS, JavaScript, PHP, and MySQL.


## Features

- Responsive sign-in interface modeled after Jackson's login portal
- Secure PHP-based login form with basic validation
- User authentication using MySQL database
- Styled with modern CSS layout principles
- Clean UI/UX for desktop and mobile browsers

## Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Database**: MySQL

## Folder Structure

```
Tovi-Insurance-App/
│
├── index.html             # Main login page
├── style.css              # Styling for the interface
├── script.js              # Frontend interaction (optional)
├── auth.php               # Login processing and authentication logic
├── dashboard.html         # (Optional) Redirect landing page after login
└── README.md              # Project overview
```

## MySQL Database Setup

Use the following SQL in phpMyAdmin to create the necessary database and user table:

```sql
CREATE DATABASE IF NOT EXISTS user_auth;
USE user_auth;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password) VALUES
('admin', MD5('password123')),
('user1', MD5('securepass'));
```

## Usage

1. Clone the repository:

```bash
git clone https://github.com/YOUR_USERNAME/Tovi-Insurance-App.git
```

2. Place the project folder inside your XAMPP `htdocs` directory.

3. Start Apache and MySQL using the XAMPP Control Panel.

4. Navigate to `http://localhost/Tovi-Insurance-App` in your web browser.

5. Log in using one of the test credentials from the SQL setup.

## Author
SGT Sedjro Tovihouande — [sedjrotovihouande.com](https://sedjrotovihouande.com)

## License
This project is licensed for academic and educational purposes only.