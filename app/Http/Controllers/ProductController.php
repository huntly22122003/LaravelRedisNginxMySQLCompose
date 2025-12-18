<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index()
    {
        $domain = app('shopify.domain');
        $token  = app('shopify.token');

        $res = Http::withHeaders([
            'X-Shopify-Access-Token' => $token,s
        ])->get("https://{$domain}/admin/api/" . config('services.shopify.api_version') . "/products.json", [
            'limit' => 50,
        ]);

        abort_if($res->failed(), 502, 'Shopify API error');
        return response()->json($res->json());
    }
}
