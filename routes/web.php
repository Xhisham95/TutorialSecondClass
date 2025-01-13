<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Post Routes (if still needed for posts)
Route::resource('posts', App\Http\Controllers\PostController::class);

// User Management Routes for Module 1
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index'); // View all users
    Route::get('/create', [UserController::class, 'create'])->name('create'); // Show upload form
    Route::post('/store', [UserController::class, 'store'])->name('store'); // Store users in bulk
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit'); // Edit user
    Route::put('/{id}', [UserController::class, 'update'])->name('update'); // Update user
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy'); // Delete user
    Route::get('/report', [UserController::class, 'generateReport'])->name('report'); // Generate user report
    Route::post('/assign', [UserController::class, 'assignLecturers'])->name('assign'); // Assign lecturers to students
});
