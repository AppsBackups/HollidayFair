<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';
    protected $fillable = [
        'name',
        'description',
        'logo',
        'booth_number',
        'booth_hall',
        'phone',
        'website',
        'booth_map',
        'featured',
        'category_id',
        'email'
    ];

    public function vendorPhotos()
    {
        return $this->hasMany('App\VendorPhoto', 'vendor_id', 'id');
    }

    public function vendorPlanner()
    {
        return $this->hasMany('App\Planner', 'vendor_id', 'id');
    }

    public function vendorVisit()
    {
        return $this->hasMany('App\Visitor', 'vendor_id', 'id');
    }
}
