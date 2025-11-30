<x-admin-layout title="Roles | Healthify" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('admin.dashboard')],
    
    ['name' => 'Roles']
]">
    <x-slot name="actions">
        <x-wire-button href="{{ route('admin.roles.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nuevo rol
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.role-table')
</x-admin-layout>
