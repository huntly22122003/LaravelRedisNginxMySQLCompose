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

        // Lấy danh sách sản phẩm
        $products = $service->listProducts(10);


        return [
        'products' => $products,
        'token' => $token,
        ];

    }

    public function store(Request $request)
    {
         $title = $request->input('title');
        $price = $request->input('price');
        $isNotifyActive = $request->input('is_notify_active');
        $product = $this->service->addProduct($title, $price, $isNotifyActive);
        return redirect()->route('shopify.session');
    }

    public function store_NextJS(Request $request)
    {
        $title = $request->input('title');
        $price = $request->input('price');
        $isNotifyActive = $request->input('is_notify_active');
        $product = $this->service->addProduct($title, $price, $isNotifyActive);
        return ['message'=>'success'];
    }

    public function edit($id)
    {
        $product = $this->service->getProduct($id);
        $shopify = \App\Models\Shopify::first();
        $token = $shopify ? $shopify->access_token : null;

        return view('shopify.products_edit', compact('product', 'token'));
    }

    public function update_NextJS(Request $request)
    {
        $id = $request->input('id');
        $product = $this->service->updateProduct(
            $id,
            $request->input('title'),
            $request->input('price')
        );
        return ['message'=>'success'];
    }

    public function update(Request $request)
    {
        $id = $request->input('id'); // lấy id từ hidden input

        $product = $this->service->updateProduct(
            $id,
            $request->input('title'),
            $request->input('price')
        );

        return redirect()->route('shopify.session');
    }

    public function softDelete(Request $request)
    {   
        $id = $request->input('id');
        $this->service->softDeleteProduct($id);
        return redirect()->route('shopify.session');
    }
    public function destroy(Request $request) // hard deleteproducts.softDelete
    {
        $id = $request->input('id');
        $this->service->deleteProduct($id);

        return redirect()->route('shopify.session');
    }
    public function softDeletedIndex()
    {
        $products = $this->service->listSoftDeleted();
        return [
            'softDelete' => $products,
        ];
    }
    public function softDelete_NextJS(Request $request)
    {
        $id = $request->input('id');
        $this->service->softDeleteProduct($id);
        return ['message' =>'success'];
    }
    public function destroy_NextJS($id) // hard deleteproducts.softDelete
    {
        $this->service->deleteProduct($id);
        return ['message' =>'success'];
    }
}