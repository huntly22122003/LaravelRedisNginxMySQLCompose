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
    public function searchProducts(string $keyword = '', int $limit = 50)
    {
        // Lấy products từ Shopify với limit
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->get("https://{$this->shop}/admin/api/2025-01/products.json", [
            'limit' => $limit,
        ]);

        $products = $response->json('products') ?? [];

        $keyword = trim(mb_strtolower($keyword));

        // Nếu không có keyword hoặc 'all' → trả đúng số product theo limit
        if ($keyword === '' || $keyword === 'all') {
            return array_slice($products, 0, $limit);
        }

        // Keyword có giá trị → lọc theo từng từ trong keyword
        $words = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);

        $filtered = array_filter($products, function ($p) use ($words) {
            $title  = mb_strtolower($p['title'] ?? '');
            $vendor = mb_strtolower($p['vendor'] ?? '');

            // ✅ Tất cả từ trong keyword phải xuất hiện (AND logic)
            foreach ($words as $word) {
                if (!str_contains($title, $word) && !str_contains($vendor, $word)) {
                    return false;
                }
            }

            return true;
        });

        // Giới hạn kết quả
        return array_slice(array_values($filtered), 0, $limit);
    }


}