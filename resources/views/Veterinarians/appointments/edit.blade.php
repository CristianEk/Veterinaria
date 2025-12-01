<x-veterinarians-layout title="Citas | Editar" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('veterinarians.dashboard')],
    ['name' => 'Citas', 'href' => route('veterinarians.appointments.index')],
    ['name' => 'Editar Cita'],
]">

    <x-wire-card>
        <form action="{{ route('veterinarians.appointments.update', $appointment)}}" method="POST">
            @csrf 
            @method('PUT')

            <h2 class="text-xl font-bold mb-4 text-indigo-700">Editando Cita para {{ $appointment->pet->pet_name }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- 1. SELECCIÓN DE PACIENTE (Mascota) --}}
                <div>
                    <label for="pet_id" class="block font-medium text-sm text-gray-700">Seleccionar Paciente (Mascota)</label>
                    <select name="pet_id" id="pet_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                        <option value="">Elige la mascota</option>
                        @foreach($pets as $id => $name)
                            <option 
                                value="{{ $id }}" 
                                {{ $id == old('pet_id', $appointment->pet_id) ? 'selected' : '' }}
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('pet_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- 2. SELECCIÓN DE VETERINARIO --}}
                <div>
                    <label for="veterinarian_id" class="block font-medium text-sm text-gray-700">Veterinario Asignado</label>
                    <select name="veterinarian_id" id="veterinarian_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                        <option value="">Elige un veterinario</option>
                        @foreach($veterinarians as $id => $name)
                            <option 
                                value="{{ $id }}" 
                                {{ $id == old('veterinarian_id', $appointment->veterinarian_id) ? 'selected' : '' }}
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('veterinarian_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">

                @php
                    // Formatea la fecha y hora actuales para los inputs HTML
                    $schedule = $appointment->schedule;
                @endphp

                {{-- 3. FECHA DE LA CITA --}}
                <x-wire-input 
                    label="Fecha de la Cita" 
                    name="schedule_date" 
                    type="date"
                    value="{{ old('schedule_date', $schedule->format('Y-m-d')) }}"
                />

                {{-- 4. HORA DE LA CITA --}}
                <x-wire-input 
                    label="Hora de la Cita (Ej: 09:30)" 
                    name="schedule_time" 
                    type="time"
                    value="{{ old('schedule_time', $schedule->format('H:i')) }}"
                />
                
                {{-- 5. SELECCIÓN DE CONSULTORIO --}}
                <div>
                    <label for="room_id" class="block font-medium text-sm text-gray-700">Consultorio Asignado</label>
                    <select name="room_id" id="room_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                        <option value="">Elige un consultorio</option>
                        @foreach($rooms as $id => $name)
                            <option 
                                value="{{ $id }}" 
                                {{ $id == old('room_id', $appointment->room_id) ? 'selected' : '' }}
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

                {{-- 6. ESTADO DE LA CITA (Clave para liberar recursos) --}}
                <div>
                    <label for="status" class="block font-medium text-sm text-gray-700">Estado de la Cita</label>
                    <select name="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                        <option value="">Cambiar estado</option>
                        @foreach($statuses as $id => $name)
                            <option 
                                value="{{ $id }}" 
                                {{ $id == old('status', $appointment->status) ? 'selected' : '' }}
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('status') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>
            
            {{-- 7. DESCRIPCIÓN (Diagnóstico) --}}
            <div class="mt-4">
                <x-wire-textarea 
                    label="Notas / Diagnóstico (Opcional)"
                    name="description"
                    rows="3"
                >{{ old('description', $appointment->description) }}</x-wire-textarea>
            </div>

            <div class="flex justify-end mt-6">
                <x-wire-button type="submit" blue>
                    <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Cita
                </x-wire-button>
            </div>    
        </form>
    </x-wire-card>
</x-veterinarians-layout>