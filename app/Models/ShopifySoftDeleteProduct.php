<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ShopifySoftDeleteProduct extends Model
{
    protected $connection = 'shop';
    protected $table = 'shopify_soft_deleted_products';
    protected $fillable = [
        'shopify_product_id',
        'payload',
    ];
    public $timestamps = false;
}