<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BulkShopifyService;

class BulkShopifyController extends Controller
{
    protected $service;

    public function __construct(BulkShopifyService $service)
    {
        $this->service = $service;
    }

    /**
     * Bulk Import Products
     */
    public function import(Request $request)
    {
        $productsJson = $request->input('products', '[]');
        $products = json_decode($productsJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON format'], 400);
        }

        $result = $this->service->importProducts($products);

        return response()->json($result);
    }

    /**
     * Bulk Export Products
     */
    public function export()
    {
        $products = $this->service->exportProducts();
        return view('shopify.BulkExport', compact('products'));
    }

    public function searchBulk(Request $request)
    {
        $keyword = (string) $request->input('q', '');
        $products = $keyword !== ''
            ? $this->service->searchProducts($keyword, (int) $request->input('limit', 10))
            : [];

        return view('shopify.BulkExport', compact('products', 'keyword'));
    }

}