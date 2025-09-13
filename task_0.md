🎯 الهدف

بناء Learning Management System (LMS) بسيط باستخدام:

Backend: Laravel 12

Frontend: Vue 3 + Inertia + Tailwind CSS

Database: MySQL (أو PostgreSQL)

المشروع يحتوي على:

Users (Admin, Instructor, Student).

Courses, Lessons, Enrollments, Assignments.

Features: Auth, CRUD, File Uploads, Notifications, Dashboard, Dark/Light mode.

🌱 Git Branching Strategy

main → النسخة النهائية للتسليم.

develop → التطوير الأساسي.

feature/... → كل ميزة (CRUD, Auth, Dashboard) لها فرع خاص.

🗂️ خطة العمل بالتفصيل
1. feature/setup-project

الخطوات:

أنشئ مشروع Laravel جديد:

laravel new lms-project


ادخل للمشروع وثبّت Breeze (مع Inertia + Vue + Tailwind):

composer require laravel/breeze --dev
php artisan breeze:install vue
npm install && npm run dev
php artisan migrate


عدّل ملف .env وأضف قاعدة بيانات جديدة (مثلاً lms_db).

Commits:

chore: install Laravel 12 and setup base project

chore: configure .env for local environment

chore: install Laravel Breeze with Inertia + Vue + Tailwind

2. feature/auth-roles

الخطوات:

أضف حقل role لجدول users:

php artisan make:migration add_role_to_users_table


القيم: admin, instructor, student.

استخدم Policies & Gates للتحكم في الصلاحيات.

مثال: Gate::define('manage-courses', fn($user) => $user->role === 'instructor');

Commits:

feat: add role field to users table

feat: implement role-based authorization with Gates & Policies

test: add seeders for admin, instructor, and student users

3. feature/database-schema

الخطوات:

أنشئ الموديلات + الـ migrations:

Course (belongsTo Instructor, hasMany Lessons).

Lesson (belongsTo Course).

Enrollment (pivot table بين Student و Course).

Assignment (belongsTo Student, belongsTo Course).

أضف Factories + Seeders لتوليد بيانات تجريبية.

Commits:

feat: create courses and lessons migrations + models

feat: create enrollments pivot table

feat: create assignments table with file upload support

chore: add factories and seeders for testing data

4. feature/courses-crud

الخطوات:

أنشئ CourseController:

php artisan make:controller CourseController --resource


أضف CRUD (إنشاء/عرض/تحديث/حذف كورس).

اربط الـ Vue Pages مع الـ Controller باستخدام Inertia.

Commits:

feat: add course CRUD controllers and routes

feat: implement Vue pages for managing courses

fix: improve validation rules for course creation

5. feature/lessons-crud

الخطوات:

أنشئ LessonController (resource).

أضف خاصية رفع ملفات (مثل PDF أو فيديو).

اربط الدروس بالكورسات.

Commits:

feat: add lesson CRUD controllers and routes

feat: implement file upload for lessons

feat: add Vue UI for lessons management

6. feature/enrollments

الخطوات:

أنشئ واجهة لتسجيل الطلاب في الكورسات.

أضف علاقات Many-to-Many (Student ↔ Courses).

اعرض كورسات الطالب في لوحة الطالب.

Commits:

feat: implement student enrollments system

feat: add Vue UI for student course enrollments

7. feature/assignments

الخطوات:

الطالب يرفع واجب (ملف).

المدرس يضيف تقييم/درجة.

إشعارات ترسل عند رفع أو تقييم واجب.

Commits:

feat: add assignment submission with file upload

feat: implement grading system for assignments

feat: trigger notifications on assignment submission and grading

8. feature/notifications

الخطوات:

استخدم Laravel Notifications (database + mail).

MailHog لتجربة الرسائل.

Vue Toasts (مثلاً vue-toastification) للتنبيهات في الواجهة.

Commits:

feat: implement database notifications

feat: add mail notifications with MailHog

feat: integrate Vue toast notifications for frontend feedback

9. feature/dashboard

الخطوات:

أضف لوحة تحكم Admin.

استخدم Chart.js أو ApexCharts.

اعرض إحصائيات: عدد الطلاب، عدد الدورات، نسبة الواجبات.

Commits:

feat: implement admin dashboard with charts

feat: add course and student statistics

style: enhance dashboard UI with Tailwind

10. feature/ui-polish

الخطوات:

أضف Dark/Light Mode toggle.

حسن التصميم ليكون Responsive.

وحد مظهر التنبيهات + الرسائل.

Commits:

style: implement dark/light mode toggle

style: improve responsive design across pages

refactor: clean up UI components

11. feature/docs

الخطوات:

اكتب README (طريقة التنصيب + الاستخدام).

وثّق الـ API (لو كان عندك SPA).

جهّز Screenshots للعرض.

Commits:

docs: add project README with setup instructions

docs: add API documentation

docs: add screenshots for demo

✅ خطة العمل

كل ميزة تبدأ من develop → فرع جديد feature/... → تعمل Commits منظمة → تدمج بالـ develop.

بعد انتهاء المشروع كله → دمج develop → main (نسخة التسليم).