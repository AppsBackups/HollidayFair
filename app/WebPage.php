<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebPage extends Model
{
    protected $table='web_page';

    protected $fillable=['title','slug','description'];
}
