<?php

namespace App\Services;

use App\Repositories\ShopifyRepository;
use Illuminate\Support\Facades\Http;

class ShopifyService
{
    protected $repository;

    public function __construct(ShopifyRepository $repository)
    {
        $this->repository = $repository;
    }

   public function handleOAuthCallback($request)
{
    $shop = $request->get('shop');
    $code = $request->get('code');

    // Bước 1: gọi API lấy access_token
    $response = Http::post("https://{$shop}/admin/oauth/access_token", [
        'client_id' => config('shopify.shopify.key'),
        'client_secret' => config('shopify.shopify.secret'),
        'code' => $code,
    ]);

    if ($response->successful()) 
        {
            $data = $response->json();

            // Bước 2: gọi thêm API lấy scope thực tế
            $responseScopes = Http::withHeaders([
                'X-Shopify-Access-Token' => $data['access_token'],
            ])->get("https://{$shop}/admin/oauth/access_scopes.json");

            $scopes = null;
            if ($responseScopes->successful()) {
                $scopes = collect($responseScopes->json()['access_scopes'])
                    ->pluck('handle')
                    ->implode(',');
            }
            else {
                // fallback: gán scope mặc định nếu cần test
                $scopes = 'read_products,write_products';
            }


            // Bước 3: lưu cả token và scope vào DB
            $this->repository->storeOrUpdate([
                'domain' => $shop,
                'access_token' => $data['access_token'],
                'scope' => $scopes,
            ]);

            return [
                'shop' => $shop,
                'data' => [
                    'access_token' => $data['access_token'],
                    'scope' => $scopes,
                ],
            ];
        }

        return false;
    }
}