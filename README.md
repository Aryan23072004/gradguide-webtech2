# GradGuide - Student Course & Professor Review Platform

A comprehensive web application built with Laravel that allows students to rate and review courses and professors, fostering a supportive academic community.

## Features

### For Students
- **Browse Courses**: Search and view all available courses with ratings and reviews
- **Browse Professors**: Find professors and see their teaching ratings and reviews
- **Write Reviews**: Create detailed reviews for courses and professors
- **Comment System**: Engage with other students by commenting on reviews
- **Report Content**: Report inappropriate reviews or comments
- **Personal Dashboard**: Manage your own reviews and track your reports

### For Administrators
- **Admin Dashboard**: Overview of platform statistics and recent activity
- **User Management**: View and manage user accounts
- **Content Moderation**: Review and manage reported content
- **Review Management**: Monitor and delete inappropriate reviews
- **Comment Management**: Oversee comment activity and remove problematic content

### Core Functionality
- **User Authentication**: Secure login/registration system
- **Role-Based Access**: Different permissions for students and admins
- **Search & Filter**: Find courses and professors easily
- **Rating System**: 1-5 star rating system with visual distribution
- **Pagination**: Handle large amounts of content efficiently
- **Responsive Design**: Works on desktop and mobile devices

## Technology Stack

- **Backend**: PHP 8.1+ with Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Blade Templates
- **Authentication**: Laravel Breeze
- **Styling**: Tailwind CSS

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd gradguide-webtech2
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update `.env` file with your database credentials
   - Run migrations: `php artisan migrate`
   - Seed the database: `php artisan db:seed`

5. **Start the development server**
   ```bash
   php artisan serve
   ```

## Database Structure

### Main Tables
- **users**: User accounts with role-based permissions
- **courses**: Course information and details
- **professors**: Professor information and departments
- **reviews**: Student reviews for courses and professors
- **comments**: Comments on reviews
- **reports**: User reports for inappropriate content

### Relationships
- Users can have multiple reviews and comments
- Courses belong to professors
- Reviews belong to users, courses, and professors
- Comments belong to users and reviews
- Reports can be for reviews or comments

## Usage Examples

### Student Workflow
1. Register/Login to the platform
2. Browse courses or professors
3. Read existing reviews and ratings
4. Write your own review with rating and comments
5. Comment on other students' reviews
6. Report inappropriate content if needed

### Admin Workflow
1. Access admin dashboard
2. Monitor platform statistics
3. Review reported content
4. Manage users and content
5. Resolve reports and take action

## API Endpoints

### Public Routes
- `GET /` - Welcome page
- `GET /courses` - List all courses
- `GET /courses/{id}` - View specific course
- `GET /professors` - List all professors
- `GET /professors/{id}` - View specific professor

### Authenticated Routes
- `GET /dashboard` - User dashboard
- `GET /reviews` - List all reviews
- `POST /reviews` - Create new review
- `GET /reviews/create` - Review creation form
- `GET /reviews/{id}` - View specific review
- `PUT /reviews/{id}` - Update review
- `DELETE /reviews/{id}` - Delete review

### Admin Routes
- `GET /admin` - Admin dashboard
- `GET /admin/users` - Manage users
- `GET /admin/reviews` - Manage reviews
- `GET /admin/comments` - Manage comments
- `GET /admin/reports` - Manage reports

## Contributing

This project was developed as a Web Technologies assignment by:
- **Aryan** - Course and Review functionality
- **Muneeb** - Professor and Admin functionality

## License

This project is for educational purposes as part of a Web Technologies course.

## Support

For technical support or questions, please contact the development team.

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




