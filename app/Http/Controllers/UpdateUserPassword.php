<?php
namespace App\Http\Controllers;
use App\Services\UpdateUserPasswordService;
use Illuminate\Http\Request;

use Exception;

class UpdateUserPassword extends Controller
{
    protected $passwordService;
    public function __construct(UpdateUserPasswordService $passwordService)
    {
            $this->passwordService = $passwordService;

    }
    public function UpdateUserPasswords(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:4|confirmed',
        ]);
        // Gọi service để xử lý logic đổi mật khẩu
        $this->passwordService->UpdatePassword($request->new_password);
        // Trả về response
        return redirect()
            ->route('website')
            ->with('success', 'Đổi mật khẩu thành công');
    }
}