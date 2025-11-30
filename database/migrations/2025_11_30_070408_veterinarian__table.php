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
        Schema::create('veterinarians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained() // Apunta a la tabla 'users'
                  ->unique()      // Un usuario = Un perfil de veterinario
                  ->onDelete('cascade'); // Si se borra el usuario, se borra el perfil

            // 2. CAMPOS ESPECÍFICOS DEL PERFIL
            $table->boolean('available')->default(false); // 0 o 1
            $table->time('start_time')->nullable();; // Ejemplo: 09:00:00
            $table->time('end_time')->nullable();;   // Ejemplo: 17:00:00

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veterinarians');
    }
};