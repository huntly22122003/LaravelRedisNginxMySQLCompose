<?php
namespace App\Repositories;

use App\Models\RoleShop;

class RoleRepository
{
    public function getUserRole(): ?RoleShop
    {
        return RoleShop::where('name','user')->first();
    }
    public function getAdminRole(): ?RoleShop
    {
        return RoleShop::where('name','admin')->first();
    }
}