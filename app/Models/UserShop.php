<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class UserShop extends Authenticatable
{
    use Notifiable;
    protected $connection = 'shop';   // trỏ tới DB shop
    protected $table = 'user_shops';       // bảng users trong DB shop
    protected $fillable = ['name', 'email', 'password','phone','address'];
    public $timestamps = true;       // bảng không có created_at, updated_at thì = false
    protected $hidden = ['password', 'remember_token'];
    protected $remember_token = 'remember_token';

     public function roles()
    {
        return $this->belongsToMany(RoleShop::class, 'role_user', 'user_id', 'role_id');
    }
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
    public function sendPasswordResetNotification($token)
    {
        $request->validate(['email' => 'required|email']);
        $user = UserShop::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email không tồn tại']);
        }

        // Tạo token (ví dụ random string)
        $token = \Illuminate\Support\Str::random(60);

        // Lưu token vào bảng users (hoặc bảng riêng)
        $user->reset_token = $token;
        $user->save();

        // Gửi mail
        $user->sendPasswordResetNotification($token);

        return back()->with('status', 'Link reset đã được gửi');

    }


}