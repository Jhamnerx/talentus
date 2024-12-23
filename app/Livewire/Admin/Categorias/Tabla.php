<?php

namespace App\Livewire\Admin\Categorias;

use App\Models\Categoria;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Illuminate\View\View;

final class Tabla extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'TablaCategorias';
    public bool $showFilters = true;

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage(10)
                ->showRecordCount()
                ->pagination('components.custom-pagination'),

            PowerGrid::responsive()
                ->fixedColumns('nombre', 'descripcion', 'estado', 'actions'),
        ];
    }

    public function datasource(): Builder
    {
        return Categoria::query();
    }

    public function relationSearch(): array
    {
        return [];
    }
    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('nombre')
            ->add('descripcion')
            ->add('estado')
            ->add('estado_label', fn($entry) => $entry->estado ? 'Activa' : 'Desactivada');
    }
    public function columns(): array
    {
        return [
            Column::make('NOMBRE', 'nombre')
                ->searchable()
                ->sortable(),
            Column::make('DESCRIPCIÓN', 'descripcion'),
            Column::make('ESTADO', 'estado')->toggleable(true, 1, 0),
            Column::action('ACCIONES')

        ];
    }
    public function filters(): array
    {
        return [
            Filter::inputText('nombre')->placeholder('Nombre'),

            Filter::boolean('estado', 'estado')
                ->label('Activa', 'Desactivada'),
        ];
    }


    public function actionsFromView($row): View
    {
        return view('components.actions-view', ['row' => $row, 'actions' => ['edit', 'delete']]);
    }

    public function onUpdatedToggleable(string|int $id, string $field, string $value): void
    {
        Categoria::query()->find($id)->update([
            $field => e($value),
        ]);
    }

    public function openModalDelete(Categoria $categoria)
    {
        $this->dispatch('open-modal-delete', categoria: $categoria);
    }

    public function openModalEdit(Categoria $categoria)
    {
        $this->dispatch('open-modal-edit', categoria: $categoria);
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
