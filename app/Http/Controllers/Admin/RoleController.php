<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validador de que se cree bien
        $request->validate(['name' => 'required|unique:roles,name']);

        //si pasa la validacion
        Role::create(['name' => $request->name]);

        //variable de un solo uso para la alerta
        session()->flash('swal',
        [
            'icon'=>'success',
            'title'=>'Rol creado correctamente',
            'text'=>'El rol ha sido creado con éxito '
        ]);

        //redireccionar a la tabla principal
        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //Restringir editar los primeros 4 roles
        if($role->id <=4){
            //variable de un solo uso
            session()->flash('swal',
            [
                'icon'=>'error',
                'title'=>'ERROR',
                'text'=>'No se puede editar este rol'
            ]);

            return redirect()->route('admin.roles.index');
        }

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //validador de que se cree bien
        $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);

        //si el campo no cambió no actualices
        if($role ->name == $request->name){
            session()->flash('swal',
        [
            'icon'=>'info',
            'title'=>'Sin cambios',
            'text'=>'No se detectaron modificaciones'
        ]); 

        //redireccionar al mismo lugar
        return redirect()->route('admin.roles.edit', $role);
        }

        //si pasa la validacion
        $role->update(['name'=>$request->name]);

        //variable de un solo uso para la alerta
        session()->flash('swal',
        [
            'icon'=>'success',
            'title'=>'Rol actualizado correctamente',
            'text'=>'El rol ha sido actualizado con éxito '
        ]); 

        //redireccionar a la tabla principal
        return redirect()->route('admin.roles.index', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //Restringir eliminar los primeros 4 roles
        if($role->id <=4){
            //variable de un solo uso
            session()->flash('swal',
            [
                'icon'=>'error',
                'title'=>'ERROR',
                'text'=>'No se puede eliminar este rol'
            ]);

            return redirect()->route('admin.roles.index');
        }
        //borra el elemento
        $role->delete();

        //alerta
        session()->flash('swal',
        [
            'icon'=>'success',
            'title'=>'Rol eliminado correctamente',
            'text'=>'El rol ha sido eliminado con éxito '
        ]); 

        //redireccionar a la tabla principal
        return redirect()->route('admin.roles.index');

    }
}
