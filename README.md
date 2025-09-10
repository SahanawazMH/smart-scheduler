# 📅 Smart Timetable Scheduler

An intelligent, automated timetabling system designed to solve the complex scheduling challenges faced by educational institutions.  
This application leverages a sophisticated, constraint-based algorithm to generate optimized, conflict-free timetables, saving significant administrative effort and maximizing resource utilization.

---

## ✨ Key Features

### 👑 Admin Panel
- **Complete Data Management:** Full CRUD control over all institutional data (Buildings, Classrooms, Courses, Sections, Subjects, etc.).  
- **Constraint Definition:** Easily assign subjects to teachers and set weekly unavailability slots.  
- **One-Click Generation:** Trigger the powerful scheduling algorithm to generate a complete timetable in moments.  
- **Conflict Reporting:** Get immediate feedback on any classes that could not be scheduled.  
- **Dynamic & Filterable Views:** View the final timetable from the perspective of a specific teacher, section, or classroom.  

### 👨‍🏫 Teacher & 🧑‍🎓 Student Panels
- **Secure, Role-Based Access:** Dedicated and secure dashboards for each role.  
- **Personalized Timetables:** Users can only see their own personal, easy-to-read weekly schedule.  
- **Responsive Design:** Clean, modern, and fully responsive interface that works on any device.  
- **Profile Management:** Allows users to securely change their own passwords.  

---

## 🧠 Core Algorithm Explained

The "brain" of the application is a `TimetableService` class that uses a **multi-stage heuristic process**:

1. **Initialization:** Loads all data and constraints from the database into memory.  
2. **Class Pool Creation:** Builds a master list of every single 1-hour session that needs to be scheduled.  
3. **Intelligent Placement Engine:** Iterates through every class in the pool, systematically searching for a valid slot by running a series of critical conflict checks:  
   - ✅ Teacher, Room, and Section availability  
   - ✅ Teacher unavailability constraints  
   - ✅ Continuous class counter (prevents >4 hours of continuous classes)  
   - ✅ Protected lunch break window  
4. **Saving & Reporting:** Successful placements are saved to the database, and any unschedulable classes are returned in a conflict report.  

---

## 🛠️ Technology Stack

- **Backend:** PHP 8.1, Laravel 10 Framework  
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5.1  
- **Database:** MySQL  
- **Authentication:** Custom Role-Based Middleware  

---

## 🚀 Local Installation Guide

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/your-username/smart-timetable-scheduler.git
cd smart-timetable-scheduler

### 2️⃣ Install Dependencies
composer install
npm install
npm run build

### 3️⃣ Environment Setup

Copy the .env.example file to .env:

cp .env.example .env


Generate an application key:

php artisan key:generate


Update your database credentials (DB_DATABASE, DB_USERNAME, DB_PASSWORD) in the .env file.

### 4️⃣ Run Migrations & Seed Database

This will create tables and populate them with demo data, including an admin account:

php artisan migrate --seed

### 5️⃣ Serve the Application
php artisan serve

🔑 Default Login Credentials

Role: Admin

Email: admin@example.com

Password: password

👉 Student and teacher accounts can be created via the Admin Panel.