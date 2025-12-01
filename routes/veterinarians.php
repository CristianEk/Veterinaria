<?php

use App\Http\Controllers\Veterinarians\VeterinarianController;
use App\Http\Controllers\Veterinarians\AppointmentController;

Route::get('/', function(){
    return view('veterinarians.dashboard');
})->name('dashboard');


//Gestion de veterinarios
Route::resource('veterinarians',VeterinarianController::class);
// Gestion de citas
Route::resource('appointments', AppointmentController::class);