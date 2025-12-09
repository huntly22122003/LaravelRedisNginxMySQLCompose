<?
namespace App\Http\Controllers;


use App\Services\LoginService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $auth;
    public function __construct(LoginService $auth)
    {
        $this->auth = $auth;
    }
    public function showLogin()
    {
        return view('login'); // view resources/views/login.blade.php
    }
    public function login(Request $request)
    {   
        $result = $this->auth->login(
            $request->email,
            $request->password,
            $request->filled('remember')
        );

        if ($result['status'] === false) {
            return back()->with('error', $result['message']);
        }

        return redirect($result['redirect']);
    }
}