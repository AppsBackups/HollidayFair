<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Plash;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PlashController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = plash::orderBy('id', 'desc')->first();
        $data['images'] = explode(',', $data['images']);
        $pageName = 'Splash Screen';

        $data['pageName'] = $pageName;
        return view('plash', $data);
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
        $dbCollection = Plash::find($id);
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
        $dbCollection = Plash::find($id);
        if ($dbCollection) {
            $images = explode(',', $dbCollection['images']);

            foreach ($images as $img) {
                $photo[] = config('app.MEDIA_URL') . 'images/' . $img;
            }
            $dbCollection['photos'] = $photo;
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
        $dbCollection = Plash::find($id);
        $images = explode(',', $dbCollection['images']);
        if ($request->removephoto) {
            $result = array_unique($request->removephoto);
            foreach ($result as $req) {
                unset( $images[array_search( $req, $images )] );
            }
        }
        if ($request->hasFile('logo')) {

            $upload = $this->uploadImageWithThumbnail($request, 'images', 'logo');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }
            $input['logo'] = $data->data;
        }


        if ($request->hasFile('photo')) {
            $files = $request->file('photo');
            $dataSet = [];
            $i = 0;
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $uploadFolder = public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
                $thumbnailImage = Image::make($file);
                $createImageName = time() . $i . '.' . $extension;
                $originalPath = $uploadFolder . 'images' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;
                $thumbnailImage->save($originalPath . $createImageName);
                $dataSet[] = $createImageName;
                $i++;
            }
            $images=array_merge($images,$dataSet);

        }
        $input['images'] = implode(',', $images);
        $input['title'] = $request->title;
        $input['description'] = $request->description;

        $plash = Plash::where('id', $id)->update($input);
        return $this->respondSuccess('Plash Updated Successfully.', 200);

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
