<x-receptionist-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('receptionist.dashboard')
    ],
    [
        'name' => 'Panel de Recepcionista'
    ],
]">
    Bienvenido

    <img src="{{ asset('assets/background.png') }}" class="w-full max-h-[470px] object-contain mx-auto" alt="back">
    <h1>Servicio veterinario al cuidado de tus mascotas</h1>
    <h4>Contactanos</h4>
    <h5>
        <i class="fa-duotone fa-solid fa-phone"></i>
        +52 9991-234-448</h5>
    <h5>
        <i class="fa-solid fa-envelope"></i> 
        colitasybigotes@gmail.com</h5>
</x-receptionist-layout>