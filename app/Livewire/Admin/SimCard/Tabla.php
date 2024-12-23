<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\SimCard;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Illuminate\View\View;

final class Tabla extends PowerGridComponent
{
    public string $tableName = 'TablaSimCard';
    public bool $showFilters = true;

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

        ];
    }

    public function datasource(): Builder
    {
        return SimCard::query()->orderBy('id', 'desc')->with('linea', 'vehiculos');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('sim_card')
            ->add('linea_numero', fn($sim_card) => $sim_card->linea ? $sim_card->linea->numero : '#')
            ->add('operador')
            ->add('placa_asignada', fn($sim_card) => $sim_card->vehiculos ? $sim_card->vehiculos->placa : 'No asignado')
            ->add('created_at');
    }


    public function columns(): array
    {
        return [

            Column::add()
                ->title('SIM CARD')
                ->field('sim_card')
                ->searchable()
                ->sortable(),
            Column::add()
                ->title('NUMERO ASIGNADO')
                ->field('linea_numero')
                ->searchable(),

            Column::add()
                ->title('OPERADOR')
                ->field('operador')
                ->searchable(),

            Column::action('ACCIONES'),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actionsFromView($row): View
    {
        return view('components.actions-view', ['row' => $row, 'actions' => ['edit', 'show-sim-card-cambios', 'unasign']]);
    }


    public function openModalEdit(SimCard $sim_card)
    {
        $this->dispatch('open-modal-edit', sim_card: $sim_card);
    }
    public function openModalCambios(SimCard $sim_card)
    {

        $this->dispatch('open-modal-cambios', sim_card: $sim_card);
    }
    public function openModalUnAsign(SimCard $sim)
    {
        $this->dispatch('open-modal-unasign', sim: $sim);
    }
}
