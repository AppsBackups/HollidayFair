<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Event;
use App\Http\Controllers\BaseController;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;



class AdminDashboardController extends BaseController
{
    protected $redirectTo = '/dashboard';

    protected $guard = 'admin';

    protected $loginPath = '/login';

    public function index()
    {
        $data['total_user']=User::select('id')->where('user_type','=','user')->count();
        $data['total_category']=Category::select('id')->count();
        $data['total_vendor']=Vendor::select('id')->count();
        $data['total_event']=Event::select('id')->count();
        $data['latest_event']=Event::orderBy('id', 'desc')->take(5)->get();
        $data['latest_vendor']=Vendor::orderBy('id', 'desc')->take(7)->get();
        $pageName = 'Welcome to Admin Dashboard';

        $data['pageName'] = $pageName;
        return view('dashboard', $data);
    }


}
