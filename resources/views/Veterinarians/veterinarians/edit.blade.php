<x-veterinarians-layout title="Veterinarios | Editar" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('veterinarians.dashboard')
    ],
    [
        'name' => 'Veterinarios',
        'href' => route('veterinarians.veterinarians.index')
    ],
    [
        'name' => 'Editar: ' . ($veterinarian->user->name ?? 'N/A')
    ],
]">

   <x-wire-card>
        <form action="{{ route('veterinarians.veterinarians.update', $veterinarian)}}" method="POST">
            @csrf 
            @method('PUT')

            <h2 class="text-xl font-bold mb-4">Editando: {{ $veterinarian->user->name ?? 'Usuario no asignado' }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- 1. DISPONIBILIDAD (Corregido: Usar el valor del modelo) --}}
                <div>
                    <label for="available" class="block font-medium text-sm text-gray-700">Disponibilidad</label>
                    <select name="available" id="available" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                        {{-- Usamos $veterinarian->available para el valor actual --}}
                        <option value="1" {{ old('available', $veterinarian->available) == 1 ? 'selected' : '' }}>
                            Disponible
                        </option>
                        <option value="0" {{ old('available', $veterinarian->available) == 0 ? 'selected' : '' }}>
                            No Disponible
                        </option>
                    </select>
                </div>
                
                {{-- 2. HORA DE INICIO --}}
                    <x-wire-input 
                        label="Horario de entrada" 
                        name="start_time" 
                        type="time"
                        placeholder="HH:MM" 
                        {{-- Solución: Aseguramos que el valor cargado sea HH:MM --}}
                        value="{{ old('start_time', substr($veterinarian->start_time, 0, 5)) }}"
                    />

                    {{-- 3. HORA DE FIN --}}
                    <x-wire-input 
                        label="Hora de salida" 
                        name="end_time" 
                        type="time"
                        placeholder="HH:MM" 
                        {{-- Solución: Aseguramos que el valor cargado sea HH:MM --}}
                        value="{{ old('end_time', substr($veterinarian->end_time, 0, 5)) }}"
                    />
            </div>
            
            <div class="flex justify-end mt-8">
                <x-wire-button type="submit" blue>
                    <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Horario
                </x-wire-button>
            </div>    
        </form>
    </x-wire-card>
</x-veterinarians-layout>