<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Models\Shopify;
use App\Models\ShopifySoftDeleteProduct;
use App\Models\Product_Notify;

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
    public function shopifyRequest()
    {
        return Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ]);
    }

    public function getProducts($limit = 250)
    {
        $products = [];
        $pageInfo = null;

        do {
            $params = ['limit' => $limit];

            if ($pageInfo) {
                $params['page_info'] = $pageInfo;
            }

            $response = $this->shopifyRequest()->get(
                "https://{$this->shop}/admin/api/2025-01/products.json",
                $params
            );

            $products = array_merge(
                $products,
                $response->json('products') ?? []
            );

            $linkHeader = $response->header('Link');
            $pageInfo = null;

            if ($linkHeader && preg_match('/<[^>]*page_info=([^&>]+)[^>]*>; rel="next"/', $linkHeader, $matches)) {
                $pageInfo = $matches[1];
            }

        } while ($pageInfo);
        return $products;
    }

    public function getProduct($id)
    {
        $response = $this->shopifyRequest()->get("https://{$this->shop}/admin/api/2025-01/products/{$id}.json");

        return $response->json('product') ?? null;
    }

    public function createProduct(array $data,$isNotify)
    {
        $response = $this->shopifyRequest()->post("https://{$this->shop}/admin/api/2025-01/products.json", [
            'product' => $data
        ]);
        $product = $response->json('product') ?? null;
        $id = $product['id'] ?? null;
        if($isNotify)
        {
            $this->createProductNotify($id);
        }
        return $product;
    }
    public function createProductNotify($productId)
    {
        return Product_Notify::create([
        'product_id' => $productId,
        'is_notify_active' => true
        ]);

    }

    public function updateProduct($id, array $data)
    {
        $response = $this->shopifyRequest()->put("https://{$this->shop}/admin/api/2025-01/products/{$id}.json", [
            'product' => $data
        ]);

        return $response->json('product') ?? null;
    }

    public function softDeleteProduct($id)
    {
       $response = $this->shopifyRequest()->get("https://{$this->shop}/admin/api/2025-01/products/{$id}.json");

        $product = $response->json('product');

        if($response->failed())
            return false; // failed() out status 200-299 successful() status 200-299 -> Method Laravel HTTP Client illuminate\Support\Facades\Http

        if ($product) {
            ShopifySoftDeleteProduct::create([
                'shopify_product_id' => $id,
                'payload' => json_encode($product),
            ]);
        }

        return true;

    }

    public function getsoftDeletedProduct()
    {
        return ShopifySoftDeleteProduct::all();
    }
    public function getAllSoftDeleteProduct()
    {
       return ShopifySoftDeleteProduct::all()->map(function ($item) {
        $payload = json_decode($item->payload, true);
        return [
            'id' => $item->shopify_product_id,
            'title' => $payload['title'] ?? null,
            'price' => $payload['variants'][0]['price'] ?? null,
        ];
        });
    }   

    public function deleteProduct($id) // Xóa vĩnh viễn trên Shopify và xóa bản ghi soft delete trong DB
    {
         $response = $this->shopifyRequest()->delete("https://{$this->shop}/admin/api/2025-01/products/{$id}.json");

        if ($response->successful()) {
            ShopifySoftDeleteProduct::where('shopify_product_id', $id)->delete();
        }


        return $response->successful();

    }
}