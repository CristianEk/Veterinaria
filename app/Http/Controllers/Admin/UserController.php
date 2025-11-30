<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $role = Role::pluck('name', 'name');
        return view('admin.users.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|string|exists:roles,name',
        ]);

        // 2. GENERACIÓN DINÁMICA DE ID_NUMBER
        $newIdNumber = time() . Str::random(5); 

        // 3. CREAR EL USUARIO con el ID generado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'id_number' => $newIdNumber,
            
            'email_verified_at' => Carbon::now(),
        ]);
        
        // 4. ASIGNAR EL ROL
        $user->assignRole($request->role);

            
            session()->flash('swal',
            [
                'icon'=>'success',
                'title'=>'Usuario creado correctamente',
                'text'=>'El usuario ha sido creado con éxito '
            ]);

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        //Restringir editar los primeros 4 roles
        if($user->id <=1){
            //variable de un solo uso
            session()->flash('swal',
            [
                'icon'=>'error',
                'title'=>'ERROR',
                'text'=>'No se puede editar este usuario'
            ]);

            return redirect()->route('admin.users.index');
        }
        $roles = Role::pluck('name', 'name')->toArray();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, User $user) // Usamos Route Model Binding para User
    {
        // 🚨 Restringir modificación del Admin principal
        if ($user->id === 1) {
             session()->flash('swal',
            [
                'icon' => 'error',
                'title' => 'ERROR',
                'text' => 'No se puede modificar al usuario Administrador principal'
            ]);
            return redirect()->route('admin.users.index');
        }

        // 1. VALIDACIÓN COMPLETA
        $request->validate([
            'name' => 'required|string|max:255',
            // Usamos Rule::unique para ignorar el email del usuario actual al validar
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // La contraseña es opcional al editar, solo si se provee se valida.
            'password' => 'nullable|string|min:8', 
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255', // Asumimos que no es único
            'role' => 'required|string|exists:roles,name', 
        ]);

        // 2. PREPARAR DATOS PARA ACTUALIZAR
        $data = $request->only(['name', 'email', 'phone', 'address']);

        // 3. MANEJAR LA CONTRASEÑA SOLO SI SE PROVEE
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // 4. VERIFICAR SI HAY CAMBIOS
        $oldData = $user->only(['name', 'email', 'phone', 'address']);
        $hasChanges = false;
        
        foreach ($data as $key => $value) {
            // Verificar si el valor actual en DB es diferente al nuevo valor
            if ($oldData[$key] !== $value) {
                $hasChanges = true;
                break;
            }
        }
        
        // También verificar si el rol ha cambiado
        $currentRole = $user->roles->pluck('name')->first();
        if (!$hasChanges && $currentRole !== $request->role) {
            $hasChanges = true;
        }

        if (!$hasChanges) {
            session()->flash('swal',
            [
                'icon' => 'info',
                'title' => 'Sin cambios',
                'text' => 'No se detectaron modificaciones'
            ]); 
            return redirect()->route('admin.users.edit', $user);
        }

        // 5. ACTUALIZAR DATOS Y ROL
        $user->update($data);
        
        // Sincronizar (reemplazar) el rol del usuario con el nuevo rol
        $user->syncRoles([$request->role]); 

        // 6. ALERTA Y REDIRECCIÓN
        session()->flash('swal',
        [
            'icon' => 'success',
            'title' => 'Usuario actualizado correctamente',
            'text' => 'El usuario ha sido actualizado con éxito '
        ]); 

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) // Usamos Route Model Binding para User
    {
        // Restringir eliminar el primer usuario (Admin principal)
        if ($user->id === 1) {
            session()->flash('swal',
            [
                'icon' => 'error',
                'title' => 'ERROR',
                'text' => 'No se puede eliminar al usuario Administrador principal'
            ]);

            return redirect()->route('admin.users.index');
        }
        
        // Eliminar el elemento
        $user->delete();

        // Alerta
        session()->flash('swal',
        [
            'icon' => 'success',
            'title' => 'Usuario eliminado correctamente',
            'text' => 'El usuario ha sido eliminado con éxito '
        ]); 

        // Redireccionar a la tabla principal
        return redirect()->route('admin.users.index');
    }

}
