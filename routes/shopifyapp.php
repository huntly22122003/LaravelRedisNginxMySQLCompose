<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyController;
use App\Http\Controllers\ControllerProductShopify;

Route::get('/install', [ShopifyController::class, 'install'])->name('shopify.install');
Route::get('/shopify/callback', [ShopifyController::class, 'oauthCallback'])->name('shopify.callback');

Route::get('/products', [ControllerProductShopify::class, 'index'])->name('products.index');
Route::post('/products', [ControllerProductShopify::class, 'store'])->name('products.store');