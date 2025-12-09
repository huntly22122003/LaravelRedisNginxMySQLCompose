<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UserShop;
use Exception;

class UpdateUserController extends Controller
{
    public function showUpdateUser()
    {
        $user = Auth::guard('shop')->user();
        return view('updateuser',['user'=>$user]);
    }

    //update profile
    public function updateUserProfile(Request $request)
    {
        $user = Auth::guard('shop')->user();

        $request->validate([
            'name' =>'nullable|string|max:100',
            'email'=>'nullable|email|unique:shop.user_shops,email',
            'phone' =>'nullable|string|max:20',
            'address' =>'nullable|string|max:255',
            //'avatar' => 'nullable|image|max:2048',
        ]);
        $user->name     = $request->name ?? $user->name;
            $user->email     = $request->email ?? $user->email;
            $user->phone     = $request->phone ?? $user->phone;
            $user->address   = $request->address ?? $user->address;
        
        $user->save();
        return redirect()->route('updateuser')->with('success', 'Cập nhật thành công');

        return response()->json([
            'message' => 'Success Update',
            'user' => $user
        ]);
    }   
    
}