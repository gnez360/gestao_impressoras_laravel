<?php

namespace App\Http\Controllers\Panel;
use Ping;
use App\Http\Controllers\Controller;
use App\Printers;
use App\Printer;
use App\Locations;
use Illuminate\Http\Request;
use FreeDSx\Snmp\SnmpClient;

class PrinterController extends Controller
{
    public function index()
    {    
        $locations = Locations::all();

        $location_atual = Locations::where("id",1)->get();;

        $printers = Printers::where('location_id',1)->get();  
        
        return view('panel.printers.index',['printers' => $printers, 'locations' =>  $locations, 'locations_atual'=> $location_atual]);   
        
    }

    public function listPrinters(Request $request)
    {
        $location_atual = Locations::where("id",$request->id)->get();

        $locations = Locations::all();

        $printers = Printers::where('location_id',$request->id)->get();             
       
        return view('panel.printers.index',['printers' => $printers, 'locations' =>  $locations, 'locations_atual'=> $location_atual]);   
        
    }
    
    
public function info(){
    return view('panel.printers.info');
}
    public function levels()
    {
        $printers = Printers::all();  
            
       
        foreach($printers as $printer)
        {
            $printer_offline = new \StdClass;
       
            if($printer->status === "ONLINE")
            {
                $response = ""; 
                $response = new Printer($printer->ipaddress);  
                $printers_final[] = $response; 
               
            }        
            else
            {
                $printer_offline->name = $printer->name;
                $printer_offline->model = $printer->model;
                $printer_offline->serial_number = $printer->serial_number;
                $printer_offline->toner_cyan = 0;
                $printer_offline->toner_magenta = 0;
                $printer_offline->toner_yellow = 0;
                $printer_offline->toner_black = 0;
                $printer_offline->ipaddress = $printer->ipaddress;    
                $printer_offline->status = "OFFLINE";               
                $printers_final[] = $printer_offline;             
            }                      
        }        
      
        return view('panel.printers.levels',['printers' => $printers_final]);   
        
    }

    public function create()        
    {
       
        //$locations = Locations::all(['id', 'name'])->toArray();
        $locations = Locations::pluck('name','id');
        $selectedID = 1;
        return view('panel.printers.create',compact('selectedID', 'locations'));
    }

    public function store(Request $request)
    {
        $printer = new Printers;
        $printer->serial_number = $request->serial_number;
        $printer->model         = $request->model;
        $printer->name          = $request->name;
        $printer->location_id   = $request->location_id;
        $printer->type   = $request->type;
        $printer->ipaddress     = $request->ipaddress;
        $printer->save();
        return redirect()->route('panel.printers.index')->with('message', 'Product created successfully!');
   
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $product = Printers::findOrFail($id);
        return view('printers.edit',compact('printer'));
    }

    public function update(Request $request, $id)
    {
        $product = Printers::findOrFail($id);
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->quantity    = $request->quantity;
        $product->price       = $request->price;
        $product->save();
        return redirect()->route('printers.index')->with('message', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Printers::findOrFail($id);
        $product->delete();
        return redirect()->route('printers.index')->with('alert-success','Product hasbeen deleted!');
    }

    public function test($ipaddress)    {
     
        $snmp = new SnmpClient([
            'host' => $ipaddress,
            'version' => 2,
            'community' => 'public',
        ]);
        
            # Get a specific OID value as a string...
        echo $snmp->getValue('1.3.6.1.2.1.1.1.0').PHP_EOL;

        # Get a specific OID as an object...
        $oid = $snmp->getOid('1.3.6.1.2.1');
        var_dump($oid);

        echo sprintf("%s == %s", $oid->getOid(), (string) $oid->getValue()).PHP_EOL;

        # Get multiple OIDs and iterate through them as needed...
        $oids = $snmp->get('1.3.6.1.2.1.1.1', '1.3.6.1.2.1.1.3', '1.3.6.1.2.1.1.5');
        
        foreach($oids as $oid) {
            echo sprintf("%s == %s", $oid->getOid(), (string) $oid->getValue()).PHP_EOL;
        }

        # Using the SnmpClient, get the helper class for an SNMP walk...
        $walk = $snmp->walk();

        # Keep the walk going until there are no more OIDs left
        while($walk->hasOids()) {
            try {
                # Get the next OID in the walk
                $oid = $walk->next();
                echo sprintf("%s = %s", $oid->getOid(), $oid->getValue()).PHP_EOL;
            } catch (\Exception $e) {
                # If we had an issue, display it here (network timeout, etc)
                echo "Unable to retrieve OID. ".$e->getMessage().PHP_EOL;
            }
        }

        echo sprintf("Walked a total of %s OIDs.", $walk->count()).PHP_EOL; 
                
    }
}
