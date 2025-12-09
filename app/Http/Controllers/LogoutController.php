<?
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserShop;
use Exception;
class LogoutController extends Controller
{ 
    function logout(Request $request)
    {
        Auth::guard('shop')->logout(); // đăng xuất guard shop
        $request->session()->invalidate(); // huỷ session hiện tại
        $request->session()->regenerateToken(); // tạo CSRF token mới

        return redirect()->route('welcome')->with('success', 'Đã đăng xuất!');
    }
}