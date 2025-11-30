<x-admin-layout tittle="Consultorios | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Consultorios', 
        'href' => route('admin.rooms.index')
    ],
    [
        'name' => 'Editar'
    ],
]">

    <x-wire-card>
        <form action="{{ route('admin.rooms.update', $room)}}" method="POST">
            @csrf 
            @method('PUT')
            <x-wire-input label="Nombre" name="room_name" placeholder="Nombre del consultorio" value="{{ old('room_name', $room->room_name)}}">
            </x-wire-input>           
            <select name="available" id="available" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                <option value="1" {{ old('available', 1) == 1 ? 'selected' : '' }}>
                    Disponible
                </option>
                <option value="0" {{ old('available') == 0 ? 'selected' : '' }}>
                    No Disponible
                </option>
             </select>
            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" blue>
                    Actualizar
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>