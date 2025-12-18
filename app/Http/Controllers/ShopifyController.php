<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShopifyService;

class ShopifyController extends Controller
{
    protected $service;

    public function __construct(ShopifyService $service)
    {
        $this->service = $service;
    }

    public function install(Request $request)
    {
        $shop = $request->get('shop');
        $scopes = 'read_products,write_orders'; // quyền bạn cần
        $redirectUri = route('shopify.callback');

        $installUrl = "https://{$shop}/admin/oauth/authorize?" . http_build_query([
            'client_id' => config('shopify.shopify.key'),
            'scope' => $scopes,
            'redirect_uri' => $redirectUri,
            'state' => csrf_token(),
        ]);

        return redirect()->away($installUrl);
    }
    public function oauthCallback(Request $request)
    {
        $result = $this->service->handleOAuthCallback($request);

        if ($result) {
            return view('shopify.success', [
            'shop' => $result['shop'],
            'data' => $result['data'],
        ]);

        }

        return response()->json(['error' => 'OAuth failed'], 400);
    }
}