<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Printers;
use App\Printer;
use Illuminate\Http\Request;
use FreeDSx\Snmp\SnmpClient;

class PrinterController extends Controller
{
    public function index()
    {
        $printers = Printers::orderBy('created_at', 'desc')->paginate(10);
        return view('panel.printers.index',['printers' => $printers]);   
        
    }

    public function levels()
    {
        $ips = ['10.1.1.38', '10.1.1.32','10.1.1.30','10.1.1.33','10.1.1.39','10.1.1.35',
        '10.1.1.37','10.1.1.36','10.1.1.31'];

        $printers = array();

        foreach($ips as $ip){
            $response = new Printer($ip);
            if($response->status == 200){    
                $printers[] = $response;
            }
            $response = "";
        }
        return view('panel.printers.levels',['printers' => $printers]);   
        
    }

    public function create()
    {
        return view('panel.printers.create');
    }

    public function store(Request $request)
    {
        $product = new Printers;
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->quantity    = $request->quantity;
        $product->price       = $request->price;
        $product->save();
        //return redirect()->route('panel.printers.index')->with('message', 'Product created successfully!');
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
