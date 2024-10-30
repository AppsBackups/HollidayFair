<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\PasswordReset;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;


class ResetPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm($token)
    {

        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            $this->sweetAlert('error', 'This password reset token is invalid. Please try again.', 'Sorry!');
            return view('auth.passwords.reset')->with(
                ['token' => $token]
            );

        }
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            PasswordReset::where('token', $token)->delete();
            $this->sweetAlert('error', 'This password reset token is Expired. Please try again.', 'Sorry!');
            return view('auth.passwords.reset')->with(
                ['token' => $token]
            );
        }
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $passwordReset->email]
        );

    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|same:confirm_password',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors());

            $error = $errors->unique()->first();
            $this->sweetAlert('error', $error[0], 'Sorry!');
            return view('auth.passwords.reset')->with(
                ['token' => $request->token,'email'=>$request->email]
            );

        }

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset) {
            $this->sweetAlert('error', 'This password reset token is invalid. Please try again.', 'Sorry!');
            return view('auth.passwords.reset')->with(
                ['token' => $request->token,'email'=>$request->email]
            );
        }
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user) {
            $this->sweetAlert('error', 'We can\'t find a user with that e-mail address.', 'Sorry!');
            return view('auth.passwords.reset')->with(
                ['token' => $request->token,'email'=>$request->email]
            );

        }
        $user->password = bcrypt($request->password);
        $user->save();
        PasswordReset::where('email', $request->email)->delete();
        $this->sweetAlert('success', 'Password Change Successfully.', 'Done!');
        return redirect('login');
    }
}
