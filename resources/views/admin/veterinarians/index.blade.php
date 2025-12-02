<x-admin-layout title="Veterinarios | Colitas y Bigotes" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('admin.dashboard')],
    
    ['name' => 'Veterinarios ']
]">
    
        <x-slot name="actions">
        <x-wire-button href="{{ route('admin.veterinarians.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nuevo veterinario
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.veterinarian-table')
</x-admin-layout>