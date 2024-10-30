<?php


namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Mail;
use Yajra\DataTables\DataTables;

class WebContactController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Contact::orderBy('id', 'desc')->get();

            if ($data) {
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('reply', function ($row) {
                        $reply = 'No';
                        if ($row['reply'] == 1) {
                            $reply = 'Yes';
                        }

                        return $reply;
                    })
                    ->addColumn('action', function ($row) {
                        $html = '<button class="view_btn" id="' . $row['id'] . '" data-toggle="modal"
                                                    data-target="#view_contact"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 <button href="#" class="edit_btn" id="' . $row['id'] . '" data-toggle="modal"
                                                    data-target="#reply_answer"><i class="mdi mdi-reply" aria-hidden="true"></i></button>
                                 <span  class="delete_btn" data-toggle="modal" data-target="#delete_record" id="' . $row['id'] . '">
                                 <i class="fa fa-trash-o" aria-hidden="true"></i></span>';

                        return $html;
                    })
                    ->rawColumns(['reply', 'action'])
                    ->make(true);
            }

        }

        $pageName = 'Web Contacts';

        $data['pageName'] = $pageName;
        return view('web-contact', $data);
    }

    public function show($id)
    {
        $dbCollection = Contact::where('id', '=', $id)->first();
        if ($dbCollection) {

            return $this->respondData($dbCollection);
        }
        return $this->respondWithError('Something wrong.', '200');
    }

    public function reply(Request $request, $id) {

        $input=$request->all();
        Mail::send('vendor.mail.contact-replay', $request->all(), function ($messages) use ($input) {

            $messages->to($input['email'], $input['full_name'])
                ->subject('Reply from ' . env('APP_NAME'));
        });


        $contact = Contact::where('id', $id)->update(['reply'=>'1']);
        return $this->respondSuccess('Message Reply Successfully.', 200);
    }


    public function destroy($id) {
        $dbCollection = Contact::where('id', '=', $id)->delete();
        if ($dbCollection) {
            return $this->respondSuccess('Message Delete Successfully.', 200);
        }
        return $this->respondWithError('Message was not Deleted', 200);
    }

}
