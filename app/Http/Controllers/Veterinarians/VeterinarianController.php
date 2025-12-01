<?php

namespace App\Http\Controllers\Veterinarians;

use App\Http\Controllers\Controller;
use App\Models\Veterinarian;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class VeterinarianController extends Controller
{
    /**
     * Muestra la lista de recursos (la tabla Livewire).
     */
    public function index()
    {
        return view('veterinarians.veterinarians.index');
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
       // 1. Obtener los IDs de los usuarios que ya están asignados como veterinarios.
    $assignedUserIds = Veterinarian::pluck('user_id');

    // 2. Obtener los usuarios disponibles.
    $availableUsers = User::query()
        
        // *** CRITERIO CLAVE (USANDO SPATIE): Filtra por el rol 'Veterinario' ***
        // ¡Cuidado con la capitalización! Debe ser EXACTAMENTE 'Veterinario'.
        ->role('Veterinario') // <-- Spatie se encarga de usar la tabla intermedia
        
        // CRITERIO ADICIONAL: Excluye a los usuarios que ya tienen un perfil de Veterinarian
        ->whereNotIn('id', $assignedUserIds)
        
        // Seleccionar los datos para el dropdown: [id => name]
        ->pluck('name', 'id');

    return view('veterinarians.veterinarians.create', compact('availableUsers'));
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

        return redirect()->route('veterinarians.veterinarians.index')->with('success', 'Veterinario creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar el recurso especificado (Route Model Binding).
     */
    public function edit(Veterinarian $veterinarian)
    {
        return view('veterinarians.veterinarians.edit', compact('veterinarian'));
    }

    public function show(Veterinarian $veterinarian)
    {
        // Carga la relación de usuario para poder mostrar el nombre, email, etc.
        $veterinarian->load('user');

        return view('veterinarians.veterinarians.show', compact('veterinarian'));
    }

    /**
     * Actualiza el recurso especificado.
     */
    public function update(Request $request, Veterinarian $veterinarian)
    {
        // 1. VALIDACIÓN
        $request->validate([
            // La disponibilidad SIEMPRE debe ser enviada y debe ser un booleano (1 o 0)
            'available' => ['required', 'boolean'], 
            
            // Los campos de horario son OPCIONALES (nullable), pero si se envían, deben tener el formato correcto.
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);

        // 2. PREPARACIÓN DE DATOS
        // Usamos solo los valores que tienen datos. Esto es crucial.
        $dataToUpdate = [
            'available' => $request->boolean('available'), // La disponibilidad siempre se actualiza
        ];

        // Solo actualiza start_time si se envió en la petición
        if ($request->filled('start_time')) {
            $dataToUpdate['start_time'] = $request->start_time;
        }

        // Solo actualiza end_time si se envió en la petición
        if ($request->filled('end_time')) {
            $dataToUpdate['end_time'] = $request->end_time;
        }
        
        // 3. ACTUALIZACIÓN
        $veterinarian->update($dataToUpdate);

        return redirect()->route('veterinarians.veterinarians.index')->with('success', 'Veterinario actualizado exitosamente.');
    }

    /**
     * Elimina el recurso especificado.
     */
    public function destroy(Veterinarian $veterinarian)
    {
        $veterinarian->delete();

        return redirect()->route('veterinarians.veterinarians.index')->with('success', 'Veterinario eliminado exitosamente.');
    }
}