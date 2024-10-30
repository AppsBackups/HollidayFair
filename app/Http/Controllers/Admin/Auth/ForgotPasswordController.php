<?php

namespace App\Http\Controllers\Admin\Auth;


use App\Http\Controllers\BaseController;
use App\Notifications\PasswordResetAdminRequest;
use App\PasswordReset;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    protected $guard = 'admin';

    protected $loginPath = '/login';

    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest');
    }
    public function showLinkRequestForm()
    {   if (Auth::guard($this->guard)->check()) {
        return redirect($this->redirectTo);
    }
        return view('auth.passwords.email');
    }
    public function sendResetLinkEmail(Request $request)
    {

        $email=$request->email;
        $user = User::where('email', $email )->where('user_type', 'admin' )->first();

        if (!$user) {
            $this->sweetAlert('error', 'User not found.', 'Sorry!');
            return redirect('password/reset')->withInput();
        }

        $record = '';
        if ($email) {
            $record = PasswordReset::where('email', $email)->first();
        }
        $token=md5(time() . random_int(00000, 99999));
        if (!$record) {
            $record = PasswordReset::create([
                'email' => $email,
                'token' => $token,
            ]);

        } else {
            $record = PasswordReset::where('email', $email)->update([
                'token' => $token,
            ]);
        }

        if ($user && $record) {
            $user->notify(
                new PasswordResetAdminRequest($token)
            );
        }

        $this->sweetAlert('success', 'We have e-mailed your password reset link!', 'Done!');
        return redirect('/login');

    }


    protected function guard()
    {
        return Auth::guard($this->guard);
    }
    protected function broker()
    {
        return Password::broker('users');
    }

}
