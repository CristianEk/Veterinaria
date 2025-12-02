<x-admin-layout title="Mascotas | Colitas y Bigotes" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('admin.dashboard')],
    
    ['name' => 'Mascotas']
]">
    
    {{-- Slot para el botón de "Nueva Mascota" --}}
    <x-slot name="actions">
        <x-wire-button href="{{ route('admin.pets.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nueva Mascota
        </x-wire-button>
    </x-slot>
    
    {{-- Aquí se renderiza el componente Livewire de la tabla --}}
    @livewire('admin.datatables.pet-table')
    
</x-admin-layout>