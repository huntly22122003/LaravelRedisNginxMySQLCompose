<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserShop extends Model
{
    protected $connection = 'shop';   // trỏ tới DB shop
    protected $table = 'users';       // bảng users trong DB shop
    protected $fillable = ['name', 'email', 'password'];
    public $timestamps = false;       // vì bảng không có created_at, updated_at
}