<x-receptionist-layout title="Usuarios | Colitas y Bigotes" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('receptionist.dashboard')],
    
    ['name' => 'Usuarios']
]">
    <x-slot name="actions">
        <x-wire-button href="{{ route('receptionist.users.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nuevo Usuario
        </x-wire-button>
    </x-slot>
    
    @livewire('receptionist.datatables.user-table')
</x-receptionist-layout>