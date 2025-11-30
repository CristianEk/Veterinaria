{{-- actions.blade.php --}}
<div class="flex items-center space-x-2">
    {{-- Botón de edición --}}
    <x-wire-button href="{{ route('admin.veterinarians.edit', $veterinarian)}}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    {{-- Formulario de eliminación --}}
    {{-- CORRECCIÓN: Usar $veterinarian para el Route Model Binding --}}
    <form action="{{ route('admin.veterinarians.destroy', $veterinarian)}}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')

        <x-wire-button type='submit' red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>