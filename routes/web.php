<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MentorshipRequestController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/requests/send', [MentorshipRequestController::class, 'send']);
Route::get('/requests/incoming', [MentorshipRequestController::class, 'incoming']);
Route::post('/requests/{id}/accept', [MentorshipRequestController::class, 'accept']);
Route::post('/requests/{id}/reject', [MentorshipRequestController::class, 'reject']);

// Test form route (for web testing instead of Postman)
Route::get('/test-request', function () {
    return view('testform');
});

Route::post('/test-request', [MentorshipRequestController::class, 'send']);
