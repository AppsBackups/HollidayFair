<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::orderBy('id', 'desc')->get();

            if ($data) {
                return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function ($row) {
                        $html = '<span  class="delete_btn" data-toggle="modal" data-target="#delete_record" id="' . $row['id'] . '">
                                 <i class="fa fa-trash-o" aria-hidden="true"></i></span>';

                        return $html;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

        }
        $pageName = 'Category';

        $data['pageName'] = $pageName;
        return view('category', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $category = Category::create($input);
        return $this->respondSuccess('Category added Successfully.', 200);
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
        $dbCollection = Category::where('id', '=', $id)->delete();
        if ($dbCollection) {
            return $this->respondSuccess('Category Deleted Successfully.', 200);
        }
        return $this->respondWithError('Category was not Deleted', 200);
    }
}
