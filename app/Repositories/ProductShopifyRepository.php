<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Models\Shopify;

class ProductShopifyRepository
{
    protected $shop;
    protected $token;

    public function __construct()
    {
        // Lấy record đầu tiên trong bảng Shopify (hoặc bạn có thể tìm theo user_id)
        $shopify = Shopify::first();

        if ($shopify) {
            $this->shop = $shopify->domain;   // cột shop_domain trong DB
            $this->token = $shopify->access_token; // cột access_token trong DB
        }
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

    public function createProduct(array $data)
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->post("https://{$this->shop}/admin/api/2025-01/products.json", [
            'product' => $data
        ]);

        return $response->json('product') ?? null;
    }
}