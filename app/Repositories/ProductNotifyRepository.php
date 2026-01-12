<?php

namespace App\Repositories;

use App\Models\Product_Notify;


class ProductNotifyRepository
{
    public function findProduct($productId): bool
    {
        return Product_Notify::where('product_id', $productId)->exists();
    }

}