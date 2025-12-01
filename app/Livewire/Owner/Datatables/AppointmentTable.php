<?php
namespace App\Livewire\Owner\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;

class AppointmentTable extends DataTableComponent
{
    protected $model = Appointment::class;

    // 1. Cargar las relaciones anidadas
    public function builder(): Builder
    {
        return Appointment::query()
            ->with(['pet', 'user', 'room', 'veterinarian.user'])
            ->where('appointments.user_id', auth()->id());
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("Paciente", "pet.pet_name")->sortable(),
            Column::make("Dueño", "user.name")->sortable(),
            
            // Acceso al nombre a través de la relación anidada
            Column::make("Veterinario asignado", "veterinarian.user.name")->sortable(), 
            
            // Asumiendo que 'room' tiene 'room_name'
            Column::make("Consultorio", "room.room_name")->sortable(), 
            
            // El 'schedule' ya es un objeto Carbon por el $casts en el modelo
            Column::make("Fecha de la cita", "schedule")
                ->sortable()
                ->format(fn($value) => $value ? $value->format('d/m/Y H:i A') : 'N/A'),
                
            Column::make("Descripción", "description")->sortable(),
            
            // 2. Corrección del Formato de Estado
            Column::make("Estado", "status")
                ->sortable()
                ->format(function($value, $row, Column $column) {
                    return match ($value) {
                        0 => '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>',
                        1 => '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">En Curso</span>',
                        2 => '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completado</span>',
                        default => 'Desconocido',
                    };
                })->html(),
        ];
    }
}