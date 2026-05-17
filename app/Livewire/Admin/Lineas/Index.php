<?php

namespace App\Livewire\Admin\Lineas;

use App\Models\Lineas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';
    public $operador = null;
    public $proximaReactivacion = false;
    public $modalOpenImport = false;



    public $selected = [];


    protected $listeners = [

        'echo:sim,SimCardImportUpdated' => 'updateLineasToSimCard',
        'echo:lineas,LineasImportUpdated' => 'updateLineas'

    ];


    #[On('update-table', 'render')]
    public function updateTable()
    {
        $this->render();
    }

    #[On('suspend-save')]
    public function setSelectedNull()
    {
        $this->selected = [];
    }

    public function updateLineasToSimCard()
    {
        $this->render();
    }

    public function updateLineas()
    {
        $this->render();
        $this->dispatch('lineas-import');
    }

    public function render()
    {
        $search = $this->search;
        $operador = $this->operador;

        if ($this->proximaReactivacion) {
            $limite = Carbon::now()->addDays(15);
            $claroId = \App\Models\Operador::whereRaw('UPPER(name) = ?', ['CLARO'])->value('id');
            $lineas = Lineas::where('operador_id', $claroId)
                ->where('baja', false)
                ->whereNotNull('date_to_suspend')
                ->where('date_to_suspend', '<=', $limite)
                ->where('date_to_suspend', '>=', Carbon::now())
                ->with('sim_card.vehiculos', 'sim_card.vehiculos.cliente', 'old_sim_cards')
                ->orderBy('date_to_suspend')
                ->paginate(10);
        } elseif ($operador !== null) {
            $lineas = Lineas::where('operador_id', $operador)
                ->where('numero', 'like', '%' . $search . '%')
                ->with('sim_card.vehiculos', 'sim_card.vehiculos.cliente', 'old_sim_cards')
                ->orderBy('id', 'desc')
                ->paginate(10);
        } elseif (!empty($search) && strlen($search) >= 3) {
            $lineas = Lineas::leftJoin('sim_card as sc', function ($join) {
                $join->on('sc.lineas_id', '=', 'lineas.id')
                    ->whereNull('sc.deleted_at');
            })
                ->leftJoin('vehiculos as v', function ($join) {
                    $join->on('v.sim_card_id', '=', 'sc.id')
                        ->whereNull('v.deleted_at');
                })
                ->leftJoin('clientes as c', 'c.id', '=', 'v.clientes_id')
                ->where(function ($q) use ($search) {
                    $q->where('lineas.numero', 'like', '%' . $search . '%')
                        ->orWhere('sc.sim_card', 'like', '%' . $search . '%')
                        ->orWhere('v.placa', 'like', '%' . $search . '%')
                        ->orWhere('c.razon_social', 'like', '%' . $search . '%');
                })
                ->select('lineas.*')
                ->distinct()
                ->with('sim_card.vehiculos', 'sim_card.vehiculos.cliente', 'old_sim_cards')
                ->orderBy('lineas.id', 'desc')
                ->paginate(10);
        } else {
            $lineas = Lineas::with('sim_card.vehiculos', 'sim_card.vehiculos.cliente', 'old_sim_cards')
                ->orderBy('id', 'desc')
                ->paginate(10);
        }


        $operadoresList = \App\Models\Operador::orderBy('name')->get();

        return view('livewire.admin.lineas.index', compact('lineas', 'operadoresList'));
    }

    public function SetOperador($operador = null)
    {
        $this->operador = $operador;
        $this->proximaReactivacion = false;
    }

    public function toggleProximaReactivacion()
    {
        $this->proximaReactivacion = ! $this->proximaReactivacion;
        $this->operador = null;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function activar(Lineas $linea)
    {
        $fechaSuspension = $linea->fecha_suspencion;

        $linea->fecha_suspencion = NULL;
        $linea->date_to_suspend = NULL;
        $linea->estado = 1;
        $linea->save();

        // Registrar reactivación en historial
        \App\Models\CambiosLineas::create([
            'tipo_cambio' => 'Reactivación',
            'sim_card_id' => $linea->sim_card_id,
            'old_numero' => $linea->id,
            'new_numero' => $linea->id,
            'fecha_suspencion' => $fechaSuspension,
            'fecha_suspencion_fin' => now(),
            'user_id' => Auth::user()->id,
        ]);
    }

    public function openModalImport()
    {
        $this->dispatch('openModalImport');
    }

    public function asignToPlaca(Lineas $linea)
    {
        $this->dispatch('asign-to-placa', $linea);
    }

    public function consulta()
    {
        $lineas = Lineas::whereNotNull('old_sim_card')->get();
        foreach ($lineas as $linea) {

            $linea->old_sim_cards()->create([
                'old_sim_card' =>  $linea->old_sim_card,
                'user_id' => Auth::user()->id,
            ]);
        }
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


    public function unSelect()
    {

        $this->selected = [];
    }

    public function openModalReporteLineas()
    {
        $this->dispatch('openModalReporteLineas');
    }

    public function openModalCreate()
    {
        $this->dispatch('open-modal-create');
    }

    public function openModalEdit(Lineas $linea)
    {
        $this->dispatch('open-modal-edit', linea: $linea);
    }

    public function openModalAsign()
    {

        $this->dispatch('open-modal-asign');
    }

    public function openModalCambiarChip(Lineas $linea)
    {
        $this->dispatch('open-modal-cambiar-chip', linea: $linea);
    }
}
