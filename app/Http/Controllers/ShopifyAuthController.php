<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shopify;
use Illuminate\Support\Facades\Http;

class ShopifyAuthController extends Controller
{
    public function redirect(Request $request)
    {
        $shop = $request->get('shop'); // domain shop
        $apiKey = env('SHOPIFY_API_KEY');
        $scopes = env('SHOPIFY_API_SCOPES');
        $redirectUri = env('SHOPIFY_API_REDIRECT');

        $installUrl = "https://{$shop}/admin/oauth/authorize?client_id={$apiKey}&scope={$scopes}&redirect_uri={$redirectUri}";

        return redirect()->away($installUrl);
    }

    public function callback(Request $request)
    {
        $shop = $request->get('shop');
        $code = $request->get('code');

        $response = Http::post("https://{$shop}/admin/oauth/access_token", [
            'client_id' => env('SHOPIFY_API_KEY'),
            'client_secret' => env('SHOPIFY_API_SECRET'),
            'code' => $code,
        ]);

        $accessToken = $response->json()['access_token'];

        Shopify::updateOrCreate(
            ['domain' => $shop],
            ['access_token' => $accessToken, 'installed_at' => now()]
        );

        return "App installed successfully for {$shop}";
    }
}