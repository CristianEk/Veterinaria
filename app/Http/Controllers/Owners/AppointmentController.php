<?php

namespace App\Http\Controllers\Owners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Room;
use App\Models\User;
use App\Models\Veterinarian;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Muestra la lista de recursos (donde estará la tabla Livewire).
     */
    public function index()
    {
        return view('owners.appointments.index');
    }

    /**
     * Muestra el formulario para crear una nueva cita.
     */
    public function create()
    {
        
    }

    /**
     * Guarda un nuevo recurso con validación de disponibilidad.
     */
    public function store(Request $request)
    {
        
    }
    /**
     * Actualiza el recurso especificado (especialmente para cambiar el estado).
     * @param int $id El ID de la cita
     */
    public function update(Request $request, Appointment $appointment)
    {
        
    }
    /**
         * Muestra el recurso especificado (Route Model Binding).
         */
        public function show(Appointment $appointment)
        {
            // Carga las relaciones necesarias para la vista de detalles
            $appointment->load(['pet', 'user', 'veterinarian.user', 'room']);
            
            return view('owners.appointments.show', compact('appointment'));
        }

        /**
         * Muestra el formulario para editar la cita especificada.
         */
        public function edit(Appointment $appointment)
        {
        
        }

        /**
         * Elimina la cita y libera los recursos.
         */
        public function destroy(Appointment $appointment)
        {
        }
            
}