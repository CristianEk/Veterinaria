<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardRedirectController extends Controller
{
    /**
     * Redirige al usuario al panel correcto basado en su rol.
     * Esta función se llama al iniciar sesión o al acceder a la ruta /.
     */
    public function index()
    {
        // Si el usuario no está autenticado, redirige al login.
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 1. Redirección para el Administrador
        if ($user->hasRole('Administrador')) {
            // Utilizamos el nombre de ruta 'admin.dashboard'
            return redirect()->route('admin.dashboard');
        }

        // 2. Redirección para la Recepcionista
        if ($user->hasRole('Recepcionista')) {
            // Utilizamos el nombre de ruta 'receptionist.dashboard'
            return redirect()->route('receptionist.dashboard');
        }
        // 3. Redirección para el Veterinario
        if ($user->hasRole('Veterinario')) {
            // Utilizamos el nombre de ruta 'receptionist.dashboard'
            return redirect()->route('veterinarians.dashboard');
        }
        // 4. para usuarios/dueños
        if ($user->hasRole('Dueño')) {
            // Utilizamos el nombre de ruta 'receptionist.dashboard'
            return redirect()->route('owners.dashboard');
        }

    }
}