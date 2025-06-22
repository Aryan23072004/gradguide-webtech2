# GradGuide — Laravel Role-Based Dashboard System

GradGuide is a Laravel-based web application with role-based dashboards for Admin, Mentor, and Student. Built with Laravel 12, Breeze, Tailwind CSS, and role authentication logic.

---

## ✅ Features

- Laravel Breeze authentication (login/register)
- Role-based redirect after login:
  - Admin → `/admin/dashboard`
  - Mentor → `/mentor/dashboard`
  - Student → `/student/dashboard`
- Dynamic navbar with role, profile, and logout
- Profile management (edit name, email, password)
- Clean Blade templating using `@extends` and `@yield`

---

## 🧑‍💻 Roles and Test Users

| Role    | Email                   | Password     |
|---------|-------------------------|--------------|
| Admin   | admin@gradguide.com     | admin123     |
| Mentor  | mentor@gradguide.com    | mentor123    |
| Student | student@gradguide.com   | student123   |

To manually add users, use Laravel Tinker:
```bash
php artisan tinker

php

\App\Models\User::create([
  'name' => 'Admin User',
  'email' => 'admin@gradguide.com',
  'password' => bcrypt('admin123'),
  'role' => 'admin'
]);

 Setup instructions 
 1.Clone the repo
 git clone https://github.com/Aryan23072004/gradguide-webtech2.git
cd gradguide-webtech2


2. Install Dependencies
composer install
npm install


3. Environment Setup

cp .env.example .env
php artisan key:generate
Edit .env file with your DB settings:
DB_DATABASE=gradguide
DB_USERNAME=root
DB_PASSWORD=yourpassword

4. Run Migrations
php artisan migrate

5. Start Dev Servers
php artisan serve
npm run dev
Visit the app at: http://localhost:8000

Stack
Laravel 12

Laravel Breeze

Tailwind CSS

MySQL

PHP 8.3+

Vite




