
🎓 E-Learning Management System (Laravel Platform)
🧠 Project Overview

This project is a full-featured e-learning platform built with Laravel, designed to simulate a real-world educational system. It allows administrators to manage the system, instructors to manage their courses and students, and students to enroll in courses and take exams.

The system is built with a clean role-based architecture and includes real-time notifications, dynamic dashboards, and a complete exam lifecycle system.

#Screens:
<img width="1366" height="768" alt="Screenshot (174)" src="https://github.com/user-attachments/assets/3ce11ce2-8764-44da-a62f-d31eeeeaf41c" />
<img width="1366" height="768" alt="Screenshot (173)" src="https://github.com/user-attachments/assets/09c46c09-1bd2-413f-9fe6-7161db43e81d" />
<img width="1366" height="768" alt="Screenshot (172)" src="https://github.com/user-attachments/assets/cb3b018f-a716-4395-9e61-83d3f8603247" />
<img width="1366" height="768" alt="Screenshot (171)" src="https://github.com/user-attachments/assets/968c0aa0-5bb7-4bb0-8b71-2a3b45cde603" />
<img width="1366" height="768" alt="Screenshot (170)" src="https://github.com/user-attachments/assets/0d782a10-3847-47b0-83a5-45a1d98f3291" />
<img width="1366" height="768" alt="Screenshot (169)" src="https://github.com/user-attachments/assets/473f6af0-d70a-44b2-bf0f-3e1dd8f8d17e" />
<img width="1366" height="768" alt="Screenshot (168)" src="https://github.com/user-attachments/assets/64b299f7-7333-49e0-af6b-c94ab36156ef" />
<img width="1366" height="768" alt="Screenshot (167)" src="https://github.com/user-attachments/assets/d295cc3d-ffb3-42d6-b445-5b5adc2a2241" />
<img width="1366" height="768" alt="Screenshot (166)" src="https://github.com/user-attachments/assets/c6e20cf3-5cde-486c-8c66-6e92269e4574" />
<img width="1366" height="768" alt="Screenshot (165)" src="https://github.com/user-attachments/assets/e23716d6-e37b-4a7b-878e-ea59e70fbd25" />
<img width="1366" height="768" alt="Screenshot (164)" src="https://github.com/user-attachments/assets/0a9522aa-1325-4635-bb3a-99f4accdc98b" />
<img width="1366" height="768" alt="Screenshot (163)" src="https://github.com/user-attachments/assets/65879d26-3000-4af0-97f4-bd1377710d3e" />
<img width="1366" height="768" alt="Screenshot (162)" src="https://github.com/user-attachments/assets/41240e80-f10c-4716-8d9e-36ee2380de79" />
<img width="1366" height="768" alt="Screenshot (161)" src="https://github.com/user-attachments/assets/b675a799-87d1-4e4d-b3d5-9fc30a984c64" />
<img width="1366" height="768" alt="Screenshot (160)" src="https://github.com/user-attachments/assets/782fe63b-8167-4ddb-95d4-0bf8c3f2f8f1" />
<img width="1366" height="768" alt="Screenshot (159)" src="https://github.com/user-attachments/assets/7aecbdef-7817-452a-bcdd-60809f17b30a" />
<img width="1366" height="768" alt="Screenshot (158)" src="https://github.com/user-attachments/assets/afec7b88-e7d7-4463-8654-28f569cf388b" />
<img width="1366" height="768" alt="Screenshot (157)" src="https://github.com/user-attachments/assets/9ed5fea9-ac9c-41b5-8498-1870e8c9b7d9" />
<img width="1366" height="768" alt="Screenshot (156)" src="https://github.com/user-attachments/assets/7003d8f6-ab8c-49b9-882e-e2742e5d2a9f" />


🏗 System Architecture

The system is divided into 3 main roles:

👑 Admin
Full system access

Manage users (students & instructors)

Manage courses globally

View all data and analytics

👨‍🏫 Instructor

Manage own courses only

View enrolled students

Create and manage exams

Track student performance

Instructor dashboard with analytics

🎓 Student

Browse enrolled courses

Access course content

Take exams

View results and performance history

📚 Core Features

📌 Course Management System

Create, 

update, 

delete courses

Assign courses to instructors

Filter courses per instructor
Course categories support
Students enrollment system (Many-to-Many)
👥 User & Role Management
Role-based system using Spatie Permission
Admin / Instructor / Student roles
Middleware protection for routes
Dynamic dashboards per role
📝 Exam System (Full Workflow)
Exam Structure:
Exams linked to courses
Multiple questions per exam
Multiple-choice answers (MCQ)
Exam Process:
Student starts exam → ExamAttempt created
Answers stored in ExamAnswer table
Exam submitted → score calculated
Attempt saved with results
Features:
Track started & ended time
Store student answers
Calculate score automatically
View detailed exam history
📊 Dashboards System
👑 Admin Dashboard:
Total users
Total courses
System-wide analytics
👨‍🏫 Instructor Dashboard:
My courses count
My students count
Revenue estimation
Latest courses
Performance charts using Chart.js
🔔 Notification System (Real-Time)
Notifications for:
New student enrolled in course
Exam submission
Payment events (if enabled)
Database notifications
Real-time broadcast using Pusher
Mark as read / unread system
🔐 Authentication & Authorization
Laravel authentication system
Spatie Roles & Permissions
Middleware protection:
role:admin
role:instructor
Secure route access control
🔗 Database Relationships
Users ↔️ Courses (Many-to-Many for students)
Instructor → Courses (One-to-Many)
Courses → Exams (One-to-Many)
Exams → Questions (One-to-Many)
ExamAttempts → Answers (One-to-Many)
📈 Analytics & Charts
Instructor performance dashboard
Students per course tracking
Revenue estimation
Chart.js integration for visualization
🎨 UI / UX
Blade templating system
Tailwind CSS modern UI
Role-based navigation menus
Responsive dashboard layout
Clean card-based design system
⚙️ Technical Highlights
MVC architecture
Clean controller separation
Form Request validation
Eloquent ORM relationships
Dynamic role-based queries
Middleware access control
Notification system (event-driven)
🚀 What Makes This Project Strong

 Full real-world e-learning system
 Multi-role architecture (Admin / Instructor / Student)
 Complete exam engine (attempts, scoring, tracking)
 Real-time notifications (Pusher integration)
 Role-based dashboards with analytics
 Secure backend with Spatie permissions
 Scalable database design

🧩 Future Improvements
Live video classes integration
Zoom / meeting system
AI-based exam correction
Advanced analytics dashboard
Mobile app (Flutter / React Native)
Payment system integration
🏁 Conclusion

This project demonstrates a complete scalable e-learning platform with real-world architecture, including role-based access control, exam systems, real-time notifications, and dynamic dashboards. It showcases strong backend engineering skills using Laravel and modern web development practices
