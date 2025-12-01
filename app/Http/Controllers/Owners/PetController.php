<?php

namespace App\Http\Controllers\Owners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet; // Importa el modelo de la Mascota
use App\Models\User; // Importa el modelo del Usuario/Dueño

class PetController extends Controller
{
    /**
     * Muestra la lista de recursos (donde estará la tabla Livewire).
     */
    public function index()
    {
        // Esto solo carga la vista donde se renderiza la tabla Livewire.
        return view('owners.pets.index');
    }

    /**
     * Muestra el formulario para crear una nueva mascota.
     */
    public function create()
    {
        // 1. Obtener todos los usuarios para la lista desplegable de dueños.
        // Usamos pluck('name', 'id') para generar un array [id => name] para el <x-wire-select>.
        // Opcional: Filtra por rol si solo los 'clientes' pueden ser dueños.
        $users = User::pluck('name', 'id');
        
        return view('owners.pets.create', compact('users'));
    }

    /**
     * Guarda un nuevo recurso.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pet_name' => 'required|string|max:255',
            // Valida que el user_id exista en la tabla users
            'user_id' => 'required|exists:users,id', 
            'breed' => 'required|string|max:255',
            // 'available' es el estado (Atendido/No Atendido) y es opcional/booleano
            'available' => 'sometimes|boolean', 
        ]);

        Pet::create([
            'pet_name' => $request->pet_name,
            'user_id' => $request->user_id,
            'breed' => $request->breed,
            // Usa boolean() para asegurar el valor (por defecto será false si no se marca)
            'available' => $request->boolean('available'), 
        ]);

        return redirect()->route('owners.pets.index')->with('success', 'Mascota creada exitosamente.');
    }

    /**
     * Muestra el recurso especificado (Route Model Binding).
     */
    public function show(Pet $pet)
    {
        // Este método rara vez se usa en interfaces de ownersistrador modernas, 
        // pero podrías usarlo para mostrar una vista de detalles.
        return view('owners.pets.show', compact('pet'));
    }

    /**
     * Muestra el formulario para editar la mascota especificada.
     */
    public function edit(Pet $pet)
    {
        // Obtener la lista de usuarios para el desplegable del dueño.
        $users = User::pluck('name', 'id');
        
        return view('owners.pets.edit', compact('pet', 'users'));
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
            'pet_name' => $request->pet_name,
            'user_id' => $request->user_id,
            'breed' => $request->breed,
            'available' => $request->boolean('available'), 
        ]);

        return redirect()->route('owners.pets.index')->with('success', 'Mascota actualizada exitosamente.');
    }

    /**
     * Elimina la mascota especificada.
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()->route('owners.pets.index')->with('success', 'Mascota eliminada exitosamente.');
    }
}