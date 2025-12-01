{{-- actions.blade.php --}}
<div class="flex items-center space-x-2">
    {{-- Botón de edición --}}
    <x-wire-button href="{{ route('veterinarians.veterinarians.edit', $veterinarian)}}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>
</div>