<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UserShop;
use App\Services\SecurityLogService;
use Exception;

class UpdateUserController extends Controller
{
    protected $user;
    protected $logService;
    public function __construct(SecurityLogService $logService)
    {
        $this->user = Auth::guard('shop')->user();
        $this->logService= $logService;
    }


    public function showUpdateUser()
    {
        return view('updateuser',['user'=>$this->user]);
    }

    //update profile
    public function updateUserProfile(Request $request)
    {
        $request->validate([
            'name' =>'nullable|string|max:100',
            'email'=>'nullable|email|unique:shop.user_shops,email',
            'phone' =>'nullable|string|max:20',
            'address' =>'nullable|string|max:255',
            //'avatar' => 'nullable|image|max:2048',
        ]);
        $this->user->name    = $request->name    ?? $this->user->name;
        $this->user->email   = $request->email   ?? $this->user->email;
        $this->user->phone   = $request->phone   ?? $this->user->phone;
        $this->user->address = $request->address ?? $this->user->address;

        
        $this->logService->logAction('Update_User_Information');
        $this->user->save();
        return redirect()->route('updateuser')->with('success', 'Cập nhật thành công');

        return response()->json([
            'message' => 'Success Update',
            'user' => $this->user
        ]);
    }   
    
}