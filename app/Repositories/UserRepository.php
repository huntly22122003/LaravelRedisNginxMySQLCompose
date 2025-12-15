<?php
namespace App\Repositories;

use App\Models\UserShop;

class UserRepository
{
    public function create(array $data): UserShop
    {
        return UserShop::create($data);
    }

    public function UpdatePassword(UserShop $usershop, string $newPassword)
    {
        $usershop->password = $newPassword;
        return $usershop->save();
    }
}