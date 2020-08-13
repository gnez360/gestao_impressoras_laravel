<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    public function printers()
    {
        return $this->belongsToMany('App\Printers');
    }
}
