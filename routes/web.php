<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuotaController;





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
Route::get('/admin/quotas', [QuotaController::class, 'index'])->name('admin.quota.index'); // Admin-specific quota route


// Supervisor Dashboard
Route::get('/supervisor/dashboard', [DashboardController::class, 'supervisorDashboard'])->name('supervisor.dashboard')->middleware('auth');

// Student Dashboard
Route::get('/student/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard')->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/Quota', [QuotaController::class, 'index'])->name('quota.index'); // View quotas
    Route::get('/quota/create', [QuotaController::class, 'create'])->name('quota.create'); // Create new quota
    Route::post('/quota', [QuotaController::class, 'store'])->name('quota.store'); // Save new quota
    Route::get('/quota/{id}/edit', [QuotaController::class, 'edit'])->name('quota.edit'); // Edit quota
    Route::put('/quota/{id}', [QuotaController::class, 'update'])->name('quota.update'); // Update quota
    Route::delete('/quota/{id}', [QuotaController::class, 'destroy'])->name('quota.destroy'); // Delete quota
});

Route::middleware(['auth'])->group(function () {
    Route::get('/timeframes', [TimeFrameController::class, 'index'])->name('timeframes.index');
    Route::get('/timeframes/create', [TimeFrameController::class, 'create'])->name('timeframes.create');
    Route::post('/timeframes', [TimeFrameController::class, 'store'])->name('timeframes.store');
    Route::get('/timeframes/{id}/edit', [TimeFrameController::class, 'edit'])->name('timeframes.edit');
    Route::put('/timeframes/{id}', [TimeFrameController::class, 'update'])->name('timeframes.update');
    Route::delete('/timeframes/{id}', [TimeFrameController::class, 'destroy'])->name('timeframes.destroy');
});






Route::get('/upload-users', function () {
    return view('admin.upload_users');
})->name('users.upload');
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::post('/admin/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/admin/users/{id}/update', [UserController::class, 'update'])->name('users.update');
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::post('/upload-users', [UserController::class, 'store'])->name('users.store');

Route::get('/admin/reports/users', [ReportController::class, 'userReport'])->name('reports.users');
Route::get('/admin/reports/users/export', [ReportController::class, 'exportUserReport'])->name('reports.users.export');
