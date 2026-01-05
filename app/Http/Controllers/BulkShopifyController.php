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
        return response()->json($products);
    }

    public function searchBulk(Request $request)
    {
        $keyword = (string) $request->input('q', '');
        $limit = (int) $request->input('limit', 10);
         $products = $this->service->searchProducts($keyword, $limit);

        return response()->json([
        'data' => $products,
    ]);
    }

}