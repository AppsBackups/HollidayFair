<?php

namespace App\Http\Controllers\Admin;

use App\Advertise;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AdvertiseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Advertise::orderBy('id', 'desc')->get();

            if ($data) {
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function ($row) {
                        if ($row['advertisement_image']) {
                            return '<img src="' . asset('uploads/' . $row['advertisement_image']) . '" width="300px">';
                        } else {
                            return '<img src="' . asset('uploads/images/gallary.png') . '" width="300px">';
                        }

                    })
                    ->addColumn('action', function ($row) {
                        $html = '<span  class="delete_btn" data-toggle="modal" data-target="#delete_record" id="' . $row['id'] . '">
                                 <i class="fa fa-trash-o" aria-hidden="true"></i></span>';

                        return $html;
                    })
                    ->rawColumns(['image','action'])
                    ->make(true);
            }

        }
        $pageName = 'Advertise';

        $data['pageName'] = $pageName;
        return view('advertise', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'advertisement_image' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }
        if ($request->hasFile('advertisement_image')) {

            $upload = $this->uploadImageWithThumbnail($request, 'advertise', 'advertisement_image');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }

            $input['advertisement_image'] = $data->data;
        }
        $category = Advertise::create($input);
        return $this->respondSuccess('Advertise added Successfully.', 200);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dbCollection = Advertise::where('id', '=', $id)->delete();
        if ($dbCollection) {
            return $this->respondSuccess('Advertise Deleted Successfully.', 200);
        }
        return $this->respondWithError('Advertise was not Deleted', 200);
    }
}
