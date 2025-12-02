<x-admin-layout tittle="Usuarios | Colitas y Bigotes" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Roles',
        'href' => route('admin.users.index')
    ],
    [
        'name' => 'Nuevo'
    ],
]">


    <x-wire-card>
        <form action="{{ route('admin.users.store')}}" method="POST">
            @csrf 
            <x-wire-input 
            label="Nombre" name="name" placeholder="Nombre del Usuario" value="{{ old('name')}}">
            </x-wire-input>
            <x-wire-input 
            label="Correo" name="email" placeholder="Correo electrónico" value="{{ old('email')}}">
            </x-wire-input>
            <x-wire-input 
            label="Contraseña" name="password" placeholder="Contraseña (almenos 8 digítos)" value="{{ old('password')}}">
            </x-wire-input>
            <x-wire-input 
            label="Telefóno" name="phone" placeholder="Telefóno celular" value="{{ old('phone')}}">
            </x-wire-input>
            <x-wire-input 
            label="Domicilio" name="address" placeholder="Domicilio" value="{{ old('address')}}">
            </x-wire-input>
            <x-wire-select
            label="Asignar rol" name="role" placeholder="Rol del usuario" :options="$role" autocomplete="off">
            </x-wire-select>

                <div class="flex justify-end mt-4">
                    <x-wire-button  type="submit" blue>
                        Guardar
                    </x-wire-button>
                </div>    
        </form>
    </x-wire-card>
</x-admin-layout>