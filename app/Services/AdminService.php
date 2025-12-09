<?php
namespace App\Services;

use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\Hash;

use Exception;

class AdminService
{
    protected $userRepo;

    public function __construct(AdminRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function listUsers()
    {
        return $this->userRepo->getAllUsers();
    }

    public function listRoles()
    {
        return $this->userRepo->getAllRoles();
    }

    public function searchUsers($keyword)
    {
        return $this->userRepo->searchUsers($keyword);
    }
    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepo->createUser($data);
    }

    public function updateUser($id, array $data)
    {
        try {
            return $this->userRepo->updateUser($id, $data);
        } catch (Exception $e) {
            throw new Exception("Update failed: " . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            return $this->userRepo->deleteUser($id);
        } catch (Exception $e) {
            throw new Exception("Delete failed: " . $e->getMessage());
        }
    }

     public function assignRole($userId, $roleId)
    {
        return $this->userRepo->assignRole($userId, $roleId);
    }

}