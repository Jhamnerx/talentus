<?php

namespace App\Livewire\Admin\Lineas;

use App\Models\Lineas;
use Illuminate\View\View;
use App\Enums\OperadorEnum;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class Tabla extends PowerGridComponent
{
    public string $tableName = 'TablaLineas';
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
                ->showPerPage(20)
                ->showRecordCount()
                ->pagination('components.custom-pagination'),

        ];
    }

    public function datasource(): Builder
    {
        return Lineas::query()->with('sim_card', 'sim_card.vehiculos.cliente', 'old_sim_cards');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('numero')
            ->add('operador')
            ->add('operador_name', fn($linea) => e($linea->operador))
            ->add('sim_card', fn($linea) => $linea->sim_card ? $linea->sim_card->sim_card : 'SIN ASIGNAR')
            ->add('empresa_razon_social', fn($linea) => $linea->sim_card ? ($linea->sim_card->vehiculos ? $linea->sim_card->vehiculos->cliente->razon_social : 'SIN ASIGNAR') : '')
            ->add('placa', fn($linea) => $linea->sim_card ? ($linea->sim_card->vehiculos ? $linea->sim_card->vehiculos->placa : 'SIN ASIGNAR') : '')
            ->add('estado_html', fn($linea) => $linea->baja ? '<div class="font-medium text-red-600">BAJA DEFINITIVA</div>' : ($linea->estado->name == 'SUSPENDIDA' ? '<div class="font-medium text-yellow-600">SUSPENDIDA <br> ' . $linea->fecha_suspencion->format('d-m-Y') . ' - ' . $linea->date_to_suspend->format('d-m-Y') . ' </div>' : '<div class="font-medium text-green-600">' . $linea->estado->name . '</div>'))
            ->add('sim_old', fn($linea) => view('admin.almacen.lineas.sim_old', compact('linea')))
            ->add('created_at');
    }

    public function columns(): array
    {
        return [

            Column::add()
                ->title('NUMERO')
                ->field('numero')
                ->searchable(),

            Column::add()
                ->title('OPERADOR')
                ->field('operador')
                ->searchable(),

            Column::add()
                ->title('SIM CARD')
                ->field('sim_card')
                ->searchable(),

            Column::add()
                ->title('EMPRESA ACTUAL')
                ->field('empresa_razon_social')
                ->searchable(),

            Column::add()
                ->title('PLACA')
                ->field('placa')
                ->searchable(),

            Column::add()
                ->title('Estado')
                ->field('estado_html')
                ->searchable(),

            Column::add()
                ->title('SIM CARD ANTERIOR')
                ->field('sim_old')
                ->searchable(),

            Column::action('ACCIONES'),
        ];
    }

    public function filters(): array
    {


        return [
            Filter::inputText('numero')->placeholder('Número'),

            Filter::enumSelect('operador')
                ->datasource(OperadorEnum::cases())
                ->optionLabel('operador'),

        ];
    }

    public function actionsFromView($row): View
    {
        return view('admin.almacen.lineas.actions-view', ['linea' => $row, 'actions' => ['edit', 'delete']]);
    }


    public function asignToPlaca(Lineas $linea)
    {
        $this->dispatch('asign-to-placa', $linea);
    }


    public function openModalSuspend()
    {
        $items = collect($this->selected);

        $this->dispatch('open-modal-suspend', $items);
    }

    public function suspender(Lineas $linea)
    {
        $items = collect($linea->numero);
        $this->dispatch('open-modal-suspend', $items);
    }

    public function activar(Lineas $linea)
    {
        $linea->fecha_suspencion = NULL;
        $linea->date_to_suspend = NULL;
        $linea->estado = 1;
        $linea->save();
    }

    public function openModalEdit(Lineas $linea)
    {
        $this->dispatch('open-modal-edit', linea: $linea);
    }

    public function openModalAsign()
    {
        $this->dispatch('open-modal-asign');
    }
}
