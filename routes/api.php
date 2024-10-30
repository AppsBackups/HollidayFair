<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*User Basic Apis*/
Route::post('users/login', 'Api\UserController@userLogin');
Route::post('users/register', 'Api\UserController@userRegister');
Route::post('users/forgot-password', 'Api\UserController@userForgotPassword');
Route::get('users/reset-password/{token}', 'Api\UserController@userResetForm');
Route::post('users/userResetPassword', 'Api\UserController@userResetPassword')->name('user.reset');

Route::group(['middleware' => 'auth:api'], static function () {
    Route::post('users/details', 'Api\UserController@getLoggedInUserDetails');
    Route::post('users/update-profile', 'Api\UserController@userUpdateProfile');
    Route::post('users/change-password', 'Api\UserController@userChangePassword');
    Route::post('users/logout', 'Api\UserController@userLogout');

    /*Vendor*/
    Route::post('vendor/add-remove-planner', 'Api\VendorController@addRemoveShowPlanner');
    Route::post('vendor/add-remove-visited', 'Api\VendorController@addRemovevisited');


    /*Show Planner*/
    Route::post('show-planner/list', 'Api\VendorController@showPlanner');
});

Route::middleware('auth:api')->get('/user', static function (Request $request) {
    return $request->user();
});

/*Site Information Apis*/
Route::post('siteinfo/sponsor', 'Api\SiteInformationController@sponsorDetails');
Route::post('siteinfo/show-information', 'Api\SiteInformationController@siteInfoPage');
Route::post('social', 'Api\SiteInformationController@socialMedia');

/*Floor Plan*/
Route::post('floor-plan', 'Api\SiteInformationController@floorPlan');
Route::post('event/list', 'Api\SiteInformationController@events');
Route::post('event/details', 'Api\SiteInformationController@showEvents');
Route::post('advertise', 'Api\SiteInformationController@advertisementList');
Route::post('interstitial-ads', 'Api\SiteInformationController@interstitialAdsList');


/*message */
Route::post('announcements/list', 'Api\SiteInformationController@announcementList');
Route::post('announcements/details', 'Api\SiteInformationController@showAnnouncement');


/*Vendor*/
Route::post('vendor/product-category', 'Api\VendorController@productCategory');
Route::post('vendor/list', 'Api\VendorController@index');
Route::post('vendor/featured-vendor-list', 'Api\VendorController@getFeaturedVendor');
Route::post('vendor/category-vendor-list', 'Api\VendorController@getFeaturedVendorByCategory');
Route::post('vendor/details', 'Api\VendorController@show');
Route::post('vendor/search', 'Api\VendorController@search');


/*Device data*/
Route::post('device-login', 'Api\UserController@deviceLogin');

/*Plash*/
Route::post('splash', 'Api\SiteInformationController@plashScreen');


