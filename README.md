# 🎓 EduStream - Online Course Platform

## 📋 Overview

EduStream is an online course management and enrollment platform built with vanilla PHP using MVC (Model-View-Controller) architecture. The project provides a complete solution for managing courses, student enrollments, and online payments.

## ✨ Key Features

### For Students

- 🔐 **Registration & Login**: User authentication system with bcrypt password hashing
- 📚 **Course Catalog**: Browse and filter courses by categories
- 🔍 **AJAX Search**: Fast course search with auto-suggestions
- 📖 **Course Details**: View detailed information about courses, instructors, and pricing
- 🛒 **Shopping Cart**: Add multiple courses to cart before checkout
- 💳 **Course Enrollment**: Enroll in and manage registered courses
- 📝 **My Courses**: View list of enrolled courses
- 📧 **Contact**: Send messages to administrators

### For Administrators

- 👥 **User Management**: Student/admin role management
- 📊 **Course Management**: CRUD operations with SEO-friendly slug URLs
- 🗂️ **Category Management**: Organize courses by categories
- 📍 **Location Management**: Link courses with learning locations

## 🛠️ Technology Stack

### Backend

- **PHP 7.4+**: Core programming language
- **MySQL 5.7+**: Database management system
- **PDO**: Database access library with prepared statements
- **MVC Architecture**: Separation of concerns (logic, data, presentation)

### Frontend

- **HTML5 & CSS3**: Structure and styling
- **JavaScript (Vanilla)**: Client-side interactions
- **AJAX**: Dynamic search and updates

### Server

- **Apache**: Web server with mod_rewrite
- **MAMP/XAMPP**: Local development environment

## 📁 Project Structure

```
WP-online-course/
│
├── app/
│   ├── controllers/          # Controllers handle business logic
│   │   ├── AuthController.php
│   │   ├── ContactController.php
│   │   ├── CoursesController.php
│   │   ├── HomeController.php
│   │   ├── SearchController.php
│   │   └── UserController.php
│   │
│   ├── core/                 # Core framework
│   │   ├── App.php           # Main router
│   │   ├── Controller.php    # Base Controller
│   │   ├── Database.php      # Database connection
│   │   └── init.php          # Application initialization
│   │
│   ├── models/               # Models handle data
│   │   ├── CartModel.php
│   │   ├── CourseModel.php
│   │   ├── EnrollmentModel.php
│   │   ├── SearchModel.php
│   │   └── UserModel.php
│   │
│   └── views/                # Views handle presentation
│       ├── auth/             # Login, Register
│       ├── cart/             # Shopping cart
│       ├── catalog/          # Course catalog
│       ├── contact/          # Contact page
│       ├── course_detail/    # Course details
│       ├── home/             # Homepage
│       ├── includes/         # Header, Footer
│       └── user/             # My courses
│
├── public/
│   ├── css/                  # Stylesheets
│   │   ├── auth.css
│   │   ├── cart.css
│   │   ├── catalog.css
│   │   ├── contact.css
│   │   ├── course_detail.css
│   │   ├── home.css
│   │   └── my-courses.css
│   │
│   └── js/                   # JavaScript files
│       ├── scripts.js
│       └── search-suggest.js
│
├── .htaccess                 # URL rewriting rules
├── index.php                 # Entry point
├── database.sql              # Database schema
├── database_add.sql          # Sample data
└── README.md                 # This file

```

## 🚀 Installation & Setup

### System Requirements

- PHP >= 7.4
- MySQL >= 5.7
- Apache with mod_rewrite enabled
- MAMP/XAMPP or similar environment

### Installation Steps

#### 1. Clone or Download the Project

```bash
git clone https://github.com/yourusername/WP-online-course.git
cd WP-online-course
```

#### 2. Configure Database Connection

Open `app/core/Database.php` and adjust the connection settings:

```php
private $host = 'localhost';
private $user = 'root';           // MySQL username
private $pass = 'root';           // MySQL password
private $dbname = 'online_course_platform';
private $port = '8889';           // MySQL port (3306 for XAMPP)
```

#### 3. Create Database

```bash
# Login to MySQL
mysql -u root -p

# Import database schema
mysql -u root -p < database.sql

# Import sample data (optional)
mysql -u root -p < database_add.sql
```

Or use phpMyAdmin:

1. Open phpMyAdmin
2. Create new database: `online_course_platform`
3. Import `database.sql` file
4. Import `database_add.sql` file (for sample data)

#### 4. Configure Apache

Ensure `mod_rewrite` is enabled and `.htaccess` is allowed:

```apache
<Directory "/path/to/WP-online-course">
    AllowOverride All
</Directory>
```

#### 5. Configure BASE_URL

Create or update `app/core/init.php` with the appropriate BASE_URL:

```php
define('BASE_URL', 'http://localhost:8888/WP-online-course');
```

#### 6. Run the Application

Access: `http://localhost:8888/WP-online-course` (adjust port according to your configuration)

## 🗄️ Database Schema

### Main Tables

#### `users` - Users

```sql
user_id (PK)
full_name
email (UNIQUE)
password_hash (bcrypt)
role (student/admin)
created_at
```

#### `courses` - Courses

```sql
course_id (PK)
title
slug (UNIQUE)
instructor
description
price
rating
category_id (FK)
location_id (FK)
image_url
created_at
```

#### `categories` - Categories

```sql
category_id (PK)
category_name
description
created_at
```

#### `enrollments` - Enrollments

```sql
enrollment_id (PK)
user_id (FK)
course_id (FK)
enrolled_at
UNIQUE(user_id, course_id)
```

#### `locations` - Locations

```sql
location_id (PK)
location_name
address
map_link
created_at
```

## 📖 Usage Guide

### Routing

The system uses URL pattern:

```
http://domain.com/{controller}/{method}/{params}
```

**Examples:**

- `/` - Homepage (HomeController::index)
- `/courses` - Course catalog (CoursesController::index)
- `/courses/category/programming` - Courses by category
- `/courses/detail/learn-php` - Course details
- `/auth/login` - Login
- `/auth/register` - Register
- `/cart` - Shopping cart
- `/user/my-courses` - My courses

### Creating a New Controller

```php
<?php
class YourController extends Controller {

    public function index() {
        $model = $this->model('YourModel');
        $data = ['title' => 'Page Title'];
        $this->view('your_view/view_file', $data);
    }
}
```

### Creating a New Model

```php
<?php
class YourModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getData() {
        $this->db->query('SELECT * FROM your_table');
        return $this->db->resultSet();
    }
}
```

## 🔒 Security

- ✅ Password encryption with `password_hash()` (bcrypt)
- ✅ Prepared Statements with PDO to prevent SQL Injection
- ✅ Input filtering and validation
- ✅ Session management for authentication
- ✅ CSRF protection (can be extended)

## 🎯 Future Enhancement Ideas

- [ ] Admin dashboard
- [ ] Lesson and video management
- [ ] Course rating and review system
- [ ] Payment gateway integration (VNPay, MoMo, Stripe)
- [ ] Email notifications
- [ ] Course completion certificates
- [ ] Discussion forum for each course
- [ ] Responsive design optimization
- [ ] RESTful API for mobile app

## 🤝 Contributing

Contributions are welcome! Please:

1. Fork the project
2. Create a new branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 🙏 Acknowledgments

- Thanks to the PHP community
- Libraries and frameworks that inspired this project

---

⭐ If you find this project helpful, please give it a star!
