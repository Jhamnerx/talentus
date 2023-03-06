<?php

namespace App\Http\Livewire\Admin\Lineas;

use App\Models\Lineas;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';
    public $operador = null;
    public $modalOpenImport = false;

    protected $listeners = [
        'render' => 'render',
        'index-update' => 'render',
        'echo:sim,SimCardImportUpdated' => 'updateLineasToSimCard',
        'echo:lineas,LineasImportUpdated' => 'updateLineas'
    ];

    public function updateLineasToSimCard()
    {
        $this->render();
    }
    public function updateLineas()
    {

        $this->render();
        $this->dispatchBrowserEvent('lineas-import');
    }

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $lineas = Lineas::whereHas('sim_card', function ($query) {

            $query->where('sim_card', 'LIKE', '%' . $this->search . '%');

            $query->orWhereHas('vehiculos', function ($vehiculo) {

                $vehiculo->where('placa', 'like', '%' . $this->search . '%');

                $vehiculo->orWhereHas('cliente', function ($cliente) {
                    $cliente->where('razon_social', 'like', '%' . $this->search . '%');
                });
            });
        })->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('operador', 'like', '%' . $this->search . '%')
            ->orWhere('old_sim_card', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $operador = $this->operador;

        if ($operador != null) {

            $lineas = Lineas::Where('operador', $operador)
                ->Where('numero', 'like', '%' . $this->search . '%')
                ->paginate(10);
        }


        return view('livewire.admin.lineas.index', compact('lineas'));
    }

    public function operador($operador = null)
    {
        $this->operador = $operador;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 7 days"));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 month"));
                $this->to = date('Y-m-d');
                break;
            case '12':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 year"));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }

    public function suspender(Lineas $linea)
    {

        $linea->fecha_suspencion = Carbon::now();
        $linea->estado = 2;
        $linea->date_to_suspend = Carbon::now()->addDays(59);
        $linea->save();
    }

    public function activar(Lineas $linea)
    {
        $linea->fecha_suspencion = NULL;
        $linea->date_to_suspend = NULL;
        $linea->estado = 1;
        $linea->save();
    }

    public function openModalImport()
    {
        $this->emit('openModalImport');
    }

    public function asignToPlaca(Lineas $linea)
    {
        $this->emit('asign-to-placa', $linea);
    }
}