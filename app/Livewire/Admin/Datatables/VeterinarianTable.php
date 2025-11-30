<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Veterinarian;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class VeterinarianTable extends DataTableComponent
{
    protected $model = Veterinarian::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setEmptyMessage('No se encontraron veterinarios.');
    }

    /**
     * Define la consulta base y carga la relación 'user'
     */
    public function builder(): Builder
    {
        return Veterinarian::query()
            ->with('user'); 
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),

            Column::make("Nombre", "user.name")
            ->sortable(),

            // Columna de Disponibilidad con formato de texto
            Column::make("Disponibilidad", "available")
                ->sortable()
                ->format(function($value, $row, Column $column) {
                    return $value ? 'Disponible' : 'No disponible';
                }),

            Column::make("Horario de entrada", "start_time")
                ->sortable(),

            Column::make("Hora de salida", "end_time")
                ->sortable(),
                
            // Columna de Acciones que renderiza los botones
            Column::make("Acciones")
                ->label(
                    // Llama a la vista de Blade para renderizar los botones
                    fn($row, Column $column) => view('admin.veterinarians.actions')->with(['veterinarian' => $row])
                )
                ->html(),
        ];
    }
}