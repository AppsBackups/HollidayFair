<?php

namespace App\Http\Controllers\Admin;


use App\Event;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use DataTables;

class AdminEventController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
        $data = Event::select('event_name', 'event_description', 'created_at', 'id','event_address')->orderBy('id', 'desc')->get();

        if ($data) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at',function ($row)
                {
                    return $this->dateConvert($row['created_at']);
                })
                ->addColumn('action', function ($row) {
                    $html = '<button class="view_btn" id="' . $row['id'] . '"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 <button href="#" class="edit_btn" id="' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                 <span  class="delete_btn" data-toggle="modal" data-target="#delete_record" id="' . $row['id'] . '">
                                 <i class="fa fa-trash-o" aria-hidden="true"></i></span>';

                    return $html;
                })
                ->rawColumns(['created_at','action'])
                ->make(true);
        }

    }
        $pageName = 'Events';

        $data['pageName'] = $pageName;
        return view('event', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        if ($request->hasFile('event_icon')) {

            $upload = $this->uploadImageWithThumbnail($request, 'images', 'event_icon');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }

            $input['event_icon'] = $data->data;
        }
        $event = Event::create($input);

        return $this->respondSuccess('Event added Successfully.', 200);
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
        $dbCollection = Event::find($id);
        if ($dbCollection) {
            return $this->respondData($dbCollection);
        }
        return $this->respondWithError('Something wrong.', '401');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dbCollection = Event::find($id);
        if ($dbCollection) {
            return $this->respondData($dbCollection);
        }
        return $this->respondWithError('Something wrong.', '401');
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

        if ($request->hasFile('event_icon')) {

            $upload = $this->uploadImageWithThumbnail($request, 'images', 'event_icon');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }
            $this->removeImage($request->old_image);
            $input['event_icon'] = $data->data;
        }
        $input['event_name'] = $request->event_name;
        $input['event_description'] = $request->event_description;
        $input['event_address'] = $request->event_address;
        $input['latitude'] = $request->latitude;
        $input['longitude'] = $request->longitude;
        $event = Event::where('id', $id)->update($input);;

        return $this->respondSuccess('Event Updated Successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dbCollection = Event::where('id', '=', $id)->delete();
        if ($dbCollection) {
            return $this->respondSuccess('Event Deleted Successfully.', 200);
        }
        return $this->respondWithError('Event was not Deleted', 200);
    }
}
