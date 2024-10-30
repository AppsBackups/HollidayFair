<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['data'] = SocialMedia::all();
        $pageName = 'Social Media';

        $data['pageName'] = $pageName;
        return view('social', $data);
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
            'social_icon' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        if ($request->hasFile('social_icon')) {

            $upload = $this->uploadImageWithThumbnail($request, 'images', 'social_icon');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }

            $input['social_icon'] = $data->data;
        }
        $social = SocialMedia::create($input);

        return $this->respondSuccess('Social Media added Successfully.', 200);
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
        $dbCollection = SiteInformation::find($id);
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
        $dbCollection = SocialMedia::find($id);
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
        if ($request->hasFile('social_icon')) {

            $upload = $this->uploadImageWithThumbnail($request, 'images', 'social_icon');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }
            $this->removeImage($request->old_image);
            $input['social_icon'] = $data->data;
        }
        $input['social_type'] = $request->social_type;
        $input['social_link'] = $request->social_link;
        $event = SocialMedia::where('id', $id)->update($input);;

        return $this->respondSuccess('Social Media Updated Successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dbCollection = SocialMedia::where('id', '=', $id)->delete();
        if ($dbCollection) {
            return $this->respondSuccess('Social Media Successfully.', 200);
        }
        return $this->respondWithError('Social Media was not Deleted', 200);
    }
}
