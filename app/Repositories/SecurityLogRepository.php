<?php
namespace App\Repositories;

use App\Models\SecurityLog;

class SecurityLogRepository
{
    public function create(array $data)
    {
        return SecurityLog::create($data);
    }

    public function getAllForUser(int $userID)
    {
        return SecurityLog::where('user_id', $userID)->latest()->get();
    }
}