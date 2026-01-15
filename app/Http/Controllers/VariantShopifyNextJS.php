<?php
namespace App\Http\Controllers;

use App\Services\VariantShopifyService;
use Illuminate\Http\Request;

class VariantShopifyNextJS extends Controller
{
    protected $service;

    public function __construct(VariantShopifyService $service)
    {
        $this->service = $service;
    }

    public function index($productId)
    {
        $variants = $this->service->listVariants($productId);
        $token = $this->service->getToken();
        return response()->json(
        [
            'variants' => $variants,
            'token' => $token,
            'productId' => $productId,
        ]);
    }

    public function store(Request $request, $productId)
    {
        $variant = $this->service->addVariant(
            $productId,
            $request->input('title'),
            $request->input('price'),
            $request->input('sku'),
            $request->input('option1')
        );

        return ['message'=>'success'];
    }

    public function update(Request $request, $productId, $variantId)
    {

        $variant = $this->service->updateVariant(
            $productId,
            $variantId,
            $request->only(['title','price','sku','option1'])
        );

        return ['message'=>'success'];
    }

    public function destroy($productId, $variantId)
    {
        $this->service->deleteVariant($productId, $variantId);

        return ['message'=>'success'];
    }
}