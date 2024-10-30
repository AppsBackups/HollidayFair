<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planner extends Model
{
    protected $table='vendors_planner';

    protected $fillable=['vendor_id','user_id'];
}
