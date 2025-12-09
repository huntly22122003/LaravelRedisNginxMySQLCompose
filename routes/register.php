<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AdminController;
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

//This is routes/login
Route::get('/login', [LoginController::class, 'showLogin'])->name('logn.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

//This is admin route
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard'); //view /admin/dashboard
Route::get('/admin/add', [AdminController::class, 'create'])->name('admin.users.create'); // view add user
Route::post('/admin/users/store', [AdminController::class, 'store'])->name('admin.users.store'); //store user
Route::post('/admin/users/{id}/update', [AdminController::class, 'update'])->name('admin.users.update'); //update user
Route::delete('/admin/users/{id}', [AdminController::class, 'delete'])->name('admin.users.delete'); //delete user
Route::post('/admin/users/{id}/assign-role', [AdminController::class, 'assignRole'])->name('admin.users.assignRole'); //view role

//This is routes/logout
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

//log in/ log out

Route::get('/website', function () {
    return view('website');
})->middleware('auth:shop')->name('website');

//Reset Password
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
