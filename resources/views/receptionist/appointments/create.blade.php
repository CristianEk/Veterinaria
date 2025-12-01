<x-receptionist-layout title="Citas | Agendar" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('receptionist.dashboard')],
    ['name' => 'Citas', 'href' => route('receptionist.appointments.index')],
    ['name' => 'Agendar Cita'],
]">

    <x-wire-card>
        <form action="{{ route('receptionist.appointments.store')}}" method="POST">
            @csrf 

            <h2 class="text-xl font-bold mb-4 text-indigo-700">Nueva Cita Médica</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- 1. SELECCIÓN DE PACIENTE (Mascota) --}}
                <div>
                    <label for="pet_id" class="block font-medium text-sm text-gray-700">Seleccionar Paciente (Mascota)</label>
                    <select name="pet_id" id="pet_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                        <option value="">Elige la mascota</option>
                        @foreach($pets as $id => $name)
                            <option value="{{ $id }}" {{ $id == old('pet_id') ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('pet_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- 2. SELECCIÓN DE VETERINARIO (Solo disponibles) --}}
                <div>
                    <label for="veterinarian_id" class="block font-medium text-sm text-gray-700">Veterinario Asignado (Solo Disponibles)</label>
                    <select name="veterinarian_id" id="veterinarian_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                        <option value="">Elige un veterinario disponible</option>
                        @foreach($veterinarians as $id => $name)
                            <option value="{{ $id }}" {{ $id == old('veterinarian_id') ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('veterinarian_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">

                {{-- 3. FECHA DE LA CITA --}}
                <x-wire-input 
                    label="Fecha de la Cita" 
                    name="schedule_date" 
                    type="date"
                    value="{{ old('schedule_date', date('Y-m-d')) }}"
                />

                {{-- 4. HORA DE LA CITA --}}
                <x-wire-input 
                    label="Hora de la Cita (Ej: 09:30)" 
                    name="schedule_time" 
                    type="time"
                    value="{{ old('schedule_time') }}"
                />
                
                {{-- 5. SELECCIÓN DE CONSULTORIO (Solo disponibles) --}}
                <div>
                    <label for="room_id" class="block font-medium text-sm text-gray-700">Consultorio Asignado (Solo Disponibles)</label>
                    <select name="room_id" id="room_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                        <option value="">Elige un consultorio disponible</option>
                        @foreach($rooms as $id => $name)
                            <option value="{{ $id }}" {{ $id == old('room_id') ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>
            
            {{-- 6. DESCRIPCIÓN (Se mantiene x-wire-textarea) --}}
            <div class="mt-4">
                <x-wire-textarea 
                    label="Motivo de la Cita"
                    name="description"
                    rows="3"
                >{{ old('description') }}</x-wire-textarea>
            </div>

            <div class="flex justify-end mt-6">
                <x-wire-button type="submit" blue>
                    <i class="fa-solid fa-calendar-plus mr-2"></i> Agendar Cita
                </x-wire-button>
            </div>    
        </form>
    </x-wire-card>
</x-receptionist-layout>