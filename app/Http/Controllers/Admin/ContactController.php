<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\SiteInformation;
use Illuminate\Http\Request;

class ContactController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = SiteInformation::where('site_slug', '=',
            'contact_us')->orderBy('id', 'desc')->first();

        $pageName = 'Contact Details';

        $data['pageName'] = $pageName;
        return view('contact-us', $data);
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
        $dbCollection = SiteInformation::find($id);
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
        $dbCollection = SiteInformation::find($id);
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
    {
        $input['site_description'] = $request->site_description;
        $event = SiteInformation::where('id', $id)->update($input);;

        return $this->respondSuccess('Contact Details Updated Successfully.', 200);
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
