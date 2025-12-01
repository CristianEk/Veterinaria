<div class="flex items-center space-x-2">
    {{-- Botón de edición --}}
    {{-- Redirige a la ruta de edición con el ID de la mascota --}}
    <x-wire-button href="{{ route('veterinarians.appointments.edit', $appointment)}}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

        <x-wire-button type='submit' red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>