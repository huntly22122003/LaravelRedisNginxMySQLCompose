<?php

namespace App\Http\Controllers;

use App\Services\ShopifyService;
use Illuminate\Http\Request;

class ShopifyCheckController extends Controller
{
    protected $service;

    public function __construct(ShopifyService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $domain = $request->get('shop', 'shophungly.myshopify.com');
        $result = $this->service->checkConnection($domain);

        return view('shopify.check', compact('result'));
    }
}