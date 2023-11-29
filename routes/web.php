<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

