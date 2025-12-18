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

    public function listProducts($limit = 10)
    {
        return $this->repo->getProducts($limit);
    }

    public function addProduct($title, $price)
    {
        $data = [
            'title' => $title,
            'variants' => [
                ['price' => $price]
            ]
        ];
        return $this->repo->createProduct($data);
    }
}