<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Printers;

class CakeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cake:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cake Command Executed Successfully!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $printers = Printers::all();    
        foreach ($printers as $printer)
        {
            $status = $this->PingaIP($printer->ipaddress);
            $print = Printers::find($printer->id);
            $print->status = $status;
            $print->save();

        }
    }

    public function PingaIP($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $health = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($health) {
            return 'ONLINE';
        } else {
            return 'OFFLINE';
        }        
    }
}
