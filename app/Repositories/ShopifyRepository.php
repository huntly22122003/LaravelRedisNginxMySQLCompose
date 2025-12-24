<?php

namespace App\Repositories;

use App\Models\Shopify;

class ShopifyRepository
{
   public function storeOrUpdate($data)
    {
        return Shopify::updateOrCreate(
            ['domain' => $data['domain']],
            [
                'access_token' => $data['access_token'],
                'scope' => $data['scope'],
                'installed_at' => now(),
                'uninstalled_at' => null,
            ]
        );
    }

    public function getByDomain(?string $domain): ?Shopify
    {
        return $domain ? Shopify::where('domain', $domain)->first() : null;
    }

    public function getFirstShop()
    {
        return Shopify::first();
    }

}
