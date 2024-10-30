<?php

namespace App\Http\Controllers\Admin;

use App\Interstitial;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\SiteInformation;
class InterstitialController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Interstitial::orderBy('id', 'desc')->get();

            if ($data) {
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function ($row) {
                        // return $row->advertisement_object;
                        $arr = json_decode($row->advertisement_object);
// return $arr;
                        $data = '';
                        for($i=0;$i<count($arr);$i++){
                            if ($arr[$i]->image) {
                                $data .= '<a href="'.$arr[$i]->link.'" target="_blank" title="'. $arr[$i]->link.' Seconds"><img src="' . asset('uploads/' . $arr[$i]->image) . '" width="100px" style="margin:10px;"></a>';
                            } else {
                                $data .= '<img src="' . asset('uploads/images/gallary.png') . '" width="300px"> ';
                            }
                        }
                        return $data;

                    })
                    ->addColumn('action', function ($row) {
                        $html = '<span  class="delete_btn" data-toggle="modal" data-target="#delete_record" id="' . $row['id'] . '">
                                 <i class="fa fa-trash-o" aria-hidden="true"></i></span>';

                        return $html;
                    })
                    ->addColumn('is_splash_page', function ($row) {
                      
                        return ($row->is_splash_page=='y')?'Yes':'';
                    })
                    ->rawColumns(['image','action'])
                    ->make(true);
            }

        }
        $pageName = 'Interstitial';

        $data['pageName'] = $pageName;
        $siteInfoData = SiteInformation::where('site_slug','ads_page_counter')->first(); // Table : site_information
        $data['id'] = $siteInfoData->id;
        $data['perPageValue'] = $siteInfoData->site_description;
        return view('interstitial', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        
        // \Log::info($input['is_splash_page']);
        // dd($input['is_splash_page']);
        $validator = Validator::make($request->all(), [
            // 'interstitialment_image' => 'required',
        ]);
        // if ($validator->fails()) {
        //     $errors = collect($validator->errors());
        //     $error = $errors->unique()->first();
        //     return $this->respondWithError($error[0], 200);
        // }

        if ($request->hasFile('interstitialment_image')) {
            $tempArr = [];
            $upload = $this->uploadImageArrWithThumbnail($request, 'interstitial', 'interstitialment_image');
            $upload = json_decode($upload->getContent())->data;
            for($i=0;$i<count($upload);$i++)
            {
                $tempArr[$i]['image'] = $upload[$i];
                $tempArr[$i]['link'] = $input['interstitialment_link'][$i];
                // $tempArr[$i]['time'] = $input['interstitialment_time'][$i];
            }
            // return $upload;
            // $data = json_decode($upload->getContent());
            // if ($data->success != 1) {
            //     return $this->respondWithError($data->message, 200);
            // }

            // $input['interstitialment_image'] = $data->data;
        }
        $is_splash_page = 'n';
        if(isset($input['is_splash_page']))
        {
            $is_splash_page = 'y';
            Interstitial::where('is_splash_page','y')->update(['is_splash_page'=>'n']);
        }
        $category = Interstitial::create([
            'name'=>$input['name'],
            'display_time' => $input['display_time'],
            'is_splash_page' => $is_splash_page,
            'advertisement_object'=>json_encode($tempArr)]
        );
        return $this->respondSuccess('Interstitial added Successfully.', 200);
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
    public function update(Request $request)
    {

        $data = SiteInformation::find($request->id);
        $data->update(['site_description'=>$request->site_description]);
        return $this->respondSuccess('Interstitial Ads After no. of Page updated Successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dbCollection = Interstitial::where('id', '=', $id)->delete();
        if ($dbCollection) {
            return $this->respondSuccess('Interstitial Deleted Successfully.', 200);
        }
        return $this->respondWithError('Interstitial was not Deleted', 200);
    }
}
