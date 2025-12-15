<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;
use Exception;

class TaskController extends Controller
{
    protected TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    // Hiển thị tất cả task (admin thấy toàn bộ, user chỉ thấy của mình)
    public function index(Request $request)
    {
        $keyword = $request->get('search');

        if ($keyword) {
            $tasks = $this->service->searchTasks($keyword);
        } else {
            $tasks = $this->service->listAll();
        }

        return view('tasks.index', compact('tasks','keyword'));
    }

    // Hiển thị form tạo task
    public function create()
    {
        $users = \App\Models\UserShop::all();
        return view('tasks.create', compact('users'));

    }

    // Lưu task mới
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'status'      => 'nullable|string',
                'assigned_to' => 'nullable|integer',
            ]);

            $this->service->createTask($data);

            return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    // Hiển thị form edit
    public function edit($id)
    {
        $task = $this->service->listAll()->find($id);
        return view('tasks.edit', compact('task'));
    }

    // Update task
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'status'      => 'nullable|string',
                'assigned_to' => 'nullable|integer',
            ]);

            $this->service->updateTask($id, $data);

            return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    // Delete task
    public function destroy($id)
    {
        try {
            $this->service->deleteTask($id);
            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}