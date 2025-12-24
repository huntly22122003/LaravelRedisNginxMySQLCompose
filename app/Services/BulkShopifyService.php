<?php

namespace App\Services;

use App\Repositories\BulkShopifyRepository;

class BulkShopifyService
{
    protected $repo;

    public function __construct(BulkShopifyRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Import products
     */
    public function importProducts(array $products)
    {
        return $this->repo->bulkImport($products);
    }

    /**
     * Export products
     */
    public function exportProducts()
    {
        return $this->repo->bulkExport();
    }

    public function searchProducts(string $keyword, int $limit = 10)
    {
        return $this->repo->searchProducts($keyword, $limit);
    }

}