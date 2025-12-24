<?php
namespace App\Repositories;

use App\Models\Shopify;
use Illuminate\Support\Facades\Http;

class BulkShopifyRepository
{
    protected $shop;
    protected $token;

    public function __construct(?string $domain = null)
    {
        $shopify = $domain
            ? Shopify::where('domain', $domain)->firstOrFail()
            : Shopify::firstOrFail();

        $this->shop = $shopify->domain;
        $this->token = $shopify->access_token;
    }

    protected function getHeaders()
    {
        return [
            'X-Shopify-Access-Token' => $this->token,
            'Content-Type' => 'application/json'
        ];
    }

    public function bulkImport(array $products)
    {
       $results = [];
        foreach ($products as $product) {
            $response = Http::withHeaders($this->getHeaders())
                ->post("https://{$this->shop}/admin/api/2025-01/products.json", [
                    'product' => $product // phải là 'product' (số ít)
                ]);

            $results[] = $response->json();
        }

        return $results;

    }

    public function bulkExport()
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get("https://{$this->shop}/admin/api/2025-01/products.json");

        return $response->json('products');
    }
    public function searchProducts(string $keyword, int $limit = 50)
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->get("https://{$this->shop}/admin/api/2025-01/products.json", [
            'limit' => $limit,
        ]);

        $products = $response->json('products') ?? [];
        if (trim($keyword) === 'all') {
        return $products;
        }

        $keyword = mb_strtolower(trim($keyword));

        return array_values(array_filter($products, function ($p) use ($keyword) {
            $title  = mb_strtolower($p['title'] ?? '');
            $vendor = mb_strtolower($p['vendor'] ?? '');
            return $keyword === '' ? true : (str_contains($title, $keyword) || str_contains($vendor, $keyword));
        }));
    }
}