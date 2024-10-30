<?php

namespace App\Http\Controllers\Api;


use App\Advertise;
use App\Announcement;
use App\Event;
use App\FloorPlan;
use App\Http\Controllers\BaseController;
use App\Plash;
use App\SiteInformation;
use App\SocialMedia;
use App\Sponsor;
use Illuminate\Http\Request;
use App\Interstitial;

class SiteInformationController extends BaseController
{
    /*Sponsor*/
    public function sponsorDetails()
    {
        $sponsor = Sponsor::first();
        if ($sponsor) {
            return $this->respondWithData($sponsor);
        } else {
            return $this->respondWithError('There are no any Sponsor.', 401);
        }

    }

    /*Site Info pages*/
    public function siteInfoPage()
    {
        $siteInfo = SiteInformation::where('is_app_visible',1)->get();
        $contact = '';
        $allPage = [];
        foreach ($siteInfo as $info) {
            if ($info['site_slug'] == 'contact_us') {
                $contact = $info;
            } else {
                $allPage[] = $info;
            }
        }

        $data['contact_us'] = $contact;
        $data['site_info'] = $allPage;
        return $this->respondWithData($data);
    }

    /*Social Medial*/
    public function socialMedia()
    {
        $socialdata = SocialMedia::get();
        $i = 0;
        foreach ($socialdata as $data) {
            if (!empty($data->social_icon)) {
                $socialdata[$i]['social_icon'] = config('app.MEDIA_URL') . $data->social_icon;
            } else {
                $socialdata[$i]['social_icon'] = '';
            }
            $i++;
        }
        return $this->respondWithData($socialdata);
    }

    /*Floor Plan*/
    public function floorPlan()
    {
        $floorData = FloorPlan::all();
        if ($floorData) {
            $i = 0;
            foreach ($floorData as $data) {
                if (!empty($data->floor_image)) {
                    $floorData[$i]['floor_image'] = config('app.MEDIA_URL') . $data->floor_image;
                } else {
                    $floorData[$i]['floor_image'] = '';
                }
                $i++;
            }

            return $this->respondWithData($floorData);
        } else {
            return $this->respondWithError('There are no Floor.', 400);
        }

    }

    /*Events*/
    public function events()
    {
        $events = Event::paginate(50);
        if ($events) {
            $i = 0;
            foreach ($events as $data) {
                if (!empty($data->event_icon)) {
                    $events[$i]['event_icon'] = config('app.MEDIA_URL') . $data->event_icon;
                } else {
                    $events[$i]['event_icon'] = '';
                }
                $i++;
            }

            return $this->respondWithData($events);
        } else {
            return $this->respondWithError('There are no Events.', 400);
        }
    }

    public function showEvents(Request $request)
    {
        $id = $request->id;
        $events = Event::where('id', '=', $id)->first();
        if ($events) {
            if (!empty($events->event_icon)) {
                $events['event_icon'] = config('app.MEDIA_URL') . $events->event_icon;
            } else {
                $events['event_icon'] = '';
            }
            return $this->respondWithData($events);
        } else {
            return $this->respondWithError('There are no Events.', 400);
        }
    }

    /*Announcement*/
    public function announcementList()
    {
        $announcement = Announcement::select('id', 'message_title', 'date_time', 'created_at')->orderBy('created_at',
            'desc')->paginate(50);
        if ($announcement) {
            return $this->respondWithData($announcement);
        } else {
            return $this->respondWithError('There are no Message.', 400);
        }
    }

    public function showAnnouncement(Request $request)
    {
        $id = $request->id;
        $announcement = Announcement::where('id', '=', $id)->first();
        if ($announcement) {
            return $this->respondWithData($announcement);
        } else {
            return $this->respondWithError('There are no Message.', 400);
        }
    }

    public function advertisementList()
    {
        $advertise = Advertise::orderBy(\DB::raw('RAND()'))->get();
        if ($advertise) {
            $i = 0;
            foreach ($advertise as $data) {
                if (!empty($data->advertisement_image)) {
                    $advertise[$i]['advertisement_image'] = config('app.MEDIA_URL') . $data->advertisement_image;
                } else {
                    $advertise[$i]['advertisement_image'] = '';
                }
                $i++;
            }

            return $this->respondWithData($advertise);
        } else {
            return $this->respondWithError('There are no Message.', 400);
        }
    }
    public function interstitialAdsList(){
        $advertise['image_data'] = Interstitial::select('display_time','advertisement_object','id','created_at','is_splash_page')
            ->orderBy(\DB::raw('RAND()'))
            ->where('is_splash_page','n')
            ->get();
        if ($advertise['image_data']) {
            $i = 0;
            foreach ($advertise['image_data'] as $data) {
                if (!empty($data->advertisement_object)) {
                    $data->advertisement_object = json_decode($data->advertisement_object);
                } else {
                    $data->advertisement_object = '';
                }
                $i++;
            }
            $advertise['base_url'] = config('app.MEDIA_URL');
            $siteInfoData = SiteInformation::where('site_slug','ads_page_counter')->first(); // Table : site_information
            $advertise['page_counter'] = $siteInfoData->site_description;
        }

        $advertise['splash_image_data'] = Interstitial::select('display_time','advertisement_object','id','created_at','is_splash_page')
            ->where('is_splash_page','y')
            ->first();
        if ($advertise['splash_image_data']) {
            $data = $advertise['splash_image_data'];
            if (!empty($data->advertisement_object)) {
                $data->advertisement_object = json_decode($data->advertisement_object)[0];
            } else {
                $data->advertisement_object = '';
            }
            $advertise['splash_image_data'] = $data;
            // $advertise['base_url'] = config('app.MEDIA_URL');
            // $siteInfoData = SiteInformation::where('site_slug','ads_page_counter')->first(); // Table : site_information
            // $advertise['page_counter'] = $siteInfoData->site_description;
            
        } 

        if(empty($advertise['image_data']) && empty($advertise['splash_image_data'])){
            return $this->respondWithError('There are no Message.', 400);
        }
        else{
            return $this->respondWithData($advertise);
        }
    }
    public function plashScreen()
    {
        $dbCollection = Plash::first();
        $dbCollection['logo'] = config('app.MEDIA_URL') . $dbCollection['logo'];
        $images = explode(',', $dbCollection['images']);

        foreach ($images as $img) {
            $photo[] = config('app.MEDIA_URL') . 'images/' . $img;
        }
        $dbCollection['photos'] = $photo;
        if($dbCollection)
        {
            return $this->respondWithData($dbCollection);
        }
        return $this->respondWithError('Something went wrong.', 400);
    }
}
