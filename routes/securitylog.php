<?php
use App\Http\Controllers\SecurityLogController;

Route::get('/security-logs', [SecurityLogController::class, 'index'])
     ->name('security.logs');
