<x-receptionist-layout title="Mascotas | Nuevo" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('receptionist.dashboard')
    ],
    [
        'name' => 'Mascotas',
        'href' => route('receptionist.pets.index')
    ],
    [
        'name' => 'Nueva Mascota'
    ],
]">
        <x-wire-card>
        {{-- El formulario apunta al método store del PetController --}}
        <form action="{{ route('receptionist.pets.store')}}" method="POST">
            @csrf 

            {{-- 1. CAMPO NOMBRE DE LA MASCOTA --}}
            <x-wire-input 
                label="Nombre de la Mascota" 
                name="pet_name" 
                placeholder="Ej: Max" 
                value="{{ old('pet_name')}}"
            />

            {{-- 2. CAMPO DUEÑO (Lista desplegable de usuarios) --}}
            {{-- La variable $users es un array [id => name] que viene del PetController --}}
                <label for="user_id" class="block font-medium text-sm text-gray-700">Seleccionar Dueño</label>
                <select name="user_id" id="user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                    <option value="">Elige un usuario como dueño</option>
                    {{-- $users debe ser un array [ID => Nombre] pasado desde PetController@create --}}
                    @foreach($users as $id => $name)
                        <option 
                            value="{{ $id }}"
                            {{ $id == old('user_id') ? 'selected' : '' }}
                        >
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror   
            {{-- 3. CAMPO RAZA --}}
            <x-wire-input 
                label="Raza" 
                name="breed" 
                placeholder="Ej: Labrador, Criollo" 
                value="{{ old('breed')}}"
            />

            {{-- 4. CAMPO ESTADO (Booleano: Atendido/No Atendido) --}}
                <label for="available" class="block font-medium text-sm text-gray-700">Estado</label>
                <select 
                    name="available" 
                    id="available"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1"
                >
                    <option value="">Selecciona un estado</option>
                    <option value="1" {{ old('available') == '1' ? 'selected' : '' }}>Atendido</option>
                    <option value="0" {{ old('available') == '0' ? 'selected' : '' }}>No atendido</option>
                </select>

    @error('available') 
        <p class="text-sm text-red-600 mt-2">{{ $message }}</p> 
    @enderror
            
            <div class="flex justify-end mt-6">
                <x-wire-button type="submit" blue>
                    <i class="fa-solid fa-save mr-2"></i> Guardar Mascota
                </x-wire-button>
            </div>    
        </form>
    </x-wire-card>

</x-receptionist-layout>