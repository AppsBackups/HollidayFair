<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interstitial extends Model
{
    protected $table='interstitial_ads';

    protected $fillable=['name','advertisement_object','display_time','is_splash_page'];
}
