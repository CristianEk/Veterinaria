{{--editar roles--}}
<div class="flex items-center space-x-2">
    <x-wire-button href="{{ route('admin.rooms.edit', $room)}}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>

    </x-wire-button>

    {{--borrar roles--}}
    <form action="{{ route('admin.rooms.destroy',$room)}}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')

        <x-wire-button type='submit' red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>