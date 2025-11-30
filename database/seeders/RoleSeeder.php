<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles =[
            'Veterinario',
            'Dueño',
            'Recepcionista',
            'Administrador'
        ];
        //
        //Crear los roles
        foreach($roles as $role){
            Role::create([
                'name' => $role,
            ]);
    }
}
}
