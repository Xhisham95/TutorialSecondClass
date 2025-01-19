<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimeFrameController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\AppointmentController;


Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes for changing passwords
Route::get('/password/change', [PasswordChangeController::class, 'edit'])->name('password.change');
Route::post('/password/change', [PasswordChangeController::class, 'update'])->name('password.update');

// Group routes with `auth` and `CheckPasswordChanged` middleware
Route::middleware(['auth', \App\Http\Middleware\CheckPasswordChanged::class])->group(function () {
    // Dashboard Routes
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/supervisor/dashboard', [DashboardController::class, 'supervisorDashboard'])->name('supervisor.dashboard');
    Route::get('/student/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard');

    // Quota Routes
    Route::get('/Quota', [QuotaController::class, 'index'])->name('quota.index');
    Route::get('/quota/create', [QuotaController::class, 'create'])->name('quota.create');
    Route::post('/quota', [QuotaController::class, 'store'])->name('quota.store');
    Route::get('/quota/{id}/edit', [QuotaController::class, 'edit'])->name('quota.edit');
    Route::put('/quota/{id}', [QuotaController::class, 'update'])->name('quota.update');
    Route::delete('/quota/{id}', [QuotaController::class, 'destroy'])->name('quota.destroy');

    // Timeframe Routes
    Route::get('/timeframes', [TimeFrameController::class, 'index'])->name('timeframes.index');
    Route::get('/timeframes/create', [TimeFrameController::class, 'create'])->name('timeframes.create');
    Route::post('/timeframes', [TimeFrameController::class, 'store'])->name('timeframes.store');
    Route::get('/timeframes/{id}/edit', [TimeFrameController::class, 'edit'])->name('timeframes.edit');
    Route::put('/timeframes/{id}', [TimeFrameController::class, 'update'])->name('timeframes.update');
    Route::delete('/timeframes/{id}', [TimeFrameController::class, 'destroy'])->name('timeframes.destroy');

    // User Routes
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/admin/users/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Report Routes
    Route::get('/admin/reports/users', [ReportController::class, 'userReport'])->name('reports.users');
    Route::get('/admin/reports/users/export', [ReportController::class, 'exportUserReport'])->name('reports.users.export');
    Route::get('/admin/reports/users/export/pdf', [ReportController::class, 'exportUserReportPDF'])->name('reports.users.export.pdf');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'manageAppointments'])->name('appointments.index');
});
