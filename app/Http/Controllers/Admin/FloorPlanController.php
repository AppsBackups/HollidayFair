<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\FloorPlan;


class FloorPlanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = FloorPlan::orderBy('id', 'asc')->first();

        $pageName = 'Floor Plan';

        $data['pageName'] = $pageName;
        return view('floore-plan', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

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
        $dbCollection = FloorPlan::find($id);
        if ($dbCollection) {
            return $this->respondData($dbCollection);
        }
        return $this->respondWithError('Something wrong.', '401');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dbCollection = FloorPlan::find($id);
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
    {   $input=[];
        if ($request->hasFile('floor_image')) {

            $upload = $this->uploadImageWithThumbnail($request, 'floor', 'floor_image');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }
            $this->removeImage($request->old_image);
            $input['floor_image'] = $data->data;
        }

        $event = FloorPlan::where('id', $id)->update($input);

        return $this->respondSuccess('Floor Plan Image Updated Successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
