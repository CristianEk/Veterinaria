<x-admin-layout title="Veterinarios | Nuevo" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Veterinarios',
        'href' => route('admin.veterinarians.index')
    ],
    [
        'name' => 'Nuevo Veterinario'
    ],
]">

    <x-wire-card>
        {{-- El formulario apunta al método store del VeterinarianController --}}
        <form action="{{ route('admin.veterinarians.store')}}" method="POST">
            @csrf 

            <h2 class="text-xl font-bold mb-4 text-indigo-700">Asignar Nuevo Veterinario</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- 1. SELECCIÓN DE USUARIO (SOLO USUARIOS NO ASIGNADOS Y CON ROL VETERINARIO) --}}
                <div>
                    <label for="user_id" class="block font-medium text-sm text-gray-700">Seleccionar Usuario</label>
                    <select 
                        name="user_id" 
                        id="user_id" 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1"
                    >
                        <option value="">Elige un usuario para asignar</option>
                        {{-- La variable $availableUsers viene del controlador, en formato [id => name] --}}
                        @foreach($availableUsers as $id => $name)
                            <option 
                                value="{{ $id }}" 
                                {{ $id == old('user_id') ? 'selected' : '' }}
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
                
                {{-- 2. DISPONIBILIDAD INICIAL --}}
                <div>
                    <label for="available" class="block font-medium text-sm text-gray-700">Disponibilidad Inicial</label>
                    <select 
                        name="available" 
                        id="available" 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1"
                    >
                        <option value="1" {{ old('available', 1) == 1 ? 'selected' : '' }}>
                            Disponible (Por defecto)
                        </option>
                        <option value="0" {{ old('available', 1) == 0 ? 'selected' : '' }}>
                            No Disponible
                        </option>
                    </select>
                    @error('available') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- ESPACIO VACÍO PARA ALINEACIÓN o un campo extra --}}
                <div></div> 
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                
                {{-- 3. HORA DE INICIO --}}
                <x-wire-input 
                    label="Horario de entrada" 
                    name="start_time" 
                    type="time"
                    placeholder="HH:MM" 
                    value="{{ old('start_time')}}"
                />

                {{-- 4. HORA DE FIN --}}
                <x-wire-input 
                    label="Hora de salida" 
                    name="end_time" 
                    type="time"
                    placeholder="HH:MM" 
                    value="{{ old('end_time')}}"
                />
            </div>
            
            <div class="flex justify-end mt-8">
                <x-wire-button type="submit" blue>
                    <i class="fa-solid fa-user-plus mr-2"></i> Asignar Veterinario
                </x-wire-button>
            </div>    
        </form>
    </x-wire-card>
</x-admin-layout>