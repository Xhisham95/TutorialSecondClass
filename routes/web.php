<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return 'Login successful! Welcome to the dashboard.';
})->name('dashboard')->middleware('auth');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
use App\Http\Controllers\DashboardController;

// Admin Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('auth');

// Supervisor Dashboard
Route::get('/supervisor/dashboard', [DashboardController::class, 'supervisorDashboard'])->name('supervisor.dashboard')->middleware('auth');

// Student Dashboard
Route::get('/student/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard')->middleware('auth');

