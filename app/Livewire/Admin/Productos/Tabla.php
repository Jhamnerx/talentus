<?php

namespace App\Livewire\Admin\Productos;

use App\Models\Productos;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class Tabla extends PowerGridComponent
{

    public string $tableName = 'TablaProductos';
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
        return Productos::query()->with('categoria', 'unit', 'image');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('codigo')
            // ->add('preview', fn($producto) => '<div class="w-14 h-10 shrink-0 flex items-center justify-center bg-slate-100 rounded-full mr-2 sm:mr-3"><img class="ml-1 rounded-full" src="' . $producto->image ? Storage::url($producto->image) : Storage::url('productos/default.jpg') . '"></div>')
            ->add('preview', fn($producto) => '<div class="w-12 h-12"><img class="h-full w-full shrink-0 grow-0 rounded-full" src="' . ($producto->image ? Storage::url($producto->image->url) : Storage::url('productos/default.jpg')) . '"></div>')
            ->add('descripcion')
            ->add('categoria_nombre', fn($producto) => $producto->categoria->nombre)
            ->add('vu', fn($producto) => $producto->divisa == 'USD' ? '$ ' . $producto->valor_unitario : 'S/ ' . $producto->valor_unitario)
            ->add('stock_descripcion', fn($producto) => $producto->tipo == 'producto' ? $producto->stock . ' ' . $producto->unit->name : 'servicio')
            ->add('servicio_cobro', fn($producto) => $producto->es_servicio_cobro
                ? '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 ring-1 ring-inset ring-emerald-500/30">&#128179; Facturación</span>'
                : '<span class="text-gray-300 dark:text-gray-600 text-xs">&mdash;</span>')
            ->add('estado')
            ->add('estado_label', fn($entry) => $entry->estado ? 'Activa' : 'Desactivada')
            ->add('created_at');
    }

    public function columns(): array
    {
        $columns = [

            Column::add()
                ->title('CODIGO')
                ->field('codigo')
                ->searchable(),

            Column::make('IMAGEN', 'preview'),

            Column::add()
                ->title('DESCRIPCION')
                ->field('descripcion')
                ->searchable(),

            Column::add()
                ->title('CATEGORIA')
                ->field('categoria_nombre')
                ->searchable(),

            Column::add()
                ->title('Valor Unitario')
                ->field('vu'),

            Column::add()
                ->title('Stock')
                ->field('stock_descripcion'),

            Column::make('COBROS', 'servicio_cobro')
                ->contentClasses('text-center'),

        ];

        if (auth()->user()->can('cambiar.estado-producto'))
            $columns[] = Column::add()
                ->title('ESTADO')
                ->field('estado')
                ->toggleable(true, 1, 0)
                ->sortable();

        if (auth()->user()->can('editar-producto') || auth()->user()->can('eliminar-producto'))
            $columns[] = Column::action('ACCIONES');

        return $columns;
    }

    public function filters(): array
    {
        return [];
    }

    public function actionsFromView($row): View
    {
        return view('components.actions-view', ['row' => $row, 'actions' => ['edit', 'delete'], 'model' => 'producto']);
    }
    public function onUpdatedToggleable(string|int $id, string $field, string $value): void
    {
        Productos::query()->find($id)->update([
            $field => e($value),
        ]);
    }

    public function openModalDelete(Productos $producto)
    {
        $this->dispatch('open-modal-delete', producto: $producto);
    }

    public function openModalEdit(Productos $producto)
    {
        $this->dispatch('open-modal-edit', producto: $producto);
    }
}
