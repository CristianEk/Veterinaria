<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Veterinarian;
use App\Models\Room;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Obtener recursos necesarios (asumiendo que ya existen)
        $pet = Pet::first();
        $veterinarian = Veterinarian::where('available', true)->first();
        $room = Room::where('available', true)->first();

        // 2. Verificación de existencia de recursos
        if (!$pet || !$veterinarian || !$room) {
            echo "Advertencia: No se pudo crear AppointmentSeeder. Asegúrate de que existan al menos un Pet, un Veterinarian disponible y una Room disponible.\n";
            return;
        }

        // 3. Crear citas de prueba

        // Cita 1: Pendiente (Asignada)
        Appointment::firstOrCreate(
            [
                'pet_id' => $pet->id, 
                'schedule' => Carbon::now()->addDays(2)->setHour(10)->setMinute(0) // Cita en dos días
            ],
            [
                'user_id' => $pet->user_id, // Tomamos el dueño de la mascota
                'veterinarian_id' => $veterinarian->id,
                'room_id' => $room->id,
                'description' => 'Chequeo anual y vacunas.',
                'status' => 0, // Pendiente
            ]
        );
        
        // Cita 2: Completada
        Appointment::firstOrCreate(
            [
                'pet_id' => $pet->id, 
                'schedule' => Carbon::now()->subDays(5)->setHour(14)->setMinute(0) // Cita pasada
            ],
            [
                'user_id' => $pet->user_id,
                'veterinarian_id' => $veterinarian->id,
                'room_id' => $room->id,
                'description' => 'Diagnóstico de tos, tratamiento antibiótico.',
                'status' => 2, // Completado
            ]
        );

        // 4. Actualizar estado de los recursos ocupados (si la cita no ha terminado)
        // La Cita 1 está pendiente (status 0), por lo que debemos marcar los recursos como NO disponibles
        $veterinarian->update(['available' => false]);
        $room->update(['available' => false]);
    }
}