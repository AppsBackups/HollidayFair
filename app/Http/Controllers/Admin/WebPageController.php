<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\WebPage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WebPageController extends BaseController
{
    public function index(Request $request)
    {


        if ($request->ajax()) {

            $data = WebPage::get();

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
        $pageName = 'Web-Page';

        $data['pageName'] = $pageName;
        return view('web-page', $data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dbCollection = WebPage::find($id);
        if ($dbCollection) {
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
        $dbCollection = WebPage::find($id);
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
        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $record = WebPage::where('id', $id)->update($input);

        return $this->respondSuccess('Page Updated Successfully.', 200);
    }

}
