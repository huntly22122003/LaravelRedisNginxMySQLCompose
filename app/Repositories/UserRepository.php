<?php
namespace App\Repositories;

use App\Models\UserShop;

class UserRepository
{
    public function create(array $data): UserShop
    {
        return UserShop::create($data);
    }
}