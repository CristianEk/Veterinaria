<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Define la creación de la tabla 'pets'
        Schema::create('pets', function (Blueprint $table) {
            $table->id();

            // 1. VINCULACIÓN CON EL DUEÑO (User)
            // Esto crea la columna 'user_id' y la define como clave foránea
            $table->foreignId('user_id')
                  ->constrained() // Apunta a la tabla 'users'
                  ->onDelete('cascade'); // Si se borra el dueño, se borran sus mascotas

            // 2. CAMPOS DE LA MASCOTA
            $table->string('pet_name'); // Nombre de la mascota
            $table->string('breed');    // Raza
            $table->boolean('available')->default(false); // Estado: Atendido / No Atendido
            
            // 3. TIMESTAMPS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
