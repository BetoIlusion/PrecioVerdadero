<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\UsuarioProducto;
use App\Models\EstadoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    /**
     * Display a listing of the products and prepare modal data.
     */
    public function index(Request $request)
    {
        try {
            $productos = Producto::all();
            $estados = EstadoProducto::all();
            $producto = $request->has('id') ? Producto::find($request->id) : null;
            return view('entidades.productos.index', compact('productos', 'estados', 'producto'));
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar los productos.');
        }
    }

    /**
     * Store a newly created product or link an existing one in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'existing_product' => 'nullable|integer|exists:productos,id',
            'nombre' => 'required_if:existing_product,null|string|max:255',
            'marca' => 'nullable|string|max:255',
            'disponibilidad' => 'nullable|boolean',
            'id_unidad' => 'nullable|integer|exists:unidades,id',
            'id_sub_tipo' => 'nullable|integer|exists:sub_tipos,id',
            'precio' => 'required|numeric|min:0',
            'existe' => 'nullable|boolean',
            'id_estado' => 'required|integer|exists:estado_productos,id',
        ]);

        try {
            $productoId = null;

            if ($request->filled('existing_product')) {
                // Use existing product
                $productoId = $request->existing_product;
            } else {
                // Create new product
                $producto = Producto::create([
                    'nombre' => $validated['nombre'],
                    'marca' => $validated['marca'] ?? null,
                    'disponibilidad' => $validated['disponibilidad'] ?? true,
                    'id_unidad' => $validated['id_unidad'] ?? null,
                    'id_sub_tipo' => $validated['id_sub_tipo'] ?? null,
                ]);
                $productoId = $producto->id;
            }

            // Create usuario_productos record
            UsuarioProducto::create([
                'precio' => $validated['precio'],
                'existe' => $validated['existe'] ?? true,
                'id_usuario' => Auth::id(),
                'id_producto' => $productoId,
                'id_estado' => $validated['id_estado'],
            ]);

            return redirect()->route('entidades.productos.index')->with('success', 'Producto registrado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error creating product or usuario_productos: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al registrar el producto.');
        }
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'disponibilidad' => 'nullable|boolean',
            'id_unidad' => 'nullable|integer|exists:unidades,id',
            'id_sub_tipo' => 'nullable|integer|exists:sub_tipos,id',
        ]);

        try {
            $producto = Producto::findOrFail($id);
            $producto->update($validated);
            return redirect()->route('entidades.productos.index')->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el producto.');
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();
            return redirect()->route('entidades.productos.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar el producto.');
        }
    }
}