<x-admin-layout title="Consultas | Healthify" :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('admin.dashboard')],
    
    ['name' => 'Consultas']
]">
    
    {{-- Slot para el botón de "Nueva Mascota" --}}
    <x-slot name="actions">
        <x-wire-button href="{{ route('admin.appointments.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nueva Consulta
        </x-wire-button>
    </x-slot>
    
    {{-- Aquí se renderiza el componente Livewire de la tabla --}}
    @livewire('admin.datatables.appointment-table')
    
</x-admin-layout>