<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class AdminProfileController extends BaseController
{
    protected $redirectTo = '/update-profile';

    protected $guard = 'admin';

    protected $loginPath = '/login';

    public function index()
    {
        $pageName = 'Update Profile';
        $admin=Auth::user();

        $data['admin_info']=$admin;
        $data['pageName'] = $pageName;
        return view('profile', $data);
    }

    public function edit(Request $request)
    {
        $user_id = Auth::user()->id;

        if ($request->hasFile('avatar')) {
            $upload=$this->uploadImageWithThumbnail($request,'avatars','avatar');
            $data=json_decode($upload->getContent());
            if($data->success!=1)
            {
                $this->sweetAlert('error', $data->message, 'Sorry!');
                return redirect($this->redirectTo)->withInput();
            }

            $this->removeImage(Auth::user()->avatar);
            $input['avatar'] = $data->data;
        }
        $input['first_name']=$request->first_name;
        $input['last_name']=$request->last_name;
        $input['email']=$request->email;
        $user = User::where('id', $user_id)->update($input);
        $this->sweetAlert('success', 'Profile Data Updated Successfull.', 'Done!');
        return redirect($this->redirectTo)->withInput();
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors());

            $error = $errors->unique()->first();
            $this->sweetAlert('error', $error[0], 'Sorry!');
            return redirect($this->redirectTo)->withInput();
        }

        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            $this->sweetAlert('success', 'Password Changed Successfully.', 'Done!');
            return redirect($this->redirectTo);

        } else {
            $this->sweetAlert('error', 'Old Password does not match', 'Sorry!');
            return redirect($this->redirectTo)->withInput();
        }
    }


}
