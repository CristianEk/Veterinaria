<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //LLamar a RoleSeeder
        $this -> call([
            RoleSeeder::class,
            UserSeeder::class,
            RoomSeeder::class,
            VeterinarianSeeder::class,
            PetSeeder::class,
            AppointmentSeeder::class,
        ]);
    }
}
