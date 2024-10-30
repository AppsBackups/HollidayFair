<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\BaseController;
use App\Planner;
use App\Vendor;
use App\Visitor;
use Auth;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VendorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Cache::remember('vendors', $minutes = '1440', function () {
        //     $dbCollection = Vendor::select('id', 'name', 'logo', 'booth_number')->get();
        //     $dbCollection = $dbCollection->sortBy('name');

        //     $results = $dbCollection->groupBy(function ($item, $key) {
        //         return strtoupper(substr($item['name'], 0, 1));
        //     });

        //     $vendor = [];
        //     foreach ($results as $key => $value) {
        //         foreach ($value as $val) {
        //             if (substr($val['logo'], 0, 6) == 'vendor') {
        //                 $val['logo'] = config('app.MEDIA_URL') . $val['logo'];
        //             }

        //         }
        //         $data['letter'] = $key;
        //         $data['vendors'] = $value;
        //         $vendor[] = $data;
        //     }
        //     return $this->respondWithData($vendor);
        // });
        $dbCollection = Vendor::select('id', 'name', 'logo', 'booth_number')->get();
        $dbCollection = $dbCollection->sortBy('name');

        $results = $dbCollection->groupBy(function ($item, $key) {
            return strtoupper(substr($item['name'], 0, 1));
        });

        $vendor = [];
        foreach ($results as $key => $value) {
            foreach ($value as $val) {
                if (substr($val['logo'], 0, 6) == 'vendor') {
                    $val['logo'] = config('app.MEDIA_URL') . $val['logo'];
                }

            }
            $data['letter'] = $key;
            $data['vendors'] = $value;
            $vendor[] = $data;
        }
        return $this->respondWithData($vendor);


    }

    /*Product Category*/
    public function productCategory()
    {
        $category = Category::orderBy('category_name', 'asc')->paginate(50);
        return $this->respondWithData($category);
    }


    /**
     * Display a featured vendor
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getFeaturedVendorByCategory(Request $request)
    {
        $categoryId = $request->category_id;
        $featuredVendor = Vendor::select('id', 'name', 'logo')->where('featured', '=',
            1)->whereRaw("FIND_IN_SET($categoryId,category_id)")->orderBy('name', 'asc')->get();
        $Vendor = Vendor::select('id', 'name', 'logo')->where('featured', '=',
            0)->whereRaw("FIND_IN_SET($categoryId,category_id)")->orderBy('name', 'asc')->paginate(50);

        foreach ($featuredVendor as $val) {
            if (substr($val['logo'], 0, 6) == 'vendor') {
                $val['logo'] = config('app.MEDIA_URL') . $val['logo'];
            }

        }
        foreach ($Vendor as $val) {
            if (substr($val['logo'], 0, 6) == 'vendor') {
                $val['logo'] = config('app.MEDIA_URL') . $val['logo'];
            }

        }


        $data['featured_vendor'] = $featuredVendor;
        $data['vendors'] = $Vendor;

        return $this->respondWithData($data);
    }

    public function getFeaturedVendor()
    {
        $featuredVendor = Vendor::select('id', 'name', 'logo')->where('featured', '=', 1)->orderBy('name',
            'asc')->get();
        foreach ($featuredVendor as $val) {
            if (substr($val['logo'], 0, 6) == 'vendor') {
                $val['logo'] = config('app.MEDIA_URL') . $val['logo'];
            }

        }
        return $this->respondWithData($featuredVendor);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $vendorId = $request->id;

        $vendor = Vendor::with('vendorPhotos')->where('id', '=', $vendorId)->first();
        $access_token = $request->header('Authorization');
        $auth_header = explode(' ', $access_token);
        if (@$auth_header[1]) {
            $token = $auth_header[1];

            $token_parts = explode('.', $token);
            $token_header = $token_parts[0];

            $token_header_json = base64_decode($token_header);
            $token_header_array = json_decode($token_header_json, true);

            $user_token = $token_header_array['jti'];

            $userId = DB::table('oauth_access_tokens')->where('id', $user_token)->value('user_id');

            $planner = Planner::where('user_id', '=', $userId)->where('vendor_id', '=', $vendor['id'])->count();
            $vendor['planner'] = $planner;

            $visited = Visitor::where('user_id', '=', $userId)->where('vendor_id', '=', $vendor['id'])->count();
            $vendor['visited'] = $visited;
        } else {
            $vendor['planner'] = 0;
            $vendor['visited'] = 0;
        }
        if (substr($vendor['booth_map'], 0, 6) == 'vendor') {
            $vendor['booth_map'] = config('app.MEDIA_URL') . $vendor['booth_map'];
        }

        if (substr($vendor['logo'], 0, 6) == 'vendor') {
            $vendor['logo'] = config('app.MEDIA_URL') . $vendor['logo'];
        }

        foreach ($vendor['vendorPhotos'] as $photos)
        {
            if (substr($photos['photo'], 0, 6) == 'vendor') {
                $photos['photo'] = config('app.MEDIA_URL') . $photos['photo'];
            }
        }

        $category = Category::whereIn('id', explode(',', $vendor['category_id']))->get();
        $vendor['vendor_category'] = $category;

        return $this->respondWithData($vendor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function addRemoveShowPlanner(Request $request)
    {
        $vendorId = $request->id;
        $userId = Auth::user()->id;

        $planner = Planner::where('user_id', '=', $userId)->where('vendor_id', '=', $vendorId)->first();
        if ($planner) {
            $addPlanner = Planner::where('user_id', '=', $userId)->where('vendor_id', '=', $vendorId)->delete();
            return $this->respondSuccess('Show Planner Removed Sucessfully!', 200);
        } else {
            $input['vendor_id'] = $vendorId;
            $input['user_id'] = $userId;
            $addPlanner = Planner::create($input);
            return $this->respondSuccess('Show Planner Added Sucessfully!', 200);
        }
        return $this->respondWithError('Doesn\'t add to your show planner.', 401);

    }

    public function addRemovevisited(Request $request)
    {
        $vendorId = $request->id;
        $userId = Auth::user()->id;

        $planner = Visitor::where('user_id', '=', $userId)->where('vendor_id', '=', $vendorId)->first();
        if ($planner) {
            $addPlanner = Visitor::where('user_id', '=', $userId)->where('vendor_id', '=', $vendorId)->delete();
            return $this->respondSuccess('Mark as Visited remove Sucessfully!', 200);
        } else {
            $input['vendor_id'] = $vendorId;
            $input['user_id'] = $userId;
            $addPlanner = Visitor::create($input);
            return $this->respondSuccess('Mark as Visited Sucessfully!', 200);
        }
        return $this->respondWithError('Doesn\'t Mark as visited.', 401);

    }

    public function search(Request $request)
    {
        $search = $request->search;
        $dbCollection = Vendor::select('id', 'name', 'logo')->where('name', 'like', '%' . $search . '%')->paginate(50);
        if ($dbCollection) {
            foreach ($dbCollection as $val) {
                if (substr($val['logo'], 0, 6) == 'vendor') {
                    $val['logo'] = config('app.MEDIA_URL') . $val['logo'];
                }

            }

            return $this->respondWithData($dbCollection);
        }
        return $this->respondWithError('Vendor not Found.', 401);
    }

    public function showPlanner(Request $request)
        {
            $short_by = $request->short_by;
            if ($short_by == '') {
                $short_by = 'name';
            }
            $userId = Auth::user()->id;
            $dbCollection = Planner::join('vendors', 'vendors.id', '=',
                'vendors_planner.vendor_id')->leftjoin('vendors_visit', function ($join) {
                $join->on('vendors_visit.vendor_id', '=', 'vendors_planner.vendor_id')
                    ->on('vendors_visit.user_id', '=', 'vendors_planner.user_id');
            })->select('vendors.id', 'vendors.name', 'vendors.logo', 'vendors.booth_number', 'vendors.booth_hall',
                'vendors_visit.id as visited_id')->where('vendors_planner.user_id', '=',
                $userId)->orderby('vendors.' . $short_by . '')->get();


            if ($short_by == 'booth_hall') {
                $dbCollection = $dbCollection->sortBy('' . $short_by . '');
                $results = $dbCollection->groupBy(function ($item, $key) {
                    return substr($item['booth_hall'], 0,10 );
                });
                $vendor = [];
                foreach ($results as $key => $value) {
                    foreach ($value as $val) {
                        if (substr($val['logo'], 0, 6) == 'vendor') {
                            $val['logo'] = config('app.MEDIA_URL') . $val['logo'];
                        }
                    }
                    $data['letter'] = $key;
                    $data['vendors'] = $value;
                    $vendor[] = $data;
                }
                return $this->respondWithData($vendor);
            }
           
            foreach ($dbCollection as $val) {
                if (substr($val['logo'], 0, 6) == 'vendor') {
                    $val['logo'] = config('app.MEDIA_URL') . $val['logo'];
                }

            }
            return $this->respondWithData($dbCollection);
        }
}
