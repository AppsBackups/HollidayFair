<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table='vendors_visit';

    protected $fillable=['vendor_id','user_id'];
}
