<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ubicacion;
use App\Models\Tienda;
use Illuminate\Support\Facades\Validator;

class TiendaController extends Controller
{

    public function show()
{
    $user = auth()->user();
    $tiendas = Tienda::where('id_usuario', $user->id)->get();
    return view('tienda.index', compact('tiendas'));
}

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
    ]);

    Tienda::create([
        'nombre' => $request->nombre,
        'tipo' => $request->tipo,
        'id_usuario' => auth()->id(),
    ]);

    return redirect()->route('tienda.index')->with('success', 'Tienda creada correctamente.');
}
public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
    ]);

    $tienda = Tienda::findOrFail($id);
    $tienda->update([
        'nombre' => $request->nombre,
        'tipo' => $request->tipo,
    ]);

    return redirect()->route('tienda.index')->with('success', 'Tienda actualizada correctamente.');
}

public function destroy($id)
{
    $tienda = Tienda::findOrFail($id);
    $tienda->delete();

    return redirect()->route('tienda.index')->with('success', 'Tienda eliminada correctamente.');
}

//functions for 


    public function createTienda(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    }
    public function getUbicacion()
    {
        $user = auth()->user();
        
        $tienda = Tienda::where('id_usuario', $user->id)->first();
        if (!$tienda) {
            return response()->json(['error' => 'Tienda not found'], 404);
        }

        $ubicacion = Ubicacion::find($tienda->id_ubicacion);
        if (!$ubicacion) {
            return response()->json(['error' => 'Ubicacion not found'], 404);
        }

        return response()->json($ubicacion);
    }
    public function createUbicacion(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'direccion' => 'required|string|max:255',
            'id_tienda' => 'required|exists:tiendas,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $tienda = Tienda::where('id_usuario', $user->id)->first();
        $ubicacion = Ubicacion::create([
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'direccion' => $request->direccion,
            'id_tienda' => $request->id_tienda,
        ]);

    }
    public function updateUbicacion(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $tienda = Tienda::where('id_usuario', $user->id)->first();
        if (!$tienda) {
            return response()->json(['error' => 'Tienda not found'], 404);
        }

        $ubicacion = Ubicacion::find($tienda->id_ubicacion);
        if (!$ubicacion) {
            return response()->json(['error' => 'Ubicacion not found'], 404);
        }

        $ubicacion->update($request->all());
        return response()->json($ubicacion);
    }

    
}
