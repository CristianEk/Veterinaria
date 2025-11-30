<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// Importa el modelo User (asumiendo que está en App\Models\)
use App\Models\User; 

class Pet extends Model
{
    // Asegúrate de que user_id esté fillable
    protected $fillable = [
        'pet_name',
        'user_id',
        'breed',
        'available',
    ];
    
    // Define la relación para obtener el dueño de la mascota
    public function user(): BelongsTo
    {
        // Asume que la clave foránea en la tabla 'pets' es 'user_id'
        return $this->belongsTo(User::class);
    }

    // Opcional: Si quieres un nombre más descriptivo como 'owner' en lugar de 'user'
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}