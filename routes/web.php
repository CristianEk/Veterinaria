<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardRedirectController;

//Route::redirect('/','admin');
/*Route::get('/', function () {
    return view('welcome');
});*/

Route::redirect('/', '/dashboard-redirect');
Route::get('/dashboard-redirect', [DashboardRedirectController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
   Route::get('/dashboard', [DashboardRedirectController::class, 'index'])->name('dashboard');
});
// GRUPO DE ADMINISTRADOR
Route::middleware(['auth', 'role:Administrador'])->prefix('admin')->name('admin.')->group(function () {
    // Carga todas las rutas definidas en routes/admin.php
    require __DIR__.'/admin.php';
});

// GRUPO DE RECEPCIONISTA
Route::middleware(['auth', 'role:Recepcionista'])->prefix('receptionist')->name('receptionist.')->group(function () {
    // Carga todas las rutas definidas en routes/receptionist.php
    require __DIR__.'/receptionist.php';
});

// GRUPO DE Veterinario
Route::middleware(['auth', 'role:Veterinario'])->prefix('veterinarians')->name('veterinarians.')->group(function () {
    // Carga todas las rutas definidas en routes/receptionist.php
    require __DIR__.'/veterinarians.php';
});

// GRUPO DE dueños/usuarios
Route::middleware(['auth', 'role:Dueño'])->prefix('owners')->name('owners.')->group(function () {
    // Carga todas las rutas definidas en routes/receptionist.php
    require __DIR__.'/owners.php';
});