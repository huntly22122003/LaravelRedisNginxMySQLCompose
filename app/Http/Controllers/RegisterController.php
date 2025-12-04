<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserShop;
use Exception;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('register'); // view resources/views/register.blade.php
    }

    public function register(Request $request)
    {   
        try {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:shop.users,email'],
            'password' => ['required', 'min:4', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Dữ liệu không hợp lệ!');
        }

        $user = UserShop::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('welcome')->with('success', 'Đăng ký thành công!');
    } catch (Exception $e) {
        return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    }
    }

}
