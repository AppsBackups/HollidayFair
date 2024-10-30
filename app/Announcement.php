<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table='message';

    protected $fillable=['user_id','message_title','message_description','date_time'];
}
