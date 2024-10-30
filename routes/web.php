<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/

use App\Device;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

Route::get('/', 'WebPageController@homePage')->name('/');
Route::get('/privacy-policy', 'WebPageController@privacyPage')->name('privacy-policy');
Route::get('/faq','WebPageController@faqPage' )->name('faq');
Route::get('/term-condition','WebPageController@termPage')->name('term-condition');
Route::post('contact','WebPageController@contactSubmit')->name('contact-us');
Route::get('/#contact','WebPageController@homePage');

Auth::routes();
Route::group(['prefix' => '/'], function () {

    Route::get('login', 'Admin\Auth\LoginController@show')->name('login');
    Route::post('login', 'Admin\Auth\LoginController@login')->name('login.submit');
    Route::get('logout', 'Admin\Auth\LoginController@logout')->name('logout');

    /* Forgot Password Routes */
    Route::get('password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::any('password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('password.update');

    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('test', 'Admin\AnnouncementController@test');
        
        Route::get('dashboard', 'Admin\AdminDashboardController@index')->name('admin.dashboard');
        Route::get('update-profile', 'Admin\AdminProfileController@index')->name('admin.profile');
        Route::post('edit-profile', 'Admin\AdminProfileController@edit')->name('admin.edit-profile');
        Route::post('change-password', 'Admin\AdminProfileController@changePassword')->name('admin.change-password');

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'Admin\AdminUserController@index')->name('users.index');
            Route::post('/create', 'Admin\AdminUserController@create')->name('users.create');
            Route::post('/{id}/update', 'Admin\AdminUserController@update')->name('users.update');
            Route::post('/{id}/show', 'Admin\AdminUserController@show')->name('users.show');
            Route::post('/{id}/edit', 'Admin\AdminUserController@edit')->name('users.edit');
            Route::delete('/{id}/delete', 'Admin\AdminUserController@destroy')->name('users.destroy');
        });

        Route::group(['prefix' => 'event'], function () {
            Route::get('/', 'Admin\AdminEventController@index')->name('event.index');
            Route::post('/create', 'Admin\AdminEventController@create')->name('event.create');
            Route::post('/{id}/update', 'Admin\AdminEventController@update')->name('event.update');
            Route::post('/{id}/show', 'Admin\AdminEventController@show')->name('event.show');
            Route::post('/{id}/edit', 'Admin\AdminEventController@edit')->name('event.edit');
            Route::delete('/{id}/delete', 'Admin\AdminEventController@destroy')->name('event.destroy');
        });

        Route::group(['prefix' => 'site-info'], function () {
            Route::get('/', 'Admin\SiteInformationController@index')->name('site-info.index');
            Route::post('/{id}/update', 'Admin\SiteInformationController@update')->name('site-info.update');
            Route::post('/{id}/show', 'Admin\SiteInformationController@show')->name('site-info.show');
            Route::post('/{id}/edit', 'Admin\SiteInformationController@edit')->name('site-info.edit');
            Route::delete('/{id}/delete', 'Admin\SiteInformationController@destroy')->name('site-info.destroy');
        });
        Route::group(['prefix' => 'contact-us'], function () {
            Route::get('/', 'Admin\ContactController@index')->name('contact-us.index');
            Route::post('/{id}/update', 'Admin\ContactController@update')->name('contact-us.update');
            Route::post('/{id}/edit', 'Admin\ContactController@edit')->name('contact-us.edit');
        });
        Route::group(['prefix' => 'announcement'], function () {
            Route::get('/', 'Admin\AnnouncementController@index')->name('announcement.index');
            Route::post('/create', 'Admin\AnnouncementController@create')->name('announcement.create');
            Route::post('/{id}/show', 'Admin\AnnouncementController@show')->name('announcement.show');
            Route::delete('/{id}/delete', 'Admin\AnnouncementController@destroy')->name('announcement.destroy');
        });
        
        Route::group(['prefix' => 'interstitial'], function () {
            Route::get('/', 'Admin\InterstitialController@index')->name('interstitial.index');
            Route::post('/create', 'Admin\InterstitialController@create')->name('interstitial.create');
            Route::post('/update', 'Admin\InterstitialController@update')->name('interstitial.update');
            Route::post('/{id}/show', 'Admin\InterstitialController@show')->name('interstitial.show');
            Route::delete('/{id}/delete', 'Admin\InterstitialController@destroy')->name('interstitial.destroy');
        });
        Route::group(['prefix' => 'social'], function () {
            Route::get('/', 'Admin\SocialController@index')->name('social.index');
            Route::post('/create', 'Admin\SocialController@create')->name('social.create');
            Route::post('/{id}/update', 'Admin\SocialController@update')->name('social.update');
            Route::post('/{id}/edit', 'Admin\SocialController@edit')->name('social.edit');
            Route::delete('/{id}/delete', 'Admin\SocialController@destroy')->name('social.destroy');
        });
        Route::group(['prefix' => 'sponsor'], function () {
            Route::get('/', 'Admin\SponsorController@index')->name('sponsor.index');
            Route::post('/{id}/update', 'Admin\SponsorController@update')->name('sponsor.update');
            Route::post('/{id}/edit', 'Admin\SponsorController@edit')->name('sponsor.edit');
        });
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'Admin\ProductCategoryController@index')->name('category.index');
            Route::post('/create', 'Admin\ProductCategoryController@create')->name('category.create');
            Route::delete('/{id}/delete', 'Admin\ProductCategoryController@destroy')->name('category.destroy');
        });
        Route::group(['prefix' => 'advertise'], function () {
            Route::get('/', 'Admin\AdvertiseController@index')->name('advertise.index');
            Route::post('/create', 'Admin\AdvertiseController@create')->name('advertise.create');
            Route::delete('/{id}/delete', 'Admin\AdvertiseController@destroy')->name('advertise.destroy');
        });

        Route::group(['prefix' => 'vendors'], function () {
            Route::get('/', 'Admin\VendorController@index')->name('vendors.index');
            Route::post('/create', 'Admin\VendorController@create')->name('vendors.create');
            Route::post('/{id}/update', 'Admin\VendorController@update')->name('vendors.update');
            Route::post('/{id}/show', 'Admin\VendorController@show')->name('vendors.show');
            Route::post('/{id}/edit', 'Admin\VendorController@edit')->name('vendors.edit');
            Route::delete('/{id}/delete', 'Admin\VendorController@destroy')->name('vendors.destroy');
            Route::post('/upload-excel', 'Admin\VendorController@uploadExcel')->name('vendors.upload-excel');
        });

        Route::group(['prefix' => 'web-page'], function () {
            Route::get('/', 'Admin\WebPageController@index')->name('web-page.index');
            Route::post('/{id}/update', 'Admin\WebPageController@update')->name('web-page.update');
            Route::post('/{id}/show', 'Admin\WebPageController@show')->name('web-page.show');
            Route::post('/{id}/edit', 'Admin\WebPageController@edit')->name('web-page.edit');
        });

        Route::group(['prefix' => 'web-contact'], function () {
            Route::get('/', 'Admin\WebContactController@index')->name('web-contact.index');
            Route::post('/{id}/reply', 'Admin\WebContactController@reply')->name('web-contact.reply');
            Route::post('/{id}/show', 'Admin\WebContactController@show')->name('web-contact.show');
            Route::delete('/{id}/delete', 'Admin\WebContactController@destroy')->name('web-contact.destroy');
        });

        Route::group(['prefix' => 'splash'], function () {
            Route::get('/', 'Admin\PlashController@index')->name('splash.index');
            Route::post('/{id}/edit', 'Admin\PlashController@edit')->name('splash.edit');
            Route::post('/{id}/update', 'Admin\PlashController@update')->name('splash.update');
        });

        Route::group(['prefix' => 'floor-plan'], function () {
            Route::get('/', 'Admin\FloorPlanController@index')->name('floor-plan.index');
            Route::post('/{id}/edit', 'Admin\FloorPlanController@edit')->name('floor-plan.edit');
            Route::post('/{id}/update', 'Admin\FloorPlanController@update')->name('floor-plan.update');
        });

        Route::get('file-managers', function () {
            return view('filemanager');
        })->name('file-manager');


        Route::get('/filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
        Route::post('/filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
    });

});


Route::get('/home', 'HomeController@index')->name('home');
