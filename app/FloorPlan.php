<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FloorPlan extends Model
{
    protected $table ='floor_plan';

    protected $fillable=['floor_title','floor_image'];
}
