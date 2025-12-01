<?php

namespace App\Http\Controllers\Receptionist;

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
        return view('receptionist.appointments.index');
    }

    /**
     * Muestra el formulario para crear una nueva cita.
     */
    public function create()
    {
        // 1. Obtener datos para los selects
        $pets = Pet::pluck('pet_name', 'id');
        
        // Asumiendo que usas 'available' en Room, como en tu último ejemplo de modelo.
        $rooms = Room::where('available', true)->pluck('room_name', 'id'); 
        
        // Obtener veterinarios disponibles (estado 'available' en la tabla veterinarians)
        $veterinarians = Veterinarian::where('available', true)
            ->with('user')
            ->get()
            ->mapWithKeys(fn($v) => [$v->id => $v->user->name]);

        return view('receptionist.appointments.create', compact('pets', 'rooms', 'veterinarians'));
    }

    /**
     * Guarda un nuevo recurso con validación de disponibilidad.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'veterinarian_id' => 'required|exists:veterinarians,id',
            'room_id' => 'required|exists:rooms,id',
            'schedule_date' => 'required|date_format:Y-m-d',
            'schedule_time' => 'required|date_format:H:i',
            'description' => 'nullable|string|max:500',
        ]);
        
        // 1. Combinar fecha y hora en un objeto Carbon
        $schedule = Carbon::parse($validated['schedule_date'] . ' ' . $validated['schedule_time']);
        $pet = Pet::findOrFail($validated['pet_id']);
        
        // 2. Transacción: asegurar que la asignación y la actualización de disponibilidad sean atómicas
        DB::transaction(function () use ($validated, $schedule, $pet) {

            $veterinarian = Veterinarian::findOrFail($validated['veterinarian_id']);
            $room = Room::findOrFail($validated['room_id']);

            // --- A. VALIDACIÓN DE DISPONIBILIDAD (Doble chequeo) ---
            
            // a) Veterinario disponible? (Ya filtrado en create, pero vital aquí)
            if (!$veterinarian->available) {
                throw new \Exception('El veterinario no está disponible actualmente.');
            }

            // b) Horario del veterinario? (Asumiendo que la cita dura 1 hora y 'schedule' es la hora de inicio)
            // Convertimos el tiempo almacenado en TIME a Carbon, sin considerar la fecha actual.
            $startTime = Carbon::parse($veterinarian->start_time);
            $endTime = Carbon::parse($veterinarian->end_time);
            
            // Crea una copia de la fecha de la cita para comparar solo las horas
            $appointmentTime = Carbon::createFromTime($schedule->hour, $schedule->minute);

            if (!$appointmentTime->between($startTime, $endTime, true)) { // 'true' incluye los límites
                throw new \Exception('La hora de la cita está fuera del horario laboral del veterinario.');
            }
            
            // c) Consultorio disponible?
            if (!$room->available) {
                throw new \Exception('El consultorio no está disponible actualmente.');
            }
            
            // --- B. CREACIÓN Y ASIGNACIÓN ---
            
            Appointment::create([
                'pet_id' => $validated['pet_id'],
                'user_id' => $pet->user_id, // El dueño es el dueño de la mascota
                'veterinarian_id' => $veterinarian->id,
                'room_id' => $room->id,
                'schedule' => $schedule,
                'description' => $validated['description'],
                'status' => 0, // Pendiente
            ]);
            
            // --- C. ACTUALIZAR DISPONIBILIDAD ---

            // Marcar veterinario y consultorio como no disponibles
            $veterinarian->update(['available' => false]);
            $room->update(['available' => false]);

        }); // Fin de la transacción

        return redirect()->route('receptionist.appointments.index')->with('success', 'Cita agendada exitosamente.');
    }
    
    // ... (show, edit, destroy)

    /**
     * Actualiza el recurso especificado (especialmente para cambiar el estado).
     * @param int $id El ID de la cita
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            // La validación solo requiere el estado para esta lógica
            'status' => 'required|in:0,1,2', // 0:Pendiente, 1:En Curso, 2:Completado
        ]);
        
        $newStatus = (int) $validated['status'];
        $oldStatus = $appointment->status;

        // Si la cita NO ha terminado/cancelado (status < 2) y el NUEVO estado es 2 (Completado/Cancelado)
        $shouldReleaseResources = ($oldStatus < 2 && $newStatus === 2);
        
        DB::transaction(function () use ($appointment, $newStatus, $shouldReleaseResources) {
            
            // 1. Actualizar el estado de la cita
            $appointment->update(['status' => $newStatus]);

            // 2. Liberar recursos si la cita ha finalizado o ha sido marcada como completada/cancelada
            if ($shouldReleaseResources) {
                
                // a) Liberar Veterinario
                if ($appointment->veterinarian_id) {
                    $veterinarian = Veterinarian::find($appointment->veterinarian_id);
                    if ($veterinarian) {
                        $veterinarian->update(['available' => true]);
                    }
                }

                // b) Liberar Consultorio
                if ($appointment->room_id) {
                    $room = Room::find($appointment->room_id);
                    // Usamos la columna 'available' del modelo Room
                    if ($room) {
                        $room->update(['available' => true]);
                    }
                }
            }
        }); // Fin de la transacción

        return redirect()->route('receptionist.appointments.index')->with('success', 'Estado de la cita actualizado exitosamente.');
    }
    /**
         * Muestra el recurso especificado (Route Model Binding).
         */
        public function show(Appointment $appointment)
        {
            // Carga las relaciones necesarias para la vista de detalles
            $appointment->load(['pet', 'user', 'veterinarian.user', 'room']);
            
            return view('receptionist.appointments.show', compact('appointment'));
        }

        /**
         * Muestra el formulario para editar la cita especificada.
         */
        public function edit(Appointment $appointment)
        {
            // 1. Obtener recursos:
            
            // Todas las mascotas (no solo las disponibles, porque la cita ya tiene una mascota asignada)
            $pets = Pet::pluck('pet_name', 'id');
            
            // Obtener todas las salas (la asignada y las disponibles)
            $rooms = Room::pluck('room_name', 'id');

            // Obtener todos los veterinarios (el asignado y los disponibles)
            $veterinarians = Veterinarian::with('user')
                ->get()
                ->mapWithKeys(fn($v) => [$v->id => $v->user->name]);

            // 2. Pasar el estado de la cita para el select de estado
            $statuses = [
                0 => 'Pendiente',
                1 => 'En Curso',
                2 => 'Completado/Cancelado',
            ];

            return view('receptionist.appointments.edit', compact('appointment', 'pets', 'rooms', 'veterinarians', 'statuses'));
        }

        /**
         * Elimina la cita y libera los recursos.
         */
        public function destroy(Appointment $appointment)
        {
            // Solo liberar recursos si la cita no estaba marcada como Completada (status < 2)
            // Si la cita ya está en 2, los recursos ya deberían estar libres (por el update), 
            // pero es bueno asegurar el estado.
            $shouldReleaseResources = ($appointment->status < 2);
            
            DB::transaction(function () use ($appointment, $shouldReleaseResources) {
                
                // 1. Si la cita no ha terminado, liberamos los recursos que había ocupado
                if ($shouldReleaseResources) {
                    
                    // a) Liberar Veterinario
                    if ($appointment->veterinarian_id) {
                        $veterinarian = Veterinarian::find($appointment->veterinarian_id);
                        if ($veterinarian) {
                            $veterinarian->update(['available' => true]);
                        }
                    }

                    // b) Liberar Consultorio
                    if ($appointment->room_id) {
                        $room = Room::find($appointment->room_id);
                        if ($room) {
                            $room->update(['available' => true]);
                        }
                    }
                }
                
                // 2. Eliminar la cita
                $appointment->delete();
            });

            return redirect()->route('receptionist.appointments.index')->with('success', 'Cita eliminada y recursos liberados exitosamente.');
        }
}