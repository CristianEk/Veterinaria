<x-receptionist-layout tittle="Usuarios | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('receptionist.dashboard')
    ],
    [
        'name' => 'Usuarios',
        'href' => route('receptionist.users.index')
    ],
    [
        'name' => 'Editar'
    ],
]">

    <x-wire-card>
        <form action="{{ route('receptionist.users.update', $user)}}" method="POST">
            @csrf 
            @method('PUT')

            <x-wire-input 
            label="Nombre" name="name" placeholder="Nombre del Usuario" value="{{ old('name', $user->name)}}">
            </x-wire-input>
            <x-wire-input 
            label="Correo" name="email" placeholder="Correo electrónico" value="{{ old('email', $user->email)}}">
            </x-wire-input>
            <x-wire-input 
            label="Contraseña" name="password" type="password" placeholder="Contraseña (dejar vacío para no cambiar)" value="">
            </x-wire-input>
            <x-wire-input 
            label="Teléfono" name="phone" placeholder="Teléfono celular" value="{{ old('phone', $user->phone)}}">
            </x-wire-input>
            <x-wire-input 
            label="Domicilio" name="address" placeholder="Domicilio" value="{{ old('address', $user->address)}}">
            </x-wire-input>
            <x-wire-select
            label="Asignar rol" name="role" placeholder="Rol del usuario" :options="$roles" :selected="old('role', $user->getRoleNames()->first())" autocomplete="on">
            </x-wire-select>
            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" blue>
                    Actualizar
                </x-wire-button>
            </div>    
        </form>
    </x-wire-card>

</x-receptionist-layout>