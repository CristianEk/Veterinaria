<x-admin-layout title="Veterinarios | Healthify" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('admin.dashboard')],
    
    ['name' => 'Veterinarios ']
]">
    @livewire('admin.datatables.veterinarian-table')
</x-admin-layout>