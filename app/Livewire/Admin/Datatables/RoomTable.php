<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Room;

class RoomTable extends DataTableComponent
{
    protected $model = Room::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre de consultorio", "room_name")
                ->sortable(),
            Column::make("Estado", "available")
                ->sortable()
                ->format(function($value, $row, Column $column) {
                    return $value ? 'Disponible' : 'No disponible';
                }),
            Column::make("Acciones")
                ->label(
                    fn($row, Column $column) => view('admin.rooms.actions')->with(['room' => $row])
                )
        ];
    }
}
