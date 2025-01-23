# Youdemy - Online Course Platform

## Overview
Youdemy is an interactive and personalized online course platform designed for students and teachers. It enables users to explore, manage, and enroll in courses while offering robust administrative tools for effective platform management.

---

## Features

### Front Office

#### Visitor
- Browse the course catalog with pagination.
- Search for courses by keywords.
- Create an account and choose a role (Student or Teacher).

#### Student
- View and search courses in the catalog.
- Access detailed course information (description, content, teacher details, etc.).
- Enroll in courses (after logging in).
- Access a "My Courses" section for enrolled courses.

#### Teacher
- Create new courses with:
  - Title, description, content (video or document), tags, and category.
- Manage courses:
  - Edit, delete, and track course enrollments.
- View a "Statistics" section:
  - Number of enrolled students.
  - Total number of created courses.

---

### Back Office

#### Administrator
- Validate teacher accounts.
- Manage users:
  - Activate, suspend, or delete accounts.
- Manage content:
  - Courses, categories, and tags.
  - Bulk tag insertion for efficiency.
- Access global statistics:
  - Total courses.
  - Category distribution.
  - Most popular course (highest enrollments).
  - Top 3 teachers based on performance.

---

### Shared Features
- Each course supports multiple tags (many-to-many relationship).
- Polymorphic implementation for adding and displaying courses.
- Authentication and authorization system to secure sensitive routes.
- Access control: Role-based feature availability.

---

## Technical Specifications
- **Object-Oriented Programming (OOP):** Encapsulation, inheritance, and polymorphism are utilized.
- **Database Management:**
  - Relational database with one-to-many and many-to-many relationships.
- **Session Management:** PHP sessions for user authentication and state management.
- **Data Validation:** 
  - Client-side validation using HTML5 and JavaScript.
  - Server-side validation with protections against XSS, CSRF, and SQL injection.
- **Security Measures:**
  - Prepared statements for database interactions.
  - Input sanitization and escaping to prevent malicious injections.

---

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/ahmedbenkrarayc/youdemy.git
   cd youdemy
