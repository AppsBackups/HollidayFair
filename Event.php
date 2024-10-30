<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table='events';

    protected $fillable=['event_name','event_description','event_icon','event_address','latitude','longitude'];
}
