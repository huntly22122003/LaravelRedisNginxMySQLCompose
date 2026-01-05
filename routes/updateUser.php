<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpdateUserController;
use App\Http\Controllers\UpdateUserPassword;
//Update information
Route::get('/updateUser', [UpdateUserController::class,'showUpdateUser'])->name('updateuser.form');
Route::post('/updateUser',[UpdateUserController::class, 'updateUserProfile'])->name('updateuser'); //to form

//Update password
Route::post('/updatePassword', [UpdateUserPassword::class, 'UpdateUserPasswords'])->name('updateuserpassword');