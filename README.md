# PHP Test App

A simple PHP web application using the Flight Framework for user registration, login, and profile management.

## Features
- User registration: name, email, password, birth_date
- PHP session-based authentication
- View and update user profile
- Logout and delete account
- REST API endpoints: `/register`, `/login`, `/logout`, `/profile`

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/username/php-test.git
2. Set up the MySQL database:

CREATE DATABASE php_test;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    birth_date DATE
);
3. Configure your database connection in api/bootstrap.php.

4. Start your local server (e.g., XAMPP/Apache) and open http://localhost/php-test/public/index.html.

## Project Structure
php-test/
├── api/
│   ├── index.php
│   ├── bootstrap.php
│   ├── .htaccess
│   ├── controllers/
│   │   └── UserController.php
│   └── services/
│       └── UserService.php
├── public/
│   ├── index.html
│   ├── signin.html
│   ├── signup.html
│   ├── profile.html
│   ├── js/
│   │   └── app.js
│   └── css/

## Usage
Open index.html, register a new account, and log in.

Go to profile.html to view and edit your profile.

Profile updates, login, and registration are handled via AJAX, and PHP sessions are properly maintained.