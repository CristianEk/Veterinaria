<x-veterinarians-layout title="Veterinarios | Colitas y Bigotes" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('veterinarians.dashboard')],
    
    ['name' => 'Veterinarios ']
]">
    
        <x-slot name="actions">
        <x-wire-button href="{{ route('veterinarians.veterinarians.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nuevo veterinario
        </x-wire-button>
    </x-slot>

    @livewire('veterinarians.datatables.veterinarian-table')
</x-veterinarians-layout>