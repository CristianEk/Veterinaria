<x-receptionist-layout title="Mascotas | Colitas y Bigotes" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('receptionist.dashboard')],
    
    ['name' => 'Mascotas']
]">
    
    {{-- Slot para el botón de "Nueva Mascota" --}}
    <x-slot name="actions">
        <x-wire-button href="{{ route('receptionist.pets.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nueva Mascota
        </x-wire-button>
    </x-slot>
    
    {{-- Aquí se renderiza el componente Livewire de la tabla --}}
    @livewire('receptionist.datatables.pet-table')
    
</x-receptionist-layout>