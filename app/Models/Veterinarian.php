<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Veterinarian extends Model
{
    // *** CAMBIO AQUI: user_id es suficiente. Eliminamos 'name'. ***
    protected $fillable = [
        'user_id',
        'available',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'available' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Accesor para obtener el nombre desde el modelo User cuando se pide $veterinarian->name.
     */
    public function getNameAttribute()
    {
        return $this->user->name ?? null;
    }
}