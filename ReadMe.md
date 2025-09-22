# LMS Project

**Tech Stack:** Laravel 12 + Blade + Vue 3 + Tailwind CSS + Vite

**Project Type:** Monolithic LMS application with role-based access, notifications, dashboards, and responsive UI.

---

## Branching Strategy

- **main** → النسخة النهائية للتسليم  
- **feature/<name>** → لكل ميزة فرع خاص  
- **hotfix/<name>** → لإصلاح عاجل بعد التسليم  

**Workflow:**  
Branches  → feature/* → test → merge → main  
Commits → descriptive, صغيرة وواضحة  
UI → Blade + Vue + Tailwind (responsive)  
Seeders + Factories → بيانات تجريبية للاختبار  

---

## Features & Branches

| Branch | Features / Tasks |
|--------|-----------------|
| feature/setup-project | Laravel project setup, .env config, Laravel Breeze (Blade + Tailwind + Vite), Vue 3 components, migrations, storage symlink |
| feature/auth-roles | Role field for users, Gates & Policies, seeders for admin/instructor/student, role-based login |
| feature/database-schema | Models & migrations: Course, Lesson, Enrollment, Assignment, Submission, relationships, factories, seeders |
| feature/courses-crud | CourseController CRUD, Blade views, routes, validation, eager loading, UX improvements |
| feature/lessons-crud | LessonController CRUD (nested), file upload (PDF/Video/Docs), Blade UI |
| feature/enrollments | Student enrollment system (attach/detach), course listing, Gates protection, Blade UI |
| feature/assignments | Assignment creation, submission, grading workflow, display status |
| feature/notifications | Database + Mail notifications, MailHog, Vue toast integration, notifications for submissions and grading |
| feature/dashboard | Dashboards for Admin / Instructor / Student, stats, Vue/Chart.js charts |
| feature/ui-polish | Dark/Light mode toggle, responsive design, unified success/error messages, reusable Blade components |
| feature/error-logging | Custom exception handler, error pages, log channels, event logging for critical actions |
| feature/docs | README, screenshots, API documentation, Git workflow explanation |

---

## Database Design

**Models & Relationships:**

- **User** → `hasMany` Enrollments, `hasMany` Submissions, `role` for authorization  
- **Course** → `belongsTo` Instructor, `hasMany` Lessons, `hasMany` Enrollments  
- **Lesson** → `belongsTo` Course, `hasMany` Assignments  
- **Enrollment** → pivot table: Student ↔ Course  
- **Assignment** → `belongsTo` Lesson, `created_by` Instructor, `hasMany` Submissions  
- **Submission** → `belongsTo` Student & Assignment  

**Performance:** Used `with()` (eager loading) for relationships to reduce queries.

---

## Authentication & Authorization

- **Authentication:** Laravel Breeze (Blade)  
- **Authorization:** Gates & Policies by `role`  
  - **Admin:** manage all courses, lessons, assignments  
  - **Instructor:** manage own courses, lessons, assignments  
  - **Student:** enroll in courses, submit assignments, view status  
- Routes protected via middleware & Gates to ensure proper access.

---

## Frontend & UI/UX

- **Blade + Tailwind + Vue 3**  
- Responsive for desktop, tablet, mobile  
- Vue components for charts 
- Dark/Light Mode toggle (saved in LocalStorage)  
- Unified messages and smooth navigation for better UX

---

## Dashboards

- **Admin Dashboard:** students, courses, assignments, student activity  
- **Instructor Dashboard:** own courses, assignments, grading  
- **Student Dashboard:** enrolled courses, assignment status, notifications  

---

## Notifications

- Database & Mail notifications with MailHog (local testing)  
- Vue toast notifications  
- Triggered when:  
  - Student submits an assignment  
  - Instructor grades an assignment  
- Options to mark single/all notifications as read

---

## Integration & Additional Features

- Frontend ↔ Backend fully integrated  
- Advanced search for courses and assignments  
- File uploads (PDF/Video/Docs)  
- Responsive & Dark/Light mode  
- Error handling & logging  
- Event notifications

---

## GitHub Repository

- **Repository Structure:** main, feature/*, hotfix/*  
- **Commit Messages:** small, clear, descriptive  
- **README.md:** includes installation, screenshots, API documentation, Git workflow  

---

## Installation

```bash
# Clone repository
git clone <repository-url>
cd lms-project

# Install PHP dependencies
composer install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Run migrations and seeders
php artisan migrate --seed

# Install Node dependencies (Vue 3 + Tailwind + Vite)
npm install

# Build assets and start dev server
npm run dev

# Optionally, serve the application
php artisan serve

