<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printers extends Model
{
    protected $fillable = ['serial_number','model','name','location_id','ipaddress'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'printers';

    public function locations()
    {
        return $this->belongsToMany('App\Locations');
    }
}
