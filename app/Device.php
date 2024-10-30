<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table='device';

    protected $fillable=['device_id','device_token','device_type'];
}
