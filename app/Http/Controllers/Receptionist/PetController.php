<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet; 
use App\Models\User;

class PetController extends Controller
{
    /**
     * Muestra la lista de mascotas (tabla Livewire o blade normal).
     */
    public function index()
    {
        return view('receptionist.pets.index');
    }

    /**
     * Formulario para crear una nueva mascota.
     */
    public function create()
    {
        // Obtiene lista: [id => name] para el select de dueño
        $users = User::pluck('name', 'id');

        return view('receptionist.pets.create', compact('users'));
    }

    /**
     * Guarda una nueva mascota en la BD.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pet_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'breed'   => 'required|string|max:255',
            'available' => 'sometimes|boolean',
        ]);

        Pet::create([
            'pet_name'  => $request->pet_name,
            'user_id'   => $request->user_id,
            'breed'     => $request->breed,
            'available' => $request->boolean('available'),
        ]);

        return redirect()->route('receptionist.pets.index')
                         ->with('success', 'Mascota creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar una mascota.
     */
    public function edit(Pet $pet)
    {
        $users = User::pluck('name', 'id');

        return view('receptionist.pets.edit', compact('pet', 'users'));
    }

    /**
     * Actualiza la mascota especificada.
     */
    public function update(Request $request, Pet $pet)
    {
        $request->validate([
            'pet_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'breed' => 'required|string|max:255',
            'available' => 'sometimes|boolean',
        ]);

        $pet->update([
            'pet_name'  => $request->pet_name,
            'user_id'   => $request->user_id,
            'breed'     => $request->breed,
            'available' => $request->boolean('available'),
        ]);

        return redirect()->route('receptionist.pets.index')
                         ->with('success', 'Mascota actualizada exitosamente.');
    }

    /**
     * Elimina la mascota.
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()->route('receptionist.pets.index')
                         ->with('success', 'Mascota eliminada exitosamente.');
    }
}
