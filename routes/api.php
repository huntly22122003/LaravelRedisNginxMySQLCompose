<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

Route::get('/health-check', function () {
    $status   = 'ok';
    $code     = 200;
    $services = [
        'db'    => 'ok',
        'redis' => 'ok',
    ];
    $errors   = [];

    // Kiểm tra DB
    try {
        DB::connection()->getPdo();
    } catch (\Exception $e) {
        $status        = 'error';
        $code          = 500;
        $services['db'] = 'fail';
        $errors['db']   = $e->getMessage();
    }

    // Kiểm tra Redis
    try {
        Redis::connection()->ping();
    } catch (\Exception $e) {
        $status           = 'error';
        $code             = 500;
        $services['redis'] = 'fail';
        $errors['redis']   = $e->getMessage();
    }

    return response()->json([
        'status'   => $status,
        'time'     => now()->toDateTimeString(),
        'services' => $services,
        'errors'   => $errors,
    ], $code);
});

require __DIR__.'/notify.php';
require __DIR__.'/nextjs_route.php';