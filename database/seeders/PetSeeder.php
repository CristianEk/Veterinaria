<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pet;   // Importa el modelo Pet
use App\Models\User; // Importa el modelo User (el dueño)

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Encontrar un usuario para asignarlo como dueño (Owner).
        // Si tienes un UserSeeder que crea un usuario 'Cliente' o 'Admin', úsalo.
        // Aquí asumiremos que el primer usuario existente es el dueño de prueba.
        $owner = User::first(); 
        
        // *Verificación de seguridad: No intentes crear mascotas si no hay dueños.*
        if (!$owner) {
            // Podrías lanzar un error o simplemente terminar si no hay usuarios
            echo "Advertencia: No se encontró ningún usuario para asignar mascotas.\n";
            return; 
        }

        // 2. Crear las mascotas de prueba
        $pets = [
            [
                'pet_name' => 'Firulais',
                'user_id' => $owner->id,
                'breed' => 'Labrador',
                'available' => true, // Atendido/Disponible
            ],
            [
                'pet_name' => 'Minino',
                'user_id' => $owner->id,
                'breed' => 'Siamés',
                'available' => false, // No Atendido
            ],
            [
                'pet_name' => 'Toby',
                'user_id' => $owner->id,
                'breed' => 'Poodle',
                'available' => true,
            ],
        ];

        // 3. Insertar los datos, usando firstOrCreate para evitar duplicados
        foreach ($pets as $petData) {
            Pet::firstOrCreate(
                // Criterio de búsqueda para evitar duplicados (ej: nombre y dueño)
                ['pet_name' => $petData['pet_name'], 'user_id' => $petData['user_id']],
                $petData // Datos a crear si no existe
            );
        }
    }
}