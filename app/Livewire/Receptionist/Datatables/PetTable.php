<?php

namespace App\Livewire\Receptionist\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Builder;

class PetTable extends DataTableComponent
{
    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    /**
     * Consulta base + carga relación user
     */
    public function builder(): Builder
    {
        return Pet::query()->with('user');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Nombre de Mascota", "pet_name")
                ->sortable(),

            // Muestra el nombre del dueño
            Column::make("Dueño", "user.name")
                ->sortable(),

            Column::make("Raza", "breed")
                ->sortable(),

            Column::make("Estado", "available")
                ->sortable()
                ->format(fn($value) => $value ? 'Atendido' : 'No Atendido'),

            Column::make('Acciones')
                ->label(
                    fn($row) => view('receptionist.pets.actions', ['pet' => $row])
                )->html(),
        ];
    }
}
