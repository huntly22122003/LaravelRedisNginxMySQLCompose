<?php

namespace App\Services;

use App\Repositories\LoginRepository;
use App\Services\SecurityLogService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    protected $users;
    protected $logService;

    public function __construct(LoginRepository $users, SecurityLogService $logService)
    {
        $this->users = $users;
        $this->logService = $logService;

    }

    public function login($email, $password, $remember)
    {
        $user = $this->users->findShopByEmail($email);

        if (!Auth::guard('shop')->attempt([
            'email' => $email,
            'password' => $password
        ], $remember)) {
            if ($user) {
                $this->logService->logAction('login_failed');
            }
            return [
                'status' => false,
                'message' => 'Sai email hoặc mật khẩu!'
            ];
        }
        $user = Auth::guard('shop')->user();
        // Kiểm tra mật khẩu hash trong DB
        if (!Hash::check($password, $user->password)) {
            return [
                'status' => false,
                'message' => 'Sai mật khẩu!'
            ];
        }

        // Login bằng guard shop của bạn
        Auth::guard('shop')->login($user, $remember);
        $this->logService->logAction('login_success');
        // Nếu bạn dùng role → check
        if ($user->hasRole('admin')) {
            return [
                'status' => true,
                'redirect' => route('admin.dashboard')
            ];
        }
        if($user->hasRole('management'))
        {
           return[
            'status'=>true,
            'redirect'=> route('management.dashboard')
           ] ;
        }

        return [
            'status' => true,
            'redirect' => route('website')
        ];
    }
}
