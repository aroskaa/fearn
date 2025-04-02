<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CourseController as PublicCourseController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Public Course Routes
Route::get('/courses', [PublicCourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [PublicCourseController::class, 'show'])->name('courses.show');

// Auth Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Course related authenticated routes
    Route::get('/my-courses', [PublicCourseController::class, 'myCourses'])->name('my-courses');
    Route::post('/courses/{course}/enroll', [PublicCourseController::class, 'enroll'])->name('courses.enroll');
    Route::get('/courses/{course}/lessons/{lesson}', [PublicCourseController::class, 'showLesson'])->name('courses.lessons.show');
});

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Category Management
    Route::resource('categories', CategoryController::class);
    
    // Level Management
    Route::resource('levels', LevelController::class);
    
    // Course Management
    Route::resource('courses', CourseController::class);
    Route::patch('courses/{course}/status', [CourseController::class, 'updateStatus'])
        ->name('courses.update-status');
    
    // Lesson Management (nested under courses)
    Route::resource('courses.lessons', LessonController::class);
    Route::patch('courses/{course}/lessons/{lesson}/status', [LessonController::class, 'updateStatus'])
        ->name('courses.lessons.update-status');
    Route::post('courses/{course}/lessons/reorder', [LessonController::class, 'reorder'])
        ->name('courses.lessons.reorder');
});

require __DIR__.'/auth.php';
