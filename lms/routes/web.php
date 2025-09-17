<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {

    // Dashboard View
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Course Controller
    Route::resource('courses', CourseController::class);

    // Lesson Controller
    Route::resource('courses.lessons', LessonController::class);

    // Enrollment Controller
    Route::get('courses/{course}/students', [EnrollmentController::class, 'manage'])->name('courses.students.manage');
    Route::post('courses/{course}/students', [EnrollmentController::class, 'addStudent'])->name('courses.students.add');
    Route::delete('courses/{course}/students/{student}', [EnrollmentController::class, 'removeStudent'])->name('courses.students.remove');
    Route::post('courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');
    Route::delete('courses/{course}/unenroll', [EnrollmentController::class, 'destroy'])->name('courses.unenroll');
    Route::get('my-courses', [EnrollmentController::class, 'myCourses'])->name('student.courses');

    // Assignment Controller
    Route::get('/courses/{course}/lessons/{lesson}/assignments/create', [AssignmentController::class, 'create'])
        ->name('courses.lessons.assignments.create');

    Route::resource('courses.lessons.assignments', AssignmentController::class);

    // Submission Controller
    Route::get('courses/{course}/lessons/{lesson}/assignments/{assignment}/submissions/create', [SubmissionController::class, 'create'])
        ->name('assignments.submissions.create');
    Route::post('courses/{course}/lessons/{lesson}/assignments/{assignment}/submissions', [SubmissionController::class, 'store'])
        ->name('assignments.submissions.store');
});






Route::middleware(['auth'])->group(function () {

    Route::middleware('auth')->group(function () {});

    // submit a solution (student)
    // Route::post('/assignments/{assignment}/submissions', [SubmissionController::class, 'store'])
    //     ->name('assignments.submissions.store');

    // grade a submission (instructor)
    Route::post('/submissions/{submission}/grade', [SubmissionController::class, 'grade'])
        ->name('submissions.grade');

    // optional: show a submission
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
});


require __DIR__ . '/auth.php';
