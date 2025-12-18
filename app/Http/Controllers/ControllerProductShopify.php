<?php

namespace App\Http\Controllers;

use App\Services\ProductShopifyService;
use Illuminate\Http\Request;

class ControllerProductShopify extends Controller
{
    protected $service;

    public function __construct(ProductShopifyService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $products = $this->service->listProducts(10);
        $shopify = \App\Models\Shopify::first();
        $token = $shopify ? $shopify->access_token : null;

        // gọi đúng view
        return view('shopify.products', compact('products', 'token'));

    }

    public function store(Request $request)
    {
        $product = $this->service->addProduct(
            $request->input('title'),
            $request->input('price')
        );

        return redirect()->route('products.index')
                         ->with('success', 'Product created: '.$product['title']);
    }
}