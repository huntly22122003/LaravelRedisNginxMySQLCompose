<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Http;
use App\Models\Shopify;

class VariantShopifyRepository
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
     public function getVariants($productId)
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->get("https://{$this->shop}/admin/api/2025-01/products/{$productId}/variants.json");

        return $response->json('variants') ?? [];
    }

    public function createVariant($productId, array $data)
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->post("https://{$this->shop}/admin/api/2025-01/products/{$productId}/variants.json", [
            'variant' => $data
        ]);

        return $response->json('variant') ?? null;
    }

    public function updateVariant($productId, $variantId, array $data)
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->put("https://{$this->shop}/admin/api/2025-01/products/{$productId}/variants/{$variantId}.json", [
            'variant' => $data
        ]);

        return $response->json('variant') ?? null;
    }

    public function deleteVariant($productId, $variantId)
    {
        return Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
        ])->delete("https://{$this->shop}/admin/api/2025-01/products/{$productId}/variants/{$variantId}.json");
    }
}
