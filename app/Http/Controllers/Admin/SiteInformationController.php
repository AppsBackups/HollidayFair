<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\SiteInformation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SiteInformationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SiteInformation::select('site_title', 'created_at', 'id')->where('site_slug','!=','contact_us')->orderBy('id', 'desc')->get();

            if ($data) {
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('created_at',function ($row)
                    {
                       return $this->dateConvert($row['created_at']);
                    })
                    ->addColumn('action', function ($row) {
                        $html = '<button class="view_btn" id="' . $row['id'] . '" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 <button href="#" class="edit_btn" id="' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                 ';

                        return $html;
                    })
                    ->rawColumns(['created_at','action'])
                    ->make(true);
            }

        }
        $pageName = 'Site Information';

        $data['pageName'] = $pageName;
        return view('site-information', $data);
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
        $dbCollection = SiteInformation::find($id);
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
        $input['site_title'] = $request->site_title;
        $input['site_description'] = $request->site_description;
        $event = SiteInformation::where('id', $id)->update($input);;

        return $this->respondSuccess('Page Updated Successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dbCollection = SiteInformation::where('id', '=', $id)->delete();
        if ($dbCollection) {
            return $this->respondSuccess('Page Deleted Successfully.', 200);
        }
        return $this->respondWithError('Page was not Deleted', 200);
    }
}
