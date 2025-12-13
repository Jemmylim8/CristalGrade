# CristalGrade

CristalGrade is a **web-based grading and academic record management system** developed as a **capstone research project** for the Computer Studies Department of Cristal e-College. The system is designed to provide a secure, organized, and reliable platform for managing student grades, class records, and academic monitoring.

This repository contains the official implementation used for research evaluation and institutional review.

---

## 📌 Project Description

Traditional grading processes often rely on manual computation, spreadsheets, or fragmented tools, which may lead to errors, delayed feedback, and limited accessibility. CristalGrade addresses these challenges by centralizing grade management into a single web-based system with clear role separation and controlled access.

The system allows **faculty members** to manage grades and class records, while **students are limited to viewing their academic information only**.

---

## 🎯 Objectives

* To develop a centralized web-based grading system for the department
* To ensure secure and role-based access to academic records
* To reduce errors in grade computation and record keeping
* To provide timely access to academic performance information
* To support academic monitoring through absence and compliance notifications

---

## 👥 User Roles and Access

### Faculty

* Create and manage class records
* Input, update, and review student grades
* View student score history per class
* Monitor attendance and compliance status

### Students

* View enrolled classes
* View grades or performance results (read-only)
* Access score history related to their academic activities

### Administrator (Optional / Future)

* Manage system users
* Oversee system configuration and data integrity

---

## ✨ Core Features

* Secure authentication and authorization
* Role-based access control (Faculty and Students)
* Class and subject management
* Grade input and editing (Faculty only)
* Student grade viewing (Read-only)
* Score history tracking
* Absence and compliance notification system
* Responsive and user-friendly interface
* Attendance and Excuse Letter submission with approval

---

## 🛠️ Technology Stack

* **Backend:** Laravel (PHP)
* **Frontend:** Blade Templates, HTML, CSS, JavaScript
* **Database:** MySQL
* **Architecture:** MVC (Model-View-Controller)
* **Authentication:** Laravel Authentication System

---

## 🏗️ System Architecture

CristalGrade follows the **MVC architecture**:

* **Models:** Handle data structure and database interaction
* **Views:** Blade templates for user interface presentation
* **Controllers:** Handle application logic and request processing

This structure ensures maintainability, scalability, and separation of concerns.

---

## 📂 Project Structure

```
cristalgrade/
├── app/            # Controllers, Models, Policies
├── database/       # Migrations and seeders
├── resources/      # Blade views, CSS, JavaScript
├── routes/         # Web routes
├── public/         # Public assets
└── README.md       # Project documentation
```

---

## 🚀 Installation and Setup

1. Clone the repository

   ```bash
   git clone <repository-url>
   ```

2. Install dependencies

   ```bash
   composer install
   npm install
   ```

3. Configure environment variables

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure the database and run migrations

   ```bash
   php artisan migrate
   ```

5. Start the development server

   ```bash
   php artisan serve
   ```

---

## 🔐 Security Considerations

* All users must be authenticated to access the system
* Students are restricted to read-only access for grades
* Faculty permissions are required to modify academic records
* Server-side validation and access control are enforced

---

## 📄 Research Context

CristalGrade was developed in partial fulfillment of the requirements for the Research Capstone of the Computer Studies Department. The system is intended for academic evaluation, research documentation, and possible institutional deployment.

---

## ⚠️ Limitations

* Requires an active internet connection
* Available for desktops only
* Advanced analytics and reporting are not included in the current version

---

## 🔮 Future Enhancements

* Advanced grade analytics and reporting
* Data visualization dashboards
* Enhanced mobile responsiveness
* Integration with other academic systems

---

## 📜 License and Usage

This system is developed for Cristal-e College. Commercial use or redistribution requires formal approval from the developers.

---

## 👨‍💻 Development Team

Stallion Dynamics Research Team
* **Jemmy Lim II - Senior Developer**
* **Schlwyn Sarabia - Junior Developer**
* **Justin Bolotaulo - Documentation Chairman**

---

*CristalGrade – A Secure and Modern Web-Based Grading System*
