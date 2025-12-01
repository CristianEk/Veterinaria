<x-veterinarians-layout title="Consultas | Healthify" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('veterinarians.dashboard')],
    
    ['name' => 'Consultas']
]">
    
    {{-- Slot para el botón de "Nueva Mascota" --}}
    <x-slot name="actions">
        <x-wire-button href="{{ route('veterinarians.appointments.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nueva Consulta
        </x-wire-button>
    </x-slot>
    
    {{-- Aquí se renderiza el componente Livewire de la tabla --}}
    @livewire('veterinarians.datatables.appointment-table')
    
</x-veterinarians-layout>