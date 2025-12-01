<x-admin-layout title="Mascotas | Editar" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Mascotas',
        'href' => route('admin.pets.index')
    ],
    [
        'name' => 'Editar: ' . $pet->pet_name
    ],
]">

    <x-wire-card>
        {{-- El formulario apunta al método update del PetController y usa el método PUT --}}
        <form action="{{ route('admin.pets.update', $pet)}}" method="POST">
            @csrf 
            @method('PUT')

            {{-- 1. CAMPO NOMBRE DE LA MASCOTA --}}
            <x-wire-input 
                label="Nombre de la Mascota" 
                name="pet_name" 
                placeholder="Ej: Max" 
                {{-- Carga el valor actual o el valor del old input si hay error --}}
                value="{{ old('pet_name', $pet->pet_name)}}"
            />

            {{-- 2. CAMPO DUEÑO (Lista desplegable de usuarios) --}}
            <div class="mt-4">
            <label for="user_id" class="block font-medium text-sm text-gray-700">Seleccionar Dueño</label>
            <select name="user_id" id="user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                <option value="">Elige un usuario como dueño</option>
                
                {{-- Iteramos sobre el array de usuarios: [ID => Nombre] --}}
                @foreach($users as $id => $name)
                    <option 
                        value="{{ $id }}"
                        {{-- Verifica si el ID actual coincide con el valor guardado ($pet->user_id) --}}
                        {{-- o el valor antiguo (old('user_id')) --}}
                        {{ $id == old('user_id', $pet->user_id) ? 'selected' : '' }}
                    >
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
        </div>
            
            {{-- 3. CAMPO RAZA --}}
            <x-wire-input 
                label="Raza" 
                name="breed" 
                placeholder="Ej: Labrador, Criollo" 
                value="{{ old('breed', $pet->breed)}}"
            />

            {{-- 4. CAMPO ESTADO (Booleano: Atendido/No Atendido) --}}
                <label for="available" class="block font-medium text-sm text-gray-700">Estado</label>
                    <select 
                        name="available" 
                        id="available"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1"
                    >
                        <option value="">Selecciona un estado</option>
                        <option value="1" {{ old('available') == '1' ? 'selected' : '' }}>Disponible</option>
                        <option value="0" {{ old('available') == '0' ? 'selected' : '' }}>No disponible</option>
                    </select>

                    @error('available') 
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p> 
                    @enderror
            
            <div class="flex justify-end mt-6">
                <x-wire-button type="submit" blue>
                    <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Mascota
                </x-wire-button>
            </div>    
        </form>
    </x-wire-card>
</x-admin-layout>