<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentController;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/h', [EnrollmentController::class, 'myCourses']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// 🛡️ نخليها محمية بالـ auth
Route::middleware(['auth'])->group(function () {
    
    // 📚 مسارات الكورسات
    Route::resource('courses', CourseController::class);
    Route::resource('courses.lessons', LessonController::class);

    
});


require __DIR__.'/auth.php';
