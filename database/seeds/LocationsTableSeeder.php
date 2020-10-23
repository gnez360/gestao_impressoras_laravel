<?php

use App\Locations;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    public function run()
    {
        Locations::create([
            'name' => "CAD"        
        ]);
        Locations::create([
            'name' => "CFP's"        
        ]);
        Locations::create([
            'name' => "CIDADE-C-INFANTIL"        
        ]);
        Locations::create([
            'name' => "Lar-Idosos"        
        ]);
    }
}
