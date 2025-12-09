<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\UserService;
use Exception;

class RegisterController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function showRegisterForm()
    {
        return view('register'); // view resources/views/register.blade.php
    }

    public function register(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:shop.user_shops,email'],
            'phone'    => ['required', 'string', 'max:20'],
            'address'  => ['required', 'string','max:255'],
            'password' => ['required', 'min:4', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Dữ liệu không hợp lệ!');
        }

        try {
            $this->userService->register($request->all());
            return redirect()->route('welcome')->with('success', 'Đăng ký thành công!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

}
