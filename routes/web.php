<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ShowAttendanceController;


// Authentication Routes
// Route to show the registration form
Route::get('/register', [LoginController::class, 'register'])->name('register');

// Route to handle the registration form submission
Route::post('/signup', [LoginController::class, 'signup'])->name('signup');

// Route to show the login form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route to handle the login form submission
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

// Additional routes...

Route::get('/dash', [LoginController::class, 'showdash'])->name('dash');



Route::middleware(['auth'])->group(function () {
    Route::post('/mark-attendance', [AttendanceController::class, 'markAttendance'])
        ->name('mark.attendance');

    // routes/web.php


Route::post('/mark-attendance', [AttendanceController::class, 'markAttendance'])->name('mark-attendance');

Route::get('/show-attendance', [ShowAttendanceController::class, 'showAttendance'])->name('show.attendance');

});
