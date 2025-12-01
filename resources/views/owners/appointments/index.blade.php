<x-owners-layout title="Consultas | Healthify" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('owners.dashboard')],
    
    ['name' => 'Consultas']
]">
    {{-- Aquí se renderiza el componente Livewire de la tabla --}}
    @livewire('owner.datatables.appointment-table')
    
</x-owners-layout>