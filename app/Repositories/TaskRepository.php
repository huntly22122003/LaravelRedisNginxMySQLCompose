<?php
namespace App\Repositories;

use App\Models\UserShop;
use App\Models\TaskShop;

Class TaskRepository
{
    public function getAll()
    {
        return TaskShop::with('creator','assignee')->latest()->get();
    }

    public function getAllForUser(int $userId)
    {
        return TaskShop::where('assigned_to', $userId)
            ->where('assigned_to', $userId)
            ->latest()
            ->get();
    }
    
    public function search(?string $keyword, ?int $userId = null, bool $isAdmin = false)
    {
        $query = TaskShop::with('creator','assignee');
        if ($keyword) {
            $query->where(function($q) use ($keyword, $isAdmin) {
                // User thường: chỉ search theo title + status
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('status', 'like', "%{$keyword}%");

                // Admin: được phép search thêm theo tên assignee
                if ($isAdmin) {
                    $q->orWhereHas('assignee', function($sub) use ($keyword) {
                        $sub->where('name', 'like', "%{$keyword}%");
                    });
                }
            });
        }
        // User thường chỉ thấy task của chính mình
        if (!$isAdmin && $userId) 
           { $query->where('assigned_to', $userId);}
        return $query->latest()->get();
    }

    public function findTaskById(int $id): ?TaskShop
    {
        return TaskShop::with(['creator', 'assignee'])->find($id);
    }

     public function findUserById(int $id): ?UserShop
    {
        return UserShop::find($id);
    }

    public function getByUser($userID)
    {
        return TaskShop::where('assigned_to', $userID)->latest()->get();
    }

    public function create(array $data)
    {
        return TaskShop::create($data);
    }

    public function update(TaskShop $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function delete(TaskShop $task)
    {
        return $task->delete();
    }

}