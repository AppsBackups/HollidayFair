<?php

namespace App\Http\Controllers\Admin;

use App\Announcement;
use App\Device;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AnnouncementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Announcement::orderBy('created_at', 'desc')->get();

            if ($data) {
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('date_time',function ($row)
                    {
                        return $this->dateConvert($row['date_time']);
                    })
                    ->addColumn('action', function ($row) {
                        $html = '<button class="view_btn" id="' . $row['id'] . '" data-toggle="modal" data-target="#view_modal"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 <span  class="delete_btn" data-toggle="modal" data-target="#delete_record" id="' . $row['id'] . '">
                                 <i class="fa fa-trash-o" aria-hidden="true"></i></span>';

                        return $html;
                    })
                    ->rawColumns(['date_time','action'])
                    ->make(true);
            }

        }
        $pageName = 'Announcement';

        $data['pageName'] = $pageName;
        return view('announcement', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message_title' => 'required',
            'date_time' => 'required',
            'message_description' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], '200');
        }
        $input = $request->all();

        $date = strtotime($request->date_time);
        $html=date('y-m-d h:i:s', $date);
        $input['date_time']=$html;
        $input['user_id']=0;
        $announcement = Announcement::create($input);
        if($announcement)
        {
            $data['title'] = $input['message_title'];
            $data['message'] = 'New Announcement';
            $data['Notification_type'] = 'event';
            $data['data'] = $input;
            $data['sound'] = 'default';

            $total_rows = Device::count();
            $no_of_records_per_page = 800;
            $total_pages = ceil($total_rows / $no_of_records_per_page);

            $currentPage = 1;
            while ($currentPage <= $total_pages) {
                $ios_token=[];
                $android_token=[];

                Paginator::currentPageResolver(function () use ($currentPage) {
                    return $currentPage;
                });

                $db_collection = Device::paginate(800);
                foreach ($db_collection as $collection)
                {
                    if($collection['device_type']=='android')
                    {
                        $android_token[]=$collection['device_token'];
                        $android_type='android';
                    }
                    else{
                        $ios_token[]=$collection['device_token'];
                        $ios_type='ios';
                    }
                }
                $currentPage++;

                if($android_token) {
                    $this->sendNotification($android_token, $input['message_title'], $data,'android');
                }
                if($ios_token) {
                    $this->sendNotification($ios_token,$input['message_title'],$data,'ios');
                }
            }



            return $this->respondSuccess('Message Send Successfully.', 200);
        }
        return $this->respondWithError('Something wrong.', '200');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dbCollection = Announcement::find($id);
        if ($dbCollection) {
            $date = strtotime($dbCollection['date_time']);
            $dbCollection['date_time']=date('d M Y, h:i A', $date);
            return $this->respondData($dbCollection);
        }
        return $this->respondWithError('Something wrong.', '200');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dbCollection = Announcement::where('id', '=', $id)->delete();
        if ($dbCollection) {
            return $this->respondSuccess('Message Deleted Successfully.', 200);
        }
        return $this->respondWithError('Message was not Deleted', 200);
    }

    public function test(Request $request){
        $date = strtotime(now()->format('Y-m-d'));
        $html = date('y-m-d h:i:s', $date);
        $input['date_time'] = $html;
        $input['user_id'] = 0;

        $data['title'] = "Test Title";
        $data['message'] = 'New Announcement';
        $data['Notification_type'] = 'event';
        $data['data'] = $input;
        $data['sound'] = 'default';


        $ios_token = [];
        $android_token = [];
        $tokenData = [
            'fbL_n6qKd4o:APA91bFJQHT_TsYqWbbljg76ik16PWZghrba6anObxR-AYRIkgjLeqws_8BV5cTHV5laoU0JR8l_kEkNFTrFYeDkcfPyg87Utm5WYEOIxwVRfTL8v4920p0dT8gR5yWngZXjabpGcugz',
            'ekMs3KPOVTE:APA91bHqDvGqF4wApJWaV9fDRxdYeDHF6q5tSzIMQVPHpGSNEs0t0ZLvyYDvJlqNa0agtSXDFWqzPxQAgLaYKdiLSdNGlBpTFb6RMKV3696khu735keJvKgdXa3w6t6eKLXi0s9dv4HP',
            'cRayTCgSuVE:APA91bFLIFJ-5eujS7CRDYVeMToJAPClt_zX6zmj-u7sHeCjCUr0NeY4ok4UotfcZPOsCCQRJ0oKPYYw1CA1AiXbE4JmBp3PJMoaQsRTDQq0rV2K0v333udKiY8r_SP5UPD-9NUMm6VM'
        ];

        $db_collection = Device::whereIn('device_token', $tokenData)->get();
        foreach ($db_collection as $collection) {
            if ($collection['device_type'] == 'android') {
                $android_token[] = $collection['device_token'];
                $android_type = 'android';
            } else {
                $ios_token[] = $collection['device_token'];
                $ios_type = 'ios';
            }
        }

        if ($android_token) {
            $this->sendNotification($android_token, "Test Title", $data, 'android');
        }
        if ($ios_token) {
            $this->sendNotification($ios_token, "Test Title", $data, 'ios');
        }
    }
}
