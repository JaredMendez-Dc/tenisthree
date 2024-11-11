<?php

namespace App\Http\Controllers;

use App\Models\Teni;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class TeniController extends Controller
{
    public function index()
    {
        return Inertia::render('Tenis/Index', [
            'tenis' => Teni::paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Tenis/Create', [
            'clientes' => Cliente::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required|max:13',
            'marca' => 'required|max:20',
            'color' => 'required|max:20',
            'precio' => 'required|numeric',
            'talla' => 'required|max:20',
            'material' => 'required|max:40',
            'categoria' => 'required|max:40',
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'clientes' => 'array|exists:clientes,id', // Valida que los IDs existan en la tabla `clientes`
        ]);

        $data = $request->except('image', 'clientes');

        // Manejo de archivo de imagen
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('imagenes_tenis'), $imageName);
            $data['image'] = 'imagenes_tenis/' . $imageName;
        }

        // Crear el registro de Teni
        $teni = Teni::create($data);

        // Sincronizar clientes seleccionados
        if ($request->has('clientes')) {
            $teni->clientes()->sync($request->clientes);
        }

        return redirect()->route('tenis.create')->with('success', 'Tenis creado');
    }

    public function show(Teni $teni)
    {
        return Inertia::render('Tenis/Show', [
            'teni' => $teni,
            'clientes' => $teni->clientes,
            'clientesOfTeni' => $teni->clientes->pluck('id') // Devuelve solo los IDs de los clientes relacionados

        ]);
    }

    public function edit(Teni $teni)
    {
        return Inertia::render('Tenis/Edit', [
            'clientes' => Cliente::all(),
            'teni' => $teni,
            'clientesOfTeni' => $teni->clientes, // Devuelve los objetos completos de clientes relacionados
        ]);
    }    

    public function updateTeni(Request $request)
    {
        $request->validate([
            'model' => 'sometimes|required|max:13',
            'marca' => 'sometimes|required|max:20',
            'color' => 'sometimes|required|max:20',
            'precio' => 'sometimes|required|numeric',
            'talla' => 'sometimes|required|max:20',
            'material' => 'sometimes|required|max:40',
            'categoria' => 'sometimes|required|max:40',
            'id' => 'required|numeric',
            'clientes' => 'array|exists:clientes,id', // Valida que los IDs existan en la tabla `clientes`
        ]);

        $teni = Teni::findOrFail($request->id);
        $teni->update($request->except('image', 'clientes')); // Actualiza todos los campos excepto la imagen y los clientes

        // Manejo de archivo de imagen
        if ($request->hasFile('image')) {
            if ($teni->image && file_exists(public_path($teni->image))) {
                unlink(public_path($teni->image)); // Elimina la imagen anterior
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('imagenes_tenis'), $imageName);
            $teni->update(['image' => 'imagenes_tenis/' . $imageName]);
        }

        // Sincronizar clientes seleccionados
        if ($request->has('clientes')) {
            $teni->clientes()->sync($request->clientes);
        }

        return redirect()->route('tenis.index')->with('success', 'Tenis actualizado');
    }

    public function destroy(Teni $teni)
    {
        // Eliminar la imagen si existe
        if ($teni->image && file_exists(public_path($teni->image))) {
            unlink(public_path($teni->image));
        }

        $teni->delete();
        return redirect()->route('tenis.index')->with('success', 'Tenis eliminado');
    }
}
