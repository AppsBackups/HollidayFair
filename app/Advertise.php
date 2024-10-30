<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
    protected $table='advertisement';

    protected $fillable=['advertisement_link','advertisement_image'];
}
