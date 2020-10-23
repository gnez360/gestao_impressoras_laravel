<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $fillable = ['name'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'locations';  

    public function lists()
    {
        return $this;  
    }
}
