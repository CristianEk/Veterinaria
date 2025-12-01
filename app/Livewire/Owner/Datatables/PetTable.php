<?php

namespace App\Livewire\Owner\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Builder; // Importar Builder

class PetTable extends DataTableComponent
{
    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }
    
    /**
     * Define la consulta base y carga la relación 'user' (el dueño)
     */
    public function builder(): Builder
    {
        // Carga anticipada de la relación 'user' para obtener el nombre
        return Pet::query()->with('user')
        ->where('pets.user_id', auth()->id());

    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre de la Mascota", "pet_name")
                ->sortable(),
                
            // *** CAMBIO CLAVE: Usar notación de puntos para acceder al nombre del dueño ***
            // La columna 'Dueño' ahora accede a la relación 'user' y luego a la columna 'name'
            Column::make("Dueño", "user.name") 
                ->sortable(),
                
            Column::make("Raza", "breed")
                ->sortable(),
            Column::make("Estado", "available")
                ->sortable()
                ->format(fn($value, $row, Column $column) => $value ? 'Atendido' : 'No atendido'),
            
            // Opcional: Columna de Acciones
            Column::make('Acciones')
                ->label(
                    fn($row, Column $column) => view('owners.pets.actions')->with(['pet' => $row])
                )->html(),
        ];
    }
}