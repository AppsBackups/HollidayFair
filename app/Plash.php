<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plash extends Model
{
    protected $table='plash';

    protected $fillable=['logo','images','title','description'];//
}
