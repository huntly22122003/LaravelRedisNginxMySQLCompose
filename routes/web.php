<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/hello', function()
{
    return response()->json(['message'=>"Test Backend"]);
});
Route::get('/logic', function()
{
    return response()->json(['message'=>"Test Backend"]);
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
 //   Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
 //   Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';*/
require __DIR__.'/register.php';
require __DIR__.'/updateUser.php';
require __DIR__.'/task.php';
require __DIR__.'/securitylog.php';
require __DIR__.'/shopifyapp.php';
