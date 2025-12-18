<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Shopify extends Model
{
    protected $connection = 'shop';
    protected $table = 'shopify';
    protected $fillable = [
        'domain',         // e.g., myshop.myshopify.com
        'access_token', 
        'installed_at',
        'scope',
        'uninstalled_at',
    ];

    protected $casts = [
        'installed_at' => 'datetime',
        'uninstalled_at' => 'datetime',
    ];
}