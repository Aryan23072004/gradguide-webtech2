<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MentorshipRequestController;
use Illuminate\Http\Request;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfessorController;

Route::get('/', function () {
    return view('welcome');
});

// Default Breeze dashboard (optional)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role-Based Dashboards
Route::middleware(['auth'])->group(function () {
    Route::view('/admin/dashboard', 'dashboards.admin')->name('admin.dashboard');
    Route::view('/mentor/dashboard', 'dashboards.mentor')->name('mentor.dashboard');
    Route::view('/student/dashboard', 'dashboards.student')->name('student.dashboard');
});

// Mentorship Request Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/requests/send', [MentorshipRequestController::class, 'send']);
    Route::get('/requests/incoming', [MentorshipRequestController::class, 'incoming']);
    Route::post('/requests/{id}/accept', [MentorshipRequestController::class, 'accept']);
    Route::post('/requests/{id}/reject', [MentorshipRequestController::class, 'reject']);
});

// Optional: Test form for sending mentorship request via UI (instead of Postman)
Route::get('/test-request', function () {
    return view('testform');
});
Route::post('/test-request', [MentorshipRequestController::class, 'send']);

require __DIR__.'/auth.php';

use App\Http\Controllers\FeedbackController;

Route::middleware('auth')->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});
use App\Http\Controllers\ReviewController;

Route::middleware(['auth'])->group(function () {
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Course Routes (public)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');

// Professor Routes (public)
Route::get('/professors', [ProfessorController::class, 'index'])->name('professors.index');
Route::get('/professors/{id}', [ProfessorController::class, 'show'])->name('professors.show');

