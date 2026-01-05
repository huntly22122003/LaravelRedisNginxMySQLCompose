<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Repositories\ShopifyRepository;

class ShopifyService
{
    protected $shopifyRepo;

    public function __construct(ShopifyRepository $shopifyRepo)
    {
        $this->shopifyRepo = $shopifyRepo;
    }

    /**
     * Handle Shopify OAuth callback
     */
    public function handleOAuthCallback(Request $request): ?array
    {
        // 1. Verify HMAC
        if (!$this->verifyHmac($request->query())) {
            abort(401, 'Invalid Shopify HMAC');
        }

        $shop = $request->get('shop');
        $code = $request->get('code');

        if (!$shop || !$code) {
            return null;
        }

        // 2. Exchange code -> access token
        $response = Http::asJson()->post(
            "https://{$shop}/admin/oauth/access_token",
            [
                'client_id'     => config('shopify.shopify.key'),
                'client_secret' => config('shopify.shopify.secret'),
                'code'          => $code,
            ]
        );

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        // 3. Store shop + access_token vào DB
        $shopModel = $this->shopifyRepo->storeOrUpdate([
            'domain'        => $shop,
            'access_token'  => $data['access_token'],
            'scope'         => $data['scope'] ?? null,
        ]);

        // 4. Đăng ký webhook orders/create
        Http::withHeaders([
            'X-Shopify-Access-Token' => $data['access_token'],
        ])->post("https://{$shop}/admin/api/2025-01/webhooks.json", [
            'webhook' => [
                'topic'   => 'orders/create',
                'address' => url('/webhooks/orders/create'),
                'format'  => 'json',
            ],
        ]);

        return [
            'shop' => $shopModel->domain,
            'data' => $data,
        ];
    }

    /**
     * Lấy shop từ session -> DB
     * DÙNG CHO route /shopify/session
     */
    public function storeSession()
    {
        $shop = $this->shopifyRepo->getFirstShop();

        if (!$shop) {
            return null;
        }

        return [
            'shop' => $shop->domain,
            'data' => [
                'access_token' => $shop->access_token,
                'scope'        => $shop->scope,
            ],
        ];
    }

    /**
     * Verify Shopify OAuth HMAC
     */
    protected function verifyHmac(array $query): bool
    {
        $hmac = $query['hmac'] ?? null;

        unset($query['hmac'], $query['signature']);

        ksort($query);

        $calculated = hash_hmac(
            'sha256',
            urldecode(http_build_query($query)),
            config('shopify.shopify.secret')
        );

        return hash_equals($hmac, $calculated);
    }
}