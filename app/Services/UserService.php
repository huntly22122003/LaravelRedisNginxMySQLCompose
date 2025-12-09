<?php
namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService
{
    protected $userRepo;
    protected $roleRepo;

    public function __construct(UserRepository $userRepo, RoleRepository $roleRepo)
    {
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
    }
     public function register(array $data)
    {
        try {
            // Tạo user
            $user = $this->userRepo->create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'phone'    => $data['phone'],
                'address'  => $data['address'],
                'password' => Hash::make($data['password']),
            ]);

            // Lấy role "user"
            $role = $this->roleRepo->getUserRole(); //gán thẳng bằng getUserRole

            if ($role) {
                // Gán role cho user bằng Eloquent
                $user->roles()->attach($role->id);
            }

            return $user;
        } catch (Exception $e) {
            throw new Exception("Đăng ký thất bại: " . $e->getMessage());
        }
    }

}