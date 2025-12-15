<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use App\Services\SecurityLogService;

class UpdateUserPasswordService
{
    protected $logService;
    protected $userRepo;

    public function __construct(SecurityLogService $logService, UserRepository $userRepo)
    {
        $this->logService = $logService;
        $this->userRepo = $userRepo;
    }

    public function UpdatePassword(string $newPassword): bool
    {
        $user = Auth::guard('shop')->user();
        $this->logService->logAction('Password_Update');
        $this->userRepo->UpdatePassword($user, Hash::make($newPassword));
        return true;
    }
}