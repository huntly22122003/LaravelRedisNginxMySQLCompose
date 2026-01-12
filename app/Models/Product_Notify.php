<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Notify extends Model
{
    protected $connection = 'shop';
    protected $table = 'product_settings';
    protected $fillable = ['product_id', 'is_notify_active'];
    public $timestamps = false;
}