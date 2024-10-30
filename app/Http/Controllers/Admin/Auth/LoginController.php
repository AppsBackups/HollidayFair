<?php

namespace App\Http\Controllers\Admin\Auth;


use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use \Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
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
    protected $redirectTo = '/dashboard';

    protected $guard = 'admin';
    protected $loginPath = '/login';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function show()
    {
        if (Auth::guard($this->guard)->check()) {
            return redirect($this->redirectTo);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $credential = ['email' => $request->email, 'password' => $request->password, 'user_type' => 'admin'];
        if (Auth::guard($this->guard)->attempt($credential)) {
            $this->sweetAlert('success', 'You are successful logged in!', 'Welcome to Dashboard!');
            return redirect($this->redirectTo);
        }

        $this->sweetAlert('error', 'Incorrect email address or password', 'Sorry!');
        return redirect($this->loginPath)->withInput();
    }

    public function logout()
    {
        Auth::guard($this->guard)->logout();
        $this->sweetAlert('success', 'You are successful logged out', 'Done!');
        return redirect($this->loginPath);
    }

    protected function guard()
    {
        return Auth::guard($this->guard);
    }



}
