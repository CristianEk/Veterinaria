<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.rooms.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_name' => 'required|string|max:255|unique:rooms,room_name',
            'available' => 'required|boolean',
        ]);

        Room::create([
            'room_name' => $request->room_name,
            'available' => $request->available, 
        ]);

        session()->flash('swal',
        [
            'icon'=>'success',
            'title'=>'Consultorio creado correctamente',
            'text'=>'El consultorio ha sido creado con éxito '
        ]);

        return redirect()->route('admin.rooms.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
         return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
        $request->validate([
            'room_name' => 'required|string|max:255|unique:rooms,room_name,' . $room->id,
            'available' => 'required|boolean',
        ]);
        
        // Actualizar el consultorio
        $room->update([
            'room_name' => $request->room_name,
            'available' => $request->available,
        ]);

        // Alerta
        session()->flash('swal',
        [
            'icon'=>'success',
            'title'=>'Consultorio actualizado',
            'text'=>'El consultorio ha sido actualizado con éxito '
        ]);

        // Redireccionar a la tabla principal
        return redirect()->route('admin.rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
        $room->delete();

        // Alerta
        session()->flash('swal',
        [
            'icon'=>'success',
            'title'=>'Consultorio eliminado',
            'text'=>'El consultorio ha sido eliminado con éxito '
        ]);

        // Redireccionar a la tabla principal
        return redirect()->route('admin.rooms.index');
    }
}
