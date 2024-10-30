<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendorPhoto extends Model
{
    //
    protected $table='vendors_photos';

    protected $fillable=['vendor_id','photo'];

}
