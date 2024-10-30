<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;


class AdminUserController extends BaseController
{
    protected $redirectTo = '/users';

    protected $loginPath = '/login';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('first_name', 'last_name', 'email', 'id', 'avatar', 'created_at',
                'city')->where('user_type', '=', 'user')->orderBy('id', 'desc')->get();

            if ($data) {
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('name', function ($row) {
                        return $row['first_name'] . ' ' . $row['last_name'];
                    })
                    ->addColumn('image', function ($row) {
                        if ($row['avatar']) {
                            return '<img src="' . asset('uploads/' . $row['avatar']) . '">';
                        } else {
                            return '<img src="' . asset('uploads/images/user.png') . '">';
                        }

                    })
                    ->addColumn('action', function ($row) {
                        $html = '<button class="view_btn" id="' . $row['id'] . '"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 <button href="#" class="edit_btn" id="' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                 <span  class="delete_btn" data-toggle="modal" data-target="#delete_record" id="' . $row['id'] . '">
                                 <i class="fa fa-trash-o" aria-hidden="true"></i></span>';

                        return $html;
                    })
                    ->rawColumns(['name', 'image', 'action'])
                    ->make(true);
            }

        }

        $pageName = 'Users';

        $data['pageName'] = $pageName;
        return view('user', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);

        }
        $input = $request->all();
        if ($request->hasFile('avatar')) {

            $upload = $this->uploadImageWithThumbnail($request, 'avatars', 'avatar');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }

            $input['avatar'] = $data->data;
        }

        $input['password'] = bcrypt($input['password']);
        $input['user_type'] = 'user';
        $input['is_share_exhibitor'] = 1;

        $user = User::create($input);


        Mail::send('vendor.mail.user-email', $request->all(), function ($message) use ($input) {

            $message->to($input['email'], $input['first_name'] . ' ' . $input['first_name'])
                ->subject('Welcome to ' . env('APP_NAME'));
        });

        return $this->respondSuccess('User added Successfully.', 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dbCollection = User::leftjoin('vendors_planner', 'vendors_planner.user_id', '=',
            'users.id')->leftjoin('vendors_visit', function ($join) {
            $join->on('vendors_visit.vendor_id', '=', 'vendors_planner.vendor_id')
                ->on('vendors_visit.user_id', '=', 'vendors_planner.user_id');
        })->leftjoin('vendors', function ($join) {
            $join->on('vendors.id', '=', 'vendors_planner.vendor_id');
        })->select('users.first_name','users.job_title','users.company_name','users.city','users.avatar','users.last_name', 'users.email', 'vendors.id', 'vendors.name', 'vendors.logo',
            'vendors.booth_number', 'vendors_visit.id as visited_id')->where('users.id', '=', $id)->get();

        if ($dbCollection) {
            $html=[];
            foreach ($dbCollection as $value) {
                if(@$value['id']) {
                    $visited='';
                    if(@$value['visited_id'])
                    {
                        $visited='(Visited)';
                    }
                    $logo='';
                    if(@$value['logo'])
                    {
                        $logo='<img src="' . asset('uploads/' . $value['logo']) . '">';
                    }

                    $html[] = '<li>
                            <div class="my_vendor_detail">
                                <div class="my_vendor_content">
                                    <span>'.$value['name'].'</span>
                                    <span class="text-muted">'.$value['booth_hall'].' <label class="visited">'.$visited.'</label></span>
                                </div>
                                <div class="my_vendor_image">
                                    '.$logo.'
                                </div>
                            </div>
                         </li>';
                }
                else{
                    $html[] = '<li>
                            <div class="my_vendor_detail">
                                <div class="text-center">
                                    <span>No more Vendor Found.</span>
                                </div>
                                <div class="my_vendor_image">
                                </div>
                            </div>
                         </li>';
                }
            }
            $result['first_name']=$dbCollection[0]['first_name'];
            $result['last_name']=$dbCollection[0]['last_name'];
            $result['email']=$dbCollection[0]['email'];
            $result['job_title']=$dbCollection[0]['job_title'];
            $result['company_name']=$dbCollection[0]['company_name'];
            $result['avatar']=$dbCollection[0]['avatar'];
            $result['city']=$dbCollection[0]['city'];
            $result['shopping_planner']=implode(' ', $html);
            return $this->respondData($result);
        }
        return $this->respondWithError('Something wrong.', '200');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $dbCollection = User::find($id);
        if ($dbCollection) {
            return $this->respondData($dbCollection);
        }
        return $this->respondWithError('Something wrong.', '401');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email,' . $id,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors());

            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }


        if ($request->hasFile('avatar')) {
            $upload = $this->uploadImageWithThumbnail($request, 'avatars', 'avatar');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }
            $this->removeImage($request->old_image);
            $input['avatar'] = $data->data;
        }

        $input['first_name'] = $request->first_name;
        $input['last_name'] = $request->last_name;
        $input['email'] = $request->email;
        $input['job_title'] = $request->job_title;
        $input['company_name'] = $request->company_name;
        $input['city'] = $request->city;
        if ($request->rest_password) {
            $input['password'] = bcrypt($request->password);
            Mail::send('vendor.mail.user-email', $request->all(), function ($message) use ($input) {

                $message->to($input['email'], $input['first_name'] . ' ' . $input['first_name'])
                    ->subject('Change Credential ' . env('APP_NAME'));
            });
        }
        $user = User::where('id', $id)->update($input);
        return $this->respondSuccess('User Updated Successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dbCollection = User::where('id', '=', $id)->delete();
        if ($dbCollection) {
            return $this->respondSuccess('User Delete Successfully.', 200);
        }
        return $this->respondWithError('User was not Deleted', 200);
    }
}
