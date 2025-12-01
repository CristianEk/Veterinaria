<div class="flex items-center space-x-2">

    {{-- Formulario de eliminación --}}
    {{-- Utiliza el Route Model Binding $pet para la ruta destroy y el método DELETE --}}
    <form action="{{ route('owners.pets.destroy', $pet)}}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')

        <x-wire-button type='submit' red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>