<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MentorshipRequestController;
use Illuminate\Http\Request;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;

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
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{id}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Comment Routes
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Course Routes (public)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/search-suggestions', [CourseController::class, 'searchSuggestions'])->name('courses.suggestions');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Professor Routes (public)
Route::get('/professors', [ProfessorController::class, 'index'])->name('professors.index');
Route::get('/professors/search-suggestions', [ProfessorController::class, 'searchSuggestions'])->name('professors.suggestions');
Route::get('/professors/{id}', [ProfessorController::class, 'show'])->name('professors.show');

// Review Routes (public search suggestions)
Route::get('/reviews/search-suggestions', [ReviewController::class, 'searchSuggestions'])->name('reviews.suggestions');

// Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::post('/admin/users/{id}/toggle', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');
    Route::get('/admin/reviews', [AdminController::class, 'reviews'])->name('admin.reviews.index');
    Route::delete('/admin/reviews/{id}', [AdminController::class, 'deleteReview'])->name('admin.reviews.delete');
    Route::get('/admin/comments', [AdminController::class, 'comments'])->name('admin.comments.index');
    Route::delete('/admin/comments/{id}', [AdminController::class, 'deleteComment'])->name('admin.comments.delete');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports.index');
    Route::post('/admin/reports/{id}/resolve', [AdminController::class, 'resolveReport'])->name('admin.reports.resolve');
    Route::delete('/admin/reports/{id}/content', [AdminController::class, 'deleteReportedContent'])->name('admin.reports.delete-content');
});

// Report Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/my', [ReportController::class, 'myReports'])->name('reports.my');
});

