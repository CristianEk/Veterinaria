## Colitas y Bigotes — Sistema de Gestión Veterinaria
Este proyecto es una aplicación web desarrollada con Laravel, diseñada para administrar el funcionamiento de una clínica veterinaria.
Incluye módulos para:
-Gestión de usuarios según rol (Administrador, Veterinario, Recepcionista y Dueño).
-Gestión de citas veterinarias.
-Paneles personalizados según el rol del usuario.
-Administración de clientes/mascotas.
-Sistema de autenticación con múltiples roles.
-Dashboard independiente para cada tipo de usuario.

## Requisitos Previos
-PHP >= 8.1
-Composer
-MySQL / MariaDB
-Node.js & NPM
-Git

## Clonar el proyecto
git clone https://github.com/CristianEk/Veterinaria.git

## Composer install
Descargar el setup de composer desde su página oficial: 
https://getcomposer.org/download/

Dependencias requeridas:
-composer require Laravel/Jetstream
-composer requite wireui/wireui
-composer require spatie/laravel-permission
-composer require rappasoft/laravel-livewire-tables

## Configurar .env
El proyecto actual trabaja con MySQL
En caso de querer trabajar con otra editar esta parte

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=veterinaria_db
DB_USERNAME=root
DB_PASSWORD=

## Migraciones y seeders
El proyecto trae usuarios de prueba creados en la práctica
Los seeders tienen algunos registros de prueba limpios, en caso de
querer reiniciar la base de datos haremos esto

php artisan migrate:fresh --seed

## Usuario Admin de prueba

lacuentafeik05@gmail.com
-amongus123



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
