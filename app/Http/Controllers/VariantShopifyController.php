<?php
namespace App\Http\Controllers;

use App\Services\VariantShopifyService;
use Illuminate\Http\Request;

class VariantShopifyController extends Controller
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

        return response()->json([ 'message' => 'Variant created successfully', 'variant' => $variant,
]);

    }

    public function edit($productId, $variantId)
    {
        $variant = $this->service->listVariants($productId);
        $variant = collect($variant)->firstWhere('id', $variantId);
        $token = $this->service->getToken();

        return view('shopify.variant_edit', compact('variant', 'productId', 'token'));
    }

    public function update(Request $request, $productId, $variantId)
    {

        $variant = $this->service->updateVariant(
            $productId,
            $variantId,
            $request->only(['title','price','sku','option1'])
        );

        return response()->json(['message' => 'Variant updated successfully']);
    }

    public function destroy($productId, $variantId)
    {
        $this->service->deleteVariant($productId, $variantId);

        return response()->json(['message' => 'Variant deleted successfully']);
    }
}