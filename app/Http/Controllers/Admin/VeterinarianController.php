<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Veterinarian;
use Illuminate\Http\Request;
use App\Models\User;

class VeterinarianController extends Controller
{
    /**
     * Muestra la lista de recursos (la tabla Livewire).
     */
    public function index()
    {
        return view('admin.veterinarians.index');
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        //
    }

    /**
     * Guarda un nuevo recurso.
     */
   public function store(Request $request)
    {
        $request->validate([
            // *** CAMBIO: Quitamos la validación de 'name' ***
            'user_id' => 'required|exists:users,id|unique:veterinarians,user_id',
            'available' => ['required', 'boolean'], // Agregamos 'required' y definimos como 'boolean' para un checkbox
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // *** CAMBIO: Usamos solo los campos necesarios, quitamos $request->all() ***
        Veterinarian::create([
            'user_id' => $request->user_id,
            'available' => $request->boolean('available'), // Usar boolean() para asegurar el valor correcto
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('admin.veterinarians.index')->with('success', 'Veterinario creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar el recurso especificado (Route Model Binding).
     */
    public function edit(Veterinarian $veterinarian)
    {
        return view('admin.veterinarians.edit', compact('veterinarian'));
    }

    /**
     * Actualiza el recurso especificado.
     */
    public function update(Request $request, Veterinarian $veterinarian)
    {
        $request->validate([
            // *** CAMBIO: Quitamos la validación de 'name' ***
            'available' => ['required', 'boolean'], 
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            // El user_id no se actualiza, ya que es el vínculo principal
        ]);

        // *** CAMBIO: Actualizamos solo los campos necesarios. ***
        $veterinarian->update([
            'available' => $request->boolean('available'), 
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('admin.veterinarians.index')->with('success', 'Veterinario actualizado exitosamente.');
    }

    /**
     * Elimina el recurso especificado.
     */
    public function destroy(Veterinarian $veterinarian)
    {
        $veterinarian->delete();

        return redirect()->route('admin.veterinarians.index')->with('success', 'Veterinario eliminado exitosamente.');
    }
}