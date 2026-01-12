<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotifyController;

Route::post('/notify', [NotifyController::class, 'store']);
