<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Vínculos requeridos
            $table->foreignId('pet_id')->constrained()->onDelete('cascade'); // El paciente (Mascota)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // El dueño (Usuario)
            $table->foreignId('veterinarian_id')->nullable()->constrained()->onDelete('set null'); // El veterinario asignado
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('set null'); // El consultorio asignado

            // Datos de la cita
            $table->dateTime('schedule'); // Fecha y hora de la cita
            $table->text('description')->nullable(); // Descripción/Diagnóstico
            
            // Estado de la cita: 0=Pendiente, 1=En curso, 2=Completado/Cancelado
            // Tu Livewire Table sugiere 'status', usaremos un INT para los estados
            $table->unsignedTinyInteger('status')->default(0)->comment('0:Pendiente, 1:En Curso, 2:Completado'); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};