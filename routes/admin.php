<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
//agregar UserController
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\VeterinarianController;
use App\Http\Controllers\Admin\PetController;

Route::get('/', function(){
    return view('admin.dashboard');
})->name('dashboard');

//Gestion de roles
Route::resource('roles',RoleController::class);
//Gestion de usuarios
Route::resource('users',UserController::class);
//Gestion de consultorios
Route::resource('rooms',RoomController::class);
//Gestion de veterinarios
Route::resource('veterinarians',VeterinarianController::class);
//Gestion de mascotas
Route::resource('pets',PetController::class);