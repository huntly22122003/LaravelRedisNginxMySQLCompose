<?

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\UserShop;
use App\Services\SecurityLogService;

class ResetPasswordController extends Controller
{
    protected $logService;

    public function __construct(SecurityLogService $logService)
    {
        $this->logService = $logService;
    }


    public function showResetForm(Request $request, $token = null)
    {
        return view('ResetPassword')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4|confirmed',
        ]);

        $user = UserShop::where('email', $request->email)
                        ->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Token không hợp lệ']);
        }
        Auth::guard('shop')->login($user);
        $this->logService->logAction('Forget_Password');
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('status', 'Đặt lại mật khẩu thành công');

    }
}
