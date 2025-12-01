<?php

use App\Http\Controllers\Receptionist\PetController;
use App\Http\Controllers\Receptionist\UserController;
use App\Http\Controllers\Receptionist\AppointmentController;

// La ruta raíz del prefijo /receptionist
// Usamos un controlador específico para mantener el código limpio.
Route::get('/', function(){
    return view('receptionist.dashboard');
})->name('dashboard');


// Gestion de usuarios (Mantenemos si es necesario)
Route::resource('users', UserController::class);

// Gestion de mascotas
Route::resource('pets', PetController::class);

// Gestion de citas
Route::resource('appointments', AppointmentController::class);