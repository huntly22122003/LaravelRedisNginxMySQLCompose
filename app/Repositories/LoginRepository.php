<?php

namespace App\Repositories;

use App\Models\UserShop;
use App\Models\RoleShop;

class LoginRepository
{
    public function findShopByEmail($email)
    {
        return UserShop::where('email', $email)->first(); //Check email in database
    }

}
