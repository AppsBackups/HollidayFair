<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\BaseController;
use App\Imports\VendorImport;
use App\Vendor;
use App\vendorPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;


class VendorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Vendor::select('name', 'booth_number', 'email', 'id', 'phone', 'website',
                'featured')->orderBy('id', 'desc')->get();

            if ($data) {
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('featured', function ($row) {
                        $featured = 'No';
                        if ($row['featured'] == 1) {
                            $featured = 'Yes';
                        }

                        return $featured;
                    })
                    ->addColumn('action', function ($row) {
                        $html = '<button class="view_btn" id="' . $row['id'] . '"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 <button href="#" class="edit_btn" id="' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                 <span  class="delete_btn" data-toggle="modal" data-target="#delete_record" id="' . $row['id'] . '">
                                 <i class="fa fa-trash-o" aria-hidden="true"></i></span>';

                        return $html;
                    })
                    ->rawColumns(['featured', 'action'])
                    ->make(true);
            }

        }
        $db_collection = Category::get();

        foreach ($db_collection as $key => $value) {
            $category[$value['id']] = $value['category_name'];
        }
        $data['category'] = $category;
        $pageName = 'Vendors';

        $data['pageName'] = $pageName;
        return view('vendor', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors());

            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $input = $request->all();

        if ($request->hasFile('logo')) {

            $upload = $this->uploadImageWithThumbnail($request, 'vendor', 'logo');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }

            $input['logo'] = $data->data;
        }


        if ($request->hasFile('booth_map')) {

            $upload = $this->uploadImageWithThumbnail($request, 'vendor', 'booth_map');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }

            $input['booth_map'] = $data->data;
        }

        $input['category_id'] = implode(',', $input['category_id']);

        $vendor = Vendor::create($input);


        if ($vendor) {

            if ($request->hasFile('photo')) {
                $files = $request->file('photo');
                $dataSet = [];$i=0;
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $uploadFolder = public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
                    $thumbnailImage = Image::make($file);
                    $createImageName = time() .$i .'.' . $extension;
                    $originalPath = $uploadFolder . 'vendor' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;
                    $thumbnailImage->save($originalPath . $createImageName);
                    $dataSet[] = [
                        'vendor_id' => $vendor['id'],
                        'photo' => 'vendor/' . $createImageName,
                    ];
                    $i++;
                }
                vendorPhoto::insert($dataSet);
            }
        }
        return $this->respondSuccess('Vendor added Successfully.', 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
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
        $dbCollection = Vendor::with('vendorPhotos')->where('id', '=', $id)->first();
        if ($dbCollection) {
            $category = Category::select('category_name')->whereIn('id',
                explode(',', $dbCollection['category_id']))->get();
            $dbCollection['vendor_category'] = $category;

            if (substr($dbCollection['logo'], 0, 6) == 'vendor') {
                $dbCollection['logo'] = config('app.MEDIA_URL') . $dbCollection['logo'];
            }
            if (substr($dbCollection['booth_map'], 0, 6) == 'vendor') {
                $dbCollection['booth_map'] = config('app.MEDIA_URL') . $dbCollection['booth_map'];
            }
            foreach ($dbCollection['vendorPhotos'] as $val) {
                if (substr($val['photo'], 0, 6) == 'vendor') {
                    $val['photo'] = config('app.MEDIA_URL') . $val['photo'];
                }
            }
            return $this->respondData($dbCollection);
        }
        return $this->respondWithError('Something wrong.', '200');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $dbCollection = Vendor::with('vendorPhotos')->find($id);
        if ($dbCollection) {
            foreach ($dbCollection['vendorPhotos'] as $val) {
                if (substr($val['photo'], 0, 6) == 'vendor') {
                    $val['photo'] = config('app.MEDIA_URL') . $val['photo'];
                }
            }
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
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors());

            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }
        if ($request->hasFile('logo')) {

            $upload = $this->uploadImageWithThumbnail($request, 'vendor', 'logo');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }

            $input['logo'] = $data->data;
        }

        if ($request->hasFile('booth_map')) {

            $upload = $this->uploadImageWithThumbnail($request, 'vendor', 'booth_map');
            $data = json_decode($upload->getContent());
            if ($data->success != 1) {
                return $this->respondWithError($data->message, 200);
            }

            $input['booth_map'] = $data->data;
        }

        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['booth_number'] = $request->booth_number;
        $input['booth_hall'] = $request->booth_hall;
        $input['phone'] = $request->phone;
        $input['website'] = $request->website;
        $input['description'] = $request->description;
        $input['category_id'] = implode(',', $request->category_id);
        $input['featured'] = $request->featured;

        $vendor = Vendor::where('id', $id)->update($input);

        if($request->removephoto)
        {
            $result = array_unique($request->removephoto);
            foreach ($result as $req) {
                $dbCollection = vendorPhoto::where('id', '=', $req)->delete();
            }
        }
        if ($request->hasFile('photo')) {
            $files = $request->file('photo');
            $dataSet = [];$i=0;
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $uploadFolder = public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
                $thumbnailImage = Image::make($file);
                $createImageName = time() .$i .'.' . $extension;
                $originalPath = $uploadFolder . 'vendor' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;
                $thumbnailImage->save($originalPath . $createImageName);
                $dataSet[] = [
                    'vendor_id' => $id,
                    'photo' => 'vendor/' . $createImageName,
                ];
                $i++;
            }
            vendorPhoto::insert($dataSet);
        }

        return $this->respondSuccess('Vendor Updated Successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $dbCollection = Vendor::where('id', '=', $id)->delete();
        if ($dbCollection) {
            return $this->respondSuccess('User Delete Successfully.', 200);
        }
        return $this->respondWithError('User was not Deleted', 200);
    }

    public function uploadExcel(Request $request) {
        $validator = Validator::make($request->all(), [
            'vendor_file' => 'required|mimes:xls,xlsx',
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $data = Excel::import(new VendorImport(), $request->file('vendor_file'));
        if ($data) {
            return $this->respondSuccess('Vendors addend Successfull.', 200);
        }
        return $this->respondWithError('Something went wrong', 200);
    }

}
