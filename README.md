# Headless CMS with TALL Stack

This is a Headless Content Management System built with the TALL stack (Tailwind CSS, Alpine.js, Laravel, and Livewire). It provides a clean, modern interface for managing content and exposes that content through a secure, token-based RESTful API.

## 🚀 Core Features

-   **Authentication:** Secure admin panel using Laravel Jetstream with Role-Based Access Control (RBAC).
-   **Content Management:** Full CRUD functionality for Posts, Pages, and Categories, restricted to admin users.
-   **Secure API:** Token-based API protected with Laravel Sanctum, accessible only to admin users.
-   **Modern UI:** A polished and responsive admin dashboard built with Tailwind CSS and Livewire.
-   **Image Handling:** Livewire-powered image uploads with local storage.

## 🛠️ Tech Stack

-   **Backend:** Laravel 12
-   **UI & Interactivity:** Livewire 3, Alpine.js, Tailwind CSS
-   **Authentication:** Laravel Jetstream & Sanctum
-   **Testing:** PHPUnit

## 📋 Prerequisites

Before you begin, ensure you have the following installed on your local machine:

-   PHP >= 8.3
-   Composer
-   Node.js & NPM
-   A local database server (e.g., MySQL, MariaDB, PostgreSQL)

---

## ⚙️ Installation & Setup Guide

Follow these steps carefully to get the project running on your local machine.

### 1. Create the Laravel Project

composer create-project laravel/laravel headless-cms

### 2. Navigate to Project Directory
cd headless-cms

### 3. Install Laravel Jetstream
composer require laravel/jetstream
php artisan jetstream:install livewire

### 4. Enable API Feature in Jetstream
Open config/jetstream.php and uncomment Features::api().

### 5. Install & Build Frontend Assets
npm install
npm run build

### 6. Configure Your Environment
cp .env.example .env
php artisan key:generate

### 7. Set Up Your Database
Update your .env file with your database credentials.

### 8. Run Database Migrations
php artisan migrate

### 9. Link Storage Directory
php artisan storage:link

▶️ Running the Application
Terminal 1: npm run dev
Terminal 2: php artisan serve

🔐 Admin User & API Token Setup
### 1. Register a User
Go to your running application and register a new user.

### 2. Promote User to Admin
Run the following Artisan command, replacing user@example.com with the user's email.

php artisan app:make-user-admin user@example.com

### 3. Generate an API Token
Log in as the admin user.

Navigate to your Profile page from the top-right dropdown.

Click on the "API Tokens" menu item.

Click "Create New Token", give it a name (e.g., "nuxt-app"), select the permissions, and click Create.

Copy the token immediately. You will not be able to see it again.

🧪 Running Tests
This project uses PHPUnit for feature testing. To run the full test suite and ensure the API is working correctly, use the following Artisan command. This will use an in-memory SQLite database for speed and to avoid touching your local development database.

php artisan test

🔑 Using the Secure API
All API requests must include an Authorization header with your generated token.

Example Request:

GET /api/posts HTTP/1.1
Host: localhost:8000
Accept: application/json
Authorization: Bearer YOUR_API_TOKEN_HERE