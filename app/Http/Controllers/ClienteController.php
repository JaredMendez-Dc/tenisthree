<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Country;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
   
    public function index()
    {
        $countries = Country::all();
        $clientes = Cliente::with('country:id,country','tenis:model')->get();
        return Inertia::render('Clientes/Index',[
            'clientes' => $clientes,
            'countries' => $countries
        ]);
    }
  
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:80',
            'last_name' => 'required|max:80',
            'country_id' => 'required|numeric'
        ]);
        
        $cliente = new Cliente($request->input());
        $cliente->save();
        return redirect('clientes');
        
    }


    public function show(Cliente $cliente)
    {
        //
    }


    public function edit(Cliente $cliente)
    {

    }


    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'name' => 'required|max:80',
            'last_name' => 'required|max:80',
            'country_id' => 'required|numeric'
        ]);

        $cliente->update($request->input());
        return redirect('clientes');
    }


    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect('clientes');
    }
}
