<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    protected TaskRepository $repo;

    public function __construct(TaskRepository $repo)
    {
        $this->repo = $repo;
    }

    private function getActor()
    {
        $actor = Auth::guard('shop')->user();
        if (!$actor) {
            throw new Exception('Bạn chưa đăng nhập', 401);
        }
        return $actor;
    }

    private function isAdmin($actor): bool
    {
        return $actor->hasRole('admin');
    }

    private function ensureCanModify($actor, $task)
    {
        if ($this->isAdmin($actor)) {
            return true;
        }

        if ($task->assigned_to != $actor->id) {
            throw new Exception('Bạn không có quyền thao tác với task này', 403);
        }
    }

    public function createTask(array $data)
    {
        $actor = $this->getActor();

        $assignedID = $this->resolveAssignedUser($actor, $data);

        $payload = [
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'assigned_to' => $assignedID,
            'created_by'  => $actor->id,
            'status'      => $data['status'] ?? 'pending',
        ];

        return $this->repo->create($payload);
    }

    private function resolveAssignedUser($actor, array $data)
    {
        if ($this->isAdmin($actor)) {
            if (empty($data['assigned_to'])) {
                throw new Exception('Phải chọn người được giao', 400);
            }
            $assignedUser = $this->repo->findUserById((int)$data['assigned_to']);
            if (!$assignedUser) {
                throw new Exception('Người được giao không tồn tại', 404);
            }
            return $assignedUser->id;
        }

        return $actor->id;
    }

    public function searchTasks(?string $keyword)
    {
        $actor = $this->getActor();
        $isAdmin = $this->isAdmin($actor);
        return $this->repo->search($keyword, $actor->id, $isAdmin);
    }

    public function updateTask(int $taskId, array $data)
    {
        $actor = $this->getActor();
        $task = $this->repo->findTaskById($taskId);

        if (!$task) {
            throw new Exception('Task không tồn tại', 404);
        }

        $this->ensureCanModify($actor, $task);

        if (!$this->isAdmin($actor)) {
            unset($data['assigned_to']);
        }

        return $this->repo->update($task, $data);
    }

    public function deleteTask(int $taskId)
    {
        $actor = $this->getActor();
        $task = $this->repo->findTaskById($taskId);

        if (!$task) {
            throw new Exception('Task không tồn tại', 404);
        }

        $this->ensureCanModify($actor, $task);

        return $this->repo->delete($task);
    }

    public function listAllForUser(int $userId)
    {
        $actor = $this->getActor();

        if ($this->isAdmin($actor)) {
            return $this->repo->getAllForUser($userId);
        }

        if ($actor->id !== $userId) {
            throw new Exception('Bạn không có quyền xem task của user khác', 403);
        }

        return $this->repo->getAllForUser($actor->id);
    }

    public function listAll()
    {
        $actor = $this->getActor();

        if ($this->isAdmin($actor)) {
            return $this->repo->getAll();
        }

        return $this->repo->getAllForUser($actor->id);
    }
}