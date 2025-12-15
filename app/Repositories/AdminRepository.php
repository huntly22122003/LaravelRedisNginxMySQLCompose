<?php
namespace App\Repositories;

use App\Models\UserShop;
use App\Models\RoleShop;

class AdminRepository
{
    public function getAllUsers()
    {
        return UserShop::all();
    }

    public function getAllRoles()
    {
        return RoleShop::all();
    }

    public function findById($id)
    {
        return UserShop::find($id);
    }

    public function searchUsers($keyword)
    {
        return UserShop::where('name', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->orWhere('phone', 'like', "%$keyword%")
            ->orWhereHas('roles', function ($query) use ($keyword) {
            $query->where('name', 'like', "%$keyword%");
            })
            ->get();
    }

    public function createUser(array $data)
    {
        return UserShop::create($data);
    }


    public function updateUser($id, array $data)
    {
        $user = UserShop::findOrFail($id);
        $user->update($data);
        return $user;
    }
    
    public function deleteUser($id)
    {
        return UserShop::destroy($id);
    }
    public function assignRole($userId, $roleId)
    {
        $user = UserShop::findOrFail($userId);
        $user->roles()->sync([$roleId]);
        return $user;
    }
}