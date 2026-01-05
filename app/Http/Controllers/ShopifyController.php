<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShopifyService;
use App\Http\Controllers\ControllerProductShopify;

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
        $shop = $result['shop'];
        $data = $result['data'];

        $productData = app(ControllerProductShopify::class)->index();
        $productSoftdelete = app(ControllerProductShopify::class)->softDeletedIndex();
        $firstProductId = $products[0]['id'] ?? null;
        if ($firstProductId) {
            $variantData = app(VariantShopifyController::class)->index($firstProductId);
            $variants = $variantData['variants'];
        } else {
            $variants = [];
        }
        $products = $productData['products'];
        $softDelete = $productSoftdelete['softDelete'];
        if ($result) {
            return view('shopify.success', [
            'shop' => $shop,
            'data' => $data,
            'products' => $products,
            'softDelete' => $softDelete,
            'variants' => $variants,
        ]);

        }

        return redirect()->back()->with('error', 'No Shopify data found.');
    }

}
