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
        return view('shopify.variant', compact('variants', 'token', 'productId'));
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

        return redirect()->route('products.index', $productId)
                         ->with('success', 'Variant created: ');
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

        return redirect()->route('products.index', $productId)
                         ->with('success', 'Variant updated: '.$variant['id']);
    }

    public function destroy($productId, $variantId)
    {
        $this->service->deleteVariant($productId, $variantId);

        return redirect()->route('shopify.variant', $productId)
                         ->with('success', 'Variant deleted successfully.');
    }
}