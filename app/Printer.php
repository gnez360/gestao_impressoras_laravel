<?php
namespace App;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use FreeDSx\Snmp\SnmpClient;

use App\Exceptions;
use App\Printers;


class Printer
{
    public $name;
    public $model;
    public $serial_number;
    public $toner_cyan;
    public $toner_magenta;
    public $toner_yellow;
    public $toner_black;
    public $status;
    public $ipaddress;
    
    public function __construct($ipaddress)
    {
        $this->ipaddress = $ipaddress;

        $snmp = new SnmpClient([
            'host' => $ipaddress,
            'version' => 2,
            'community' => 'public',
        ]);

        try{
            //get name

            $this->status = "ONLINE";

            $name = $snmp->getValue('1.3.6.1.2.1.43.5.1.1.16.1');

            $this->name   = $name; 
              
            $model_temp =  $snmp->getValue(' 1.3.6.1.2.1.1.1.0');

            $model_array = explode(";",$model_temp);
                
            $this->model = $model_array[0];

            $sn_temp = explode(" ",$model_array[4]);

            $this->serial_number = $sn_temp[1];

            if($this->model == 'Samsung M4080FX' || $this->model == 'Samsung M4070FR' || $this->model == 'Samsung M5360RX') 
            { 

                $max_black = $snmp->getValue(' 1.3.6.1.2.1.43.11.1.1.8.1.1');

                $current_black = $snmp->getValue(' 1.3.6.1.2.1.43.11.1.1.9.1.1');

                $this->toner_black  = ($current_black / $max_black)*100;
                $this->toner_magenta = 0;
                $this->toner_cyan = 0;
                $this->toner_yellow =0;
            }
            else
            { 
                //toner 1
                $max_magenta = $snmp->getValue(' 1.3.6.1.2.1.43.11.1.1.8.1.2');

                $current_magenta = $snmp->getValue(' 1.3.6.1.2.1.43.11.1.1.9.1.2');

                $this->toner_magenta = ($current_magenta / $max_magenta)*100;

                //toner 2

                $max_cyan = $snmp->getValue(' 1.3.6.1.2.1.43.11.1.1.8.1.1');

                $current_cyan = $snmp->getValue(' 1.3.6.1.2.1.43.11.1.1.9.1.1');
                
                $this->toner_cyan = ($current_cyan / $max_cyan)*100;

                //toner 3

                $max_yellow = $snmp->getValue(' 1.3.6.1.2.1.43.11.1.1.8.1.3');

                $current_yellow = $snmp->getValue(' 1.3.6.1.2.1.43.11.1.1.9.1.3');

                $this->toner_yellow = ($current_yellow / $max_yellow)*100;

                //toner 4

                $max_black = $snmp->getValue(' 1.3.6.1.2.1.43.11.1.1.8.1.4');

                $current_black = $snmp->getValue(' 1.3.6.1.2.1.43.11.1.1.9.1.4');

                $this->toner_black  = ($current_black / $max_black)*100;

                
            }

        
        } catch(\FreeDSx\Snmp\Exception\ConnectionException $ex){
             $this->status = 404;
        }
    }

    public static function rules($is_update = false)
    {
        $rules = [
            'name' => ['string', 'required', 'max:191'],
            'model' => ['string', 'required', 'max:191'],
            'ipaddress' => ['string', 'required', 'max:191'],
            'location_id' => ['int', 'required', 'max:191'],          
            'serial_number' => ['string', 'required', 'min:14', 'max:15']
        ];

        return $rules;
    }
    
}