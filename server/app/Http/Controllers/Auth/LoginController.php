<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    //自定义重定向路径
    protected function redirectTo()
    {
        return config('project.admin_path').'/home';
    }
    public function username()
    {
        return 'login_name';
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->route('login');
    }

    /**
     * 重写验证方法，在登录时追加用户状态的验证条件
     * @param Request $r
     * @return void
     */
    protected function attemptLogin(Request $r)
    {
        $credential = $r->only($this->username(), 'password');
        // $credential['state']    = User::STATE_NORMAL;
        return $this->guard()->attempt( $credential, $r->filled('remember'));
    }
}
