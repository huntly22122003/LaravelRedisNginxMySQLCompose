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
       // Lấy domain từ session (được set sau OAuth callback)
        $domain = session('shop_domain');
        // Khởi tạo service với domain cụ thể
        $service = app(ProductShopifyService::class, ['domain' => $domain]);

        // Lấy danh sách sản phẩm
        $products = $service->listProducts(10);

        // Lấy token qua service (không gọi Model trực tiếp)
        $token = $service->getToken();
;

        // Lấy danh sách sản phẩm
        $products = $service->listProducts(10);


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

    public function edit($id)
    {
        $product = $this->service->getProduct($id);
        $shopify = \App\Models\Shopify::first();
        $token = $shopify ? $shopify->access_token : null;

        return view('shopify.products_edit', compact('product', 'token'));
    }

    public function update(Request $request, $id)
    {
        $product = $this->service->updateProduct(
            $id,
            $request->input('title'),
            $request->input('price')
        );

        return redirect()->route('products.index')
                         ->with('success', 'Product updated: '.$product['title']);
    }

    public function softDelete($id)
    {
        $this->service->softDeleteProduct($id);
        return redirect()->route('products.index')
                         ->with('success', 'Product soft deleted');
    }

    public function softDeletedIndex()
    {
        $products = $this->service->listSoftDeleted();
        return view('shopify.products_softdelete', compact('products'));
    }

    public function destroy($id) // hard deleteproducts.softDelete
    {
        $this->service->deleteProduct($id);

        return redirect()->route('products.index')
                         ->with('success', 'Product deleted');
    }
}