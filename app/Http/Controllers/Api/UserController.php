<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Http\Controllers\BaseController;
use App\Notifications\PasswordResetRequest;
use App\PasswordReset;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Image;
use Validator;

class UserController extends BaseController
{

    /*Login api*/


    public function userLogin()
    {

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();

            if ($user !== null) {
                DB::table('oauth_access_tokens')
                    ->where('user_id', $user->id)
                    ->update([
                        'revoked' => true
                    ]);
                $userupdate = User::where('email', request('email'))->update([
                    'device_type' => request('device_type'),
                    'device_token' => request('device_token')
                ]);

                $user['token'] = $user->createToken('holly-day-fair')->accessToken;
                $user['device_type'] = request('device_type');
                $user['device_token'] = request('device_token');
                if(!empty($user->avatar))
                {
                    // $user['avatar'] = config('app.MEDIA_URL') . $user->avatar;
                    $user['avatar'] = config('app.MEDIA_URL') . $user->avatar;
                }


                return $this->respondWithData($user); //return response()->json(['success' => $result], $this->successStatus);
            }
        }
        return $this->respondWithError('Email or password didn\'t match', 401);
    }

    /*Register api*/
    public function userRegister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);


        if ($validator->fails()) {
            $errors = collect($validator->errors());

            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 401);
        }


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_type'] = 'user';

        if ($request['is_share_exhibitor'] == 'true') {
            $input['is_share_exhibitor'] = 1;
        } else {
            $input['is_share_exhibitor'] = 0;
        }

        $user = User::create($input);
        $user['job_title'] = '';
        $user['company_name'] = '';
        $user['token'] = $user->createToken('holly-day-fair')->accessToken;
        if(!empty($user->avatar))
        {
            $user['avatar'] = config('app.MEDIA_URL') . $user->avatar;
        }
        return $this->respondWithData($user);
    }

    /*User details api*/
    public function getLoggedInUserDetails()
    {
        $user = Auth::user(); //$user = User::findOrFail(Auth::user()->id);
        if (!isset($user)) {
            throw new CustomException('User not found!');
        }
        if(!empty($user->avatar))
        {
            $user['avatar'] = config('app.MEDIA_URL') . $user->avatar;
        }
        return $this->respondWithData($user);
    }

    /*User Update profile api*/
    public function userUpdateProfile(Request $request)
    {
        $user_id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email,' . $user_id,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors());

            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 401);
        }

        $input = $request->all();


        if ($request->hasFile('avatar')) {
            $upload = $this->uploadImageWithThumbnail($request, 'avatars', 'avatar');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 401);
            }

            $this->removeImage(Auth::user()->avatar);
            $input['avatar'] = $data->data;
        }
        $user = User::where('id', $user_id)->update($input);
        $dbCollection = User::where('id', $user_id)->get();
        if(!empty($dbCollection[0]->avatar))
        {
            $dbCollection[0]['avatar'] = config('app.MEDIA_URL') . $dbCollection[0]->avatar;
        }
        return $this->respondWithData($dbCollection[0]);
    }

    /*User Change password api*/
    public function userChangePassword(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors());

            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 401);
        }

        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            return $this->respondSuccess('Password Changed Sucessfully!', 200);

        } else {
            return $this->respondWithError('Password does not match\'', 401);
        }
    }

    /*User ForgotPassword*/
    public function userForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors());

            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 401);
        }

        $input = $request->all();
        $email = $input['email'];

        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->respondWithError('User not found.', 404);
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
                new PasswordResetRequest($token)
            );
        }
        return $this->respondSuccess('We have e-mailed your password reset link!', 200);
    }

    public function userResetForm($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            $this->sweetAlert('error', 'This password reset token is invalid. Please try again.', 'Sorry!');
            return view('api.reset')->with(
                ['token' => $token]
            );

        }
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            PasswordReset::where('token', $token)->delete();
            $this->sweetAlert('error', 'This password reset token is Expired. Please try again.', 'Sorry!');
            return view('api.reset')->with(
                ['token' => $token]
            );
        }
        return view('api.reset')->with(
            ['token' => $token, 'email' => $passwordReset->email]
        );

    }

    public function userResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors());

            $error = $errors->unique()->first();
            $this->sweetAlert('error', $error[0], 'Sorry!');
            return view('api.reset')->with(
                ['token' => $request->token, 'email' => $request->email]
            );

        }


        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $this->sweetAlert('error', 'We can\'t find a user with that e-mail address.', 'Sorry!');
            return redirect('users/userResetPassword')->with(
                ['token' => $request->token, 'email' => $request->email]
            );

        }

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset) {
            $this->sweetAlert('error', 'This password reset token is invalid. Please try again.', 'Sorry!');
            return view('api.reset')->with(
                ['token' => $request->token, 'email' => $request->email]
            );
        }

        $user->password = bcrypt($request->password);
        $user->save();

        PasswordReset::where('email', $request->email)->delete();
        $this->sweetAlert('success', 'Password Change Successfully.', 'Done!');
        return redirect('/');
        //return view('web.welcome');
    }

    /*User Logout*/
    public function userLogout()
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return $this->respondSuccess('Logout Sucessfull.', 200);
        } else {
            return $this->respondWithError('Something went wrong.', 401);
        }
    }

    public function deviceLogin(Request $request)
    {
        $input=$request->all();

        $record = '';
        if ($input['device_id']) {
            $record = Device::where('device_id','=', $input['device_id'])->first();
        }

        if (!$record) {
            $record = new Device();
        }

        $record->where('device_id',$input['device_id'])->updateOrCreate([
            'device_id' => $input['device_id'],
            'device_type' => $input['device_type'],
            'device_token' => $input['device_token'],
        ]);

        if ($record) {
            return $this->respondSuccess('Device dat added Sucessfull.', 200);
        } else {
            return $this->respondWithError('Something went wrong.', 401);
        }
    }

}
