<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/test.php';
require __DIR__.'/register.php';