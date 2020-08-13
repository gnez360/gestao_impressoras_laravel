<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $fillable = ['name'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'printers';

    public function printers()
    {
        return $this->belongsToMany('App\Printers');
    }
}
