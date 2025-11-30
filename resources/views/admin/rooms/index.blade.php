<x-admin-layout title="Consultorios | Healthify" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('admin.dashboard')],
    
    ['name' => 'Consultorios']
]">
    <x-slot name="actions">
        <x-wire-button href="{{ route('admin.rooms.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nuevo Consultorio
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.room-table')
</x-admin-layout>
