<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'pet_id', 
        'user_id', 
        'veterinarian_id', 
        'room_id', 
        'schedule', 
        'description', 
        'status'
    ];
    
    // Indica que 'schedule' debe ser tratado como una instancia de Carbon
    protected $casts = [
        'schedule' => 'datetime',
    ];

    // Relaciones para el Livewire Table:

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class); // Paciente (Mascota)
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Dueño (Usuario)
    }

    public function veterinarian(): BelongsTo
    {
        // El veterinario asignado (apunta a la tabla 'veterinarians')
        return $this->belongsTo(Veterinarian::class); 
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class); // Consultorio
    }
}