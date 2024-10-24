<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{


    public function index()
    {
        return Cliente::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|min:3',
            'email' => 'required|email|unique:clientes,email',
            'telefono' => 'required|numeric',
        ]);

        $cliente = Cliente::create($validatedData);
        return response()->json($cliente, 201);
    }

    public function show(Request $request)
    {
        $cliente = Cliente::get();
        return response()->json($cliente);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|min:3',
            'email' => 'required|email|unique:clientes,email,' . $request->id,
            'telefono' => 'required|numeric',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($validatedData);
        return response()->json($cliente);
    }

    public function destroy(Request $request)
    {
        Cliente::destroy($request->id);
        return response()->json(['message' => 'Cliente eliminado'], 200);
    }


}
