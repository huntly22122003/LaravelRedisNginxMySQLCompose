<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyController;
use App\Http\Controllers\ControllerProductShopify;
use App\Http\Controllers\VariantShopifyController;
use App\Http\Controllers\BulkShopifyController;
use App\Http\Controllers\OrderWebhookController;


//OAuth routes
Route::get('/install', [ShopifyController::class, 'install'])->name('shopify.install');
Route::get('/auth/shopify/callback', [ShopifyController::class, 'oauthCallback'])->name('shopify.callback');
Route::match(['get', 'post', 'put', 'patch', 'delete'], '/shopify/session',
    [ShopifyController::class, 'storeSession']
)->name('shopify.session');



//Product routes
Route::get('/products', [ControllerProductShopify::class, 'index'])->name('products.index');
Route::post('/products', [ControllerProductShopify::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ControllerProductShopify::class, 'edit'])->name('products.edit');
Route::put('/products/update', [ControllerProductShopify::class, 'update'])->name('products.update');


// Soft delete routes Product
Route::delete('/products/soft', [ControllerProductShopify::class, 'softDelete'])->name('products.softDelete');
Route::get('/products/softdeleted', [ControllerProductShopify::class, 'softDeletedIndex'])->name('products.softDeletedIndex');
Route::delete('/products/{id}', [ControllerProductShopify::class, 'destroy'])->name('products.destroy');


//Variant routes
Route::prefix('products/{productId}/variants')->group(function () {
    Route::get('/', [VariantShopifyController::class, 'index'])->name('shopify.variant');   // danh sách variant theo product
    Route::post('/', [VariantShopifyController::class, 'store'])->name('variants.store');   // tạo mới variant
    Route::get('/{variantId}/edit', [VariantShopifyController::class, 'edit'])->name('variants.edit'); // form sửa variant
    Route::put('/{variantId}', [VariantShopifyController::class, 'update'])->name('variants.update');  // cập nhật variant
    Route::delete('/{variantId}', [VariantShopifyController::class, 'destroy'])->name('variants.destroy'); // xóa variant
});

Route::view('/shopify/BulkShopify', 'shopify.BulkShopify')->name('shopify.bulkshopify'); // hiển thị view BulkShopify
Route::get('/bulk/products/export', [BulkShopifyController::class, 'export'])->name('bulk.products.export');
Route::post('/bulk/products/import', [BulkShopifyController::class, 'import'])->name('bulk.products.import');
Route::get('/bulk/products/search', [BulkShopifyController::class, 'searchBulk'])->name('bulk.products.search');

//webhook order view
Route::get('/order-webhooks', [OrderWebhookController::class, 'index'])->name('order.webhooks.index');
Route::post('/webhooks/orders/create', [OrderWebhookController::class, 'store'])->name('webhooks.orders.create');

//NextJS
Route::get('/shopify/session-nextjs', [ShopifyController::class,'SessionNextJS'])->name('shopify.session.nextjs');

