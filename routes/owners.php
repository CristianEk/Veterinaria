<?php

use App\Http\Controllers\Owners\AppointmentController;
use App\Http\Controllers\Owners\PetController;

Route::get('/', function(){
    return view('owners.dashboard');
})->name('dashboard');

// Gestion de mascotas
Route::resource('pets', PetController::class);
// Gestion de citas
Route::resource('appointments', AppointmentController::class);