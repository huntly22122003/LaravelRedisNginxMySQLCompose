<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\BulkShopifyController;
use App\Http\Controllers\ControllerProductShopify;
use App\Http\Controllers\OrderWebhookController;
use App\Http\Controllers\VariantShopifyNextJS;

Route::post('/bulk/products/import', [BulkShopifyController::class, 'import']);


//Products
Route::get('/products', [ControllerProductShopify::class, 'index']);
Route::post('/products', [ControllerProductShopify::class, 'store_NextJS']);
Route::put('/products/update', [ControllerProductShopify::class, 'update_NextJS']);

// Soft delete routes Product
Route::delete('/products/soft', [ControllerProductShopify::class, 'softDelete_NextJS']);
Route::get('/products/softdeleted', [ControllerProductShopify::class, 'softDeletedIndex']);
Route::delete('/products/{id}', [ControllerProductShopify::class, 'destroy_NextJS']);

//Webhooks
Route::get('/order-webhooks', [OrderWebhookController::class, 'index']);

//Variants
Route::prefix('products/{productId}/variants')->group(function () {
    Route::get('/', [VariantShopifyNextJS::class, 'index'])->name('shopify.variant');   // danh sách variant theo product
    Route::post('/', [VariantShopifyNextJS::class, 'store'])->name('variants.store');   // tạo mới variant
    Route::put('/{variantId}', [VariantShopifyNextJS::class, 'update'])->name('variants.update');  // cập nhật variant
    Route::delete('/{variantId}', [VariantShopifyNextJS::class, 'destroy'])->name('variants.destroy'); // xóa variant
});