<?php
namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Http\Request;
use Exception;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    public function create()
    {
        $roles = $this->adminService->listRoles(); // lấy tất cả role từ service
        return view('admin.Adduser', compact('roles'));
    }

    
    public function dashboard(Request $request)
    {
        // chỉ gọi khi login là admin
        $keyword = $request->input('search');
        $users = $keyword ? $this->adminService->searchUsers($keyword) : $this->adminService->listUsers();
        $roles = $this->adminService->listRoles();

        return view('admin.dashboard', [
            'users'   => $users,
            'keyword' => $keyword,
            'roles'   => $roles,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:shop.user_shops,email',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'password' => 'required|string|min:4',
                'role_id'  => 'required|exists:shop.roles,id',
            ]);

            $user= $this->adminService->createUser($validated);
            $this->adminService->assignRole($user->id, $validated['role_id']);
            return redirect()->route('admin.dashboard')->with('success', 'User created successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $this->adminService->updateUser($id, $request->all());
            return redirect()->back()->with('success', 'User updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->adminService->deleteUser($id);
            return redirect()->back()->with('success', 'User deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function assignRole(Request $request, $id)
    {
        try {
            $roleId = $request->input('role_id');
            $this->adminService->assignRole($id, $roleId);
            return redirect()->back()->with('success', 'Role assigned successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}