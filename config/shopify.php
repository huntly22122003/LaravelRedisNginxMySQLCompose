<?php
return [
    'shopify' => [
        'key' => env('SHOPIFY_API_KEY'),
        'secret' => env('SHOPIFY_API_SECRET'),
        'scopes' => env('SHOPIFY_SCOPES', 'read_products,write_products'),
        'api_version' => env('SHOPIFY_API_VERSION', '2025-10'),
    ],
];