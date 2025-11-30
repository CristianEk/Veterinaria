<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de que el modelo User esté importado
use App\Models\Veterinarian;
use Illuminate\Support\Facades\Hash;

class VeterinarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear o encontrar un usuario de prueba para asociarlo al veterinario
        // Necesitas añadir 'id_number' y 'phone' (si son campos NOT NULL sin valor por defecto)
        $user = User::firstOrCreate(
            ['email' => 'vet@example.com'], // Condiciones de búsqueda
            [
                'name' => 'Dr. Healthify Vet',
                // *** AÑADE EL CAMPO 'id_number' AQUÍ ***
                'id_number' => 'VET12345678', 
                // *** Si 'phone' también es NOT NULL, añádelo: ***
                'phone' => '5512345678', 
                'password' => Hash::make('password'),
                'address' => 'calle565656'
            ]
        );
        
        // 2. Crear o encontrar el perfil de Veterinarian asociado
        Veterinarian::firstOrCreate(
            ['user_id' => $user->id],
            [
                'available' => true,
                'start_time' => '09:00',
                'end_time' => '17:00',
            ]
        );
    }
}