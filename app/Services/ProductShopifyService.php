<?php

namespace App\Services;

use App\Repositories\ProductShopifyRepository;

class ProductShopifyService
{
    protected $repo;

    public function __construct(ProductShopifyRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getToken()
    {
        return $this->repo->getToken();
    }

    public function listProducts($limit = 10)
    {
        $products = $this->repo->getProducts($limit);
        // Lấy danh sách ID đã soft delete
        $softDeletedIds = $this->repo->getSoftDeletedProduct()->pluck('shopify_product_id')->toArray();
        $filtered = [];
        foreach ($products as $product) {
            if (!in_array($product['id'], $softDeletedIds)) {
            $filtered[] = $product;
            }
        }

        return $filtered;
    }

    public function getProduct($id)
    {
        return $this->repo->getProduct($id);
    }

    public function addProduct($title, $price, $isNotifyActive)
    {
        $data = [
            'title' => $title,
            'variants' => [
                ['price' => $price]
            ]
        ];
        return $this->repo->createProduct($data, $isNotifyActive);
    }

    public function updateProduct($id, $title, $price)
    {
        $data = [
            'title' => $title,
            'variants' => [
                ['price' => $price]
            ]
        ];
        return $this->repo->updateProduct($id, $data);
    }
    
    public function softDeleteProduct($id)
    {
        return $this->repo->softDeleteProduct($id);
    }
    
    public function listSoftDeleted()
    {
        return $this->repo->getAllSoftDeleteProduct();
    }
    
    public function deleteProduct($id)
    {
        return $this->repo->deleteProduct($id);
    }
}