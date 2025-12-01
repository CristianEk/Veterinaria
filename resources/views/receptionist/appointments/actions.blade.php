<div class="flex items-center space-x-2">
    {{-- Botón de edición --}}
    {{-- Redirige a la ruta de edición con el ID de la mascota --}}
    <x-wire-button href="{{ route('receptionist.appointments.edit', $appointment)}}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    {{-- Formulario de eliminación --}}
    {{-- Utiliza el Route Model Binding $pet para la ruta destroy y el método DELETE --}}
    <form action="{{ route('receptionist.appointments.destroy', $appointment)}}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')

        <x-wire-button type='submit' red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>