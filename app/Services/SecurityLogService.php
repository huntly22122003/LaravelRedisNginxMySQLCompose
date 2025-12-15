<?php
namespace App\Services;

use App\Repositories\SecurityLogRepository;
use Illuminate\Support\Facades\Auth;

class SecurityLogService
{
    protected SecurityLogRepository $repo;

    public function __construct(SecurityLogRepository $repo)
    {
        $this->repo = $repo;
    }
    public function logAction(string $action)
    {
        $actor = Auth::guard('shop')->user();
        if($actor){
            $this->repo->create([
                'user_id'=>$actor->id,
                'action'=>$action,
            ]);
        }
    }
    public function getLogsForCurrentUser()
    {
        $actor = Auth::guard('shop')->user();
        return $this->repo->getAllForUser($actor->id);

    }
}