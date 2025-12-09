<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UserShop;
use Exception;

class UpdateUserPassword extends Controller
{
    public function UpdateUserPasswords(Request $request)
    {
        $user = Auth::guard('shop')->user();
        $request->validate([
            'new_password'=>'required|string|min:4|confirmed',
        ]);
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('website')->with('success', 'Đổi mật khẩu thành công');
    }
}