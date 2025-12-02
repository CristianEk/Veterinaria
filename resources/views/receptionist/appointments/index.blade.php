<x-receptionist-layout title="Consultas | Colitas y Bigotes" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('receptionist.dashboard')],
    
    ['name' => 'Consultas']
]">
    
    {{-- Slot para el botón de "Nueva Mascota" --}}
    <x-slot name="actions">
        <x-wire-button href="{{ route('receptionist.appointments.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nueva Consulta
        </x-wire-button>
    </x-slot>
    
    {{-- Aquí se renderiza el componente Livewire de la tabla --}}
    @livewire('receptionist.datatables.appointment-table')
    
</x-receptionist-layout>