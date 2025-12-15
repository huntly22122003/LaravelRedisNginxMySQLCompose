<?
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserShop;
use App\Services\SecurityLogService;

use Exception;
class LogoutController extends Controller
{ 
    protected $logService;
    public function __construct(SecurityLogService $logService)
    {
        $this->logService= $logService;
    }
    function logout(Request $request)
    {
        $user = Auth::guard('shop')->user();

        //ghi log trước khi xoá session
        if ($user) {
            $this->logService->logAction('logout_account');
        }

        Auth::guard('shop')->logout(); // đăng xuất guard shop
        $request->session()->invalidate(); // huỷ session hiện tại
        $request->session()->regenerateToken(); // tạo CSRF token mới

        return redirect()->route('welcome')->with('success', 'Đã đăng xuất!');
    }
}