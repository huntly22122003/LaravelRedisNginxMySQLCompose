<?php

namespace App\Services;

use App\Repositories\VariantShopifyRepository;

class VariantShopifyService
{
    protected $repo;

    public function __construct(VariantShopifyRepository $repo)
    {
        $this->repo = $repo;
    }
        public function getToken()
    {
        return $this->repo->getToken();
    }
    public function listVariants($productId)
    {
        return $this->repo->getVariants($productId);
    }

    public function addVariant($productId, $title, $price, $sku, $option1)
    {
        $data = [
            'title' => $title,
            'price' => $price,
            'sku' => $sku,
            'option1' => $option1
        ];
        return $this->repo->createVariant($productId, $data);
    }

    public function updateVariant($productId, $variantId, array $data)
    {
        return $this->repo->updateVariant($productId, $variantId, $data);
    }

    public function deleteVariant($productId, $variantId)
    {
        return $this->repo->deleteVariant($productId, $variantId);
    }
}