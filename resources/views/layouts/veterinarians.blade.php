{{--Toma los parametros del dashboard--}}
@props([
    'title' =>config('app.name', 'Laravel'),
    'breadcrumbs' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/f05834f7d2.js" crossorigin="anonymous"></script>
        <!-- Sweet Alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- WireUI -->
        <wireui:scripts/>

        <!-- Styles -->
        @livewireStyles


    </head>
    <body class="font-sans antialiased bg-gray-50">

        @include('layouts.includes.veterinarians.navigation')

        @include('layouts.includes.veterinarians.sidebar')
        <div class="p-4 sm:ml-64">


<!-- añadir margen superior -->
        <div class="mt-14 flex items-center justify-between w-full">
                {{--Incluir breadcrumb--}}
                @include('Layouts.includes.veterinarians.breadcrumb')

                {{--Slot opcional para acciones (botones)--}}

                {{ $actions ?? '' }}
            </div>

        {{$slot}}
        </div>
        @stack('modals')

        @livewireScripts

        @yield('content')

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

        {{-- Sweet Alert --}}
        @if (session('swal'))
            <script>
                Swal.fire(@json(session('swal')))
            </script>
        @endif

        {{--alerta para preguntar si esta seguro de editar o borrar las cosas--}}
        <script>
            //busca todos los elementos de una clase especifica
            forms = document.querySelectorAll('.delete-form');
            forms.forEach(form =>
                {
                    //activa el modo chismoso
                    form.addEventListener('submit', function(e)
                {
                    //evita que se envie
                    e.preventDefault();
                    Swal.fire({
                        title: "¿Estás seguro?",
                        imageUrl: "https://media1.tenor.com/m/NpxX43CMKcsAAAAd/omni-man-omni-man-are-you-sure.gif",
                        text: "No podrás revertir los cambios!",
                        //icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, ¡bórralo!",
                        cancelButtonText: "¡No lo borres!"
                        }).then((result) => {
                            if (result.isConfirmed){
                                form.submit();
                            }  
                        });
                })
                }
            )
        </script>

    </body>
</html>
