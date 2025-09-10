# Laravel Application

A modern Laravel application built with Domain-Driven Design (DDD) principles, featuring a product quotation system with user management and role-based permissions.

##  Features

- **Domain-Driven Architecture**: Organized into separate domains (User, Admin, Company, Product, Quotation, Authentication)
- **Product Management**: Full CRUD operations for products with supplier relationships
- **Media Management**: File uploads and media handling with Spatie Media Library
- **User Authentication**: Built with Laravel Sanctum
- **Role-Based Permissions**: Comprehensive permission system using Spatie Laravel Permission
- **Modern Frontend**: Vue.js 3 with Inertia.js for seamless SPA experience
- **Styling**: Tailwind CSS for modern, responsive design
- **Queue System**: Background job processing with database queue driver

## ️ Tech Stack

### Backend
- **PHP 8.2+**
- **Laravel 12.28.1**
- **MySQL** Database
- **Laravel Sanctum** for API authentication
- **Spatie Media Library** for file management
- **Spatie Laravel Permission** for role management

### Frontend
- **Vue.js 3.4.27**
- **Inertia.js 2.0** for SPA functionality
- **Tailwind CSS 3.4** for styling
- **Vite 7.1** for asset bundling
- **Axios** for HTTP requests

### Development Tools
- **Laravel Sail** for Docker development environment
- **Laravel Breeze** for authentication scaffolding
- **PHPUnit** for testing
- **Mockery** for mocking in tests
- **Laravel Pint** for code formatting

##  Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL
- Docker (optional, for Laravel Sail)

##  Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd <project-name>
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database** in the `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Seed the database** (if seeders are available)
   ```bash
   php artisan db:seed
   ```

## ‍️ Running the Application

### Development (All services at once)
```bash
composer run dev
```
