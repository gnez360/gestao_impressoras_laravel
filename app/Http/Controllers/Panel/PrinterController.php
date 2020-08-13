<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Printers;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    public function index()
    {
        $printers = Printers::orderBy('created_at', 'desc')->paginate(10);
        return view('panel.printers.index',['printers' => $printers]);
    }

    public function create()
    {
        return view('printers.create');
    }

    public function store(Request $request)
    {
        $product = new Printers;
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->quantity    = $request->quantity;
        $product->price       = $request->price;
        $product->save();
        return redirect()->route('printers.index')->with('message', 'Product created successfully!');
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
}
