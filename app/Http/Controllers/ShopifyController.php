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
            // Lưu vào session để lấy domain kiếm token trong db
            session(['shop_domain' => $result['shop']]);
            return redirect('https://admin.shopify.com/store/justastore-9748/apps/runcode');
            ///return view('shopify.success', [ 
            ///'shop' => $result['shop'],
            ///'data' => $result['data'],
            ///]);

        }

        return response()->json(['error' => 'OAuth failed'], 400);
    }
    
    public function storeSession()
    {
        $result = $this->service->storeSession();

        if ($result) {
            return view('shopify.success', [
            'shop' => $result['shop'],
            'data' => $result['data'],
        ]);

        }

        return redirect()->back()->with('error', 'No Shopify data found.');
    }

}
