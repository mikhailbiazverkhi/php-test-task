# PHP Test Task – Flight Framework

Simple REST API built with **Flight PHP micro-framework**.

## Stack
- PHP  
- Flight PHP micro-framework  
- MySQL  
- jQuery + Bootstrap (frontend)  

## Project Structure

api/
├── bootstrap.php ← PDO + session init
├── index.php ← API entry point, starts Flight, loads controllers
├── controllers/
│ └── UserController.php ← all routes: register, login, logout, profile
└── services/
└── UserService.php ← all SQL queries and business logic
public/
├── index.html ← home / sign in / sign up links
├── signin.html ← login form
├── signup.html ← registration form
├── profile.html ← profile view / edit
└── js/
└── app.js ← frontend AJAX requests to API

## Current Status

- Flight framework initialized  
- API bootstrap configured  
- **UserController + UserService implemented**  
  - POST `/register` – register a new user  
  - POST `/login` – login user  
  - POST `/logout` – logout user  
  - GET `/profile` – get current user profile  
  - PUT `/profile` – update profile (name, birth_date, password)  
  - DELETE `/profile` – delete account  
- Sessions fully implemented (`$_SESSION['user_id']`)  
- Postman tested – all endpoints work correctly  
- Frontend not yet fully connected  

## Usage

- Project setup: place the project folder in XAMPP's `htdocs`  
- Testing API: currently only via Postman  
- Frontend is not yet connected