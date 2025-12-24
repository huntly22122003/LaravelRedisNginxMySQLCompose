<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Models\Shopify;
use App\Models\ShopifySoftDeleteProduct;

class ProductShopifyRepository
{
    protected $shop;
    protected $token;

    public function __construct(?string $domain = null) // lấy token từ database
    {
        $shopify = $domain
            ? Shopify::where('domain', $domain)->firstOrFail()
            : Shopify::firstOrFail();

        if ($shopify) {
            $this->shop = $shopify->domain;
            $this->token = $shopify->access_token;
        }
    }
    public function getToken()
    {
        return $this->token;
    }

    public function getProducts($limit = 10)
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->get("https://{$this->shop}/admin/api/2025-01/products.json", [
            'limit' => $limit
        ]);

        return $response->json('products') ?? [];
    }

    public function getProduct($id)
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->get("https://{$this->shop}/admin/api/2025-01/products/{$id}.json");

        return $response->json('product') ?? null;
    }

    public function createProduct(array $data)
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->post("https://{$this->shop}/admin/api/2025-01/products.json", [
            'product' => $data
        ]);

        return $response->json('product') ?? null;
    }

    public function updateProduct($id, array $data)
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->put("https://{$this->shop}/admin/api/2025-01/products/{$id}.json", [
            'product' => $data
        ]);

        return $response->json('product') ?? null;
    }

    public function softDeleteProduct($id)
    {
       $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->get("https://{$this->shop}/admin/api/2025-01/products/{$id}.json");

        $product = $response->json('product');

        if ($product) {
            ShopifySoftDeleteProduct::create([
                'shopify_product_id' => $id,
                'payload' => json_encode($product),
            ]);
        }

        return true;

    }

    public function getsoftDeletedProducts()
    {
        return ShopifySoftDeleteProduct::all();
    }

    public function deleteProduct($id) // Xóa vĩnh viễn trên Shopify và xóa bản ghi soft delete trong DB
    {
         $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->delete("https://{$this->shop}/admin/api/2025-01/products/{$id}.json");

        if ($response->successful()) {
            ShopifySoftDeleteProduct::where('shopify_product_id', $id)->delete();
        }


        return $response->successful();

    }
}