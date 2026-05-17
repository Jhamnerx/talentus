<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\SimCard;
use App\Models\Operador;
use App\Services\M2MDataglobalService;
use Livewire\Component;
use Livewire\Attributes\On;
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
        'echo:sim,SimCardImportUpdated' => 'updateSimCard'
    ];

    public function updateSimCard()
    {

        $this->render();
        $this->dispatch('sim-import');
    }

    public function render()
    {
        $search = $this->search;
        $desde  = $this->from;
        $hasta  = $this->to;

        $query = SimCard::query();

        if ($this->operador !== null) {
            $query->where('sim_card.operador_id', $this->operador);
        }

        if (!empty($desde)) {
            $query->whereBetween('sim_card.created_at', [
                $desde . ' 00:00:00',
                $hasta . ' 23:59:59',
            ]);
        }

        if (!empty($search) && strlen($search) >= 3) {
            $query->leftJoin('lineas as l', function ($join) {
                $join->on('l.id', '=', 'sim_card.lineas_id')
                    ->whereNull('l.deleted_at');
            })
                ->leftJoin('vehiculos as v', function ($join) {
                    $join->on('v.sim_card_id', '=', 'sim_card.id')
                        ->whereNull('v.deleted_at');
                })
                ->where(function ($q) use ($search) {
                    $q->where('sim_card.sim_card', 'like', '%' . $search . '%')
                        ->orWhere('l.numero', 'like', '%' . $search . '%')
                        ->orWhere('v.placa', 'like', '%' . $search . '%');
                })
                ->select('sim_card.*')
                ->distinct();
        }

        $sim_cards = $query->orderBy('sim_card.id', 'desc')->paginate(10);

        $total = SimCard::count();
        $operadoresList = Operador::orderBy('name')->get();
        $operadorM2M    = Operador::where('api_slug', M2MDataglobalService::API_SLUG)->first();

        return view('livewire.admin.sim-card.index', compact('sim_cards', 'total', 'operadoresList', 'operadorM2M'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setOperador($operador = null)
    {
        $this->operador = $operador;
        $this->resetPage();
    }

    /**
     * Sincroniza las SIM cards de la API M2M Dataglobal hacia la tabla local.
     * Requiere que exista un operador con api_slug = 'm2m_dataglobal'.
     */
    public function sincronizarM2M(M2MDataglobalService $m2m)
    {
        $operador = Operador::where('api_slug', M2MDataglobalService::API_SLUG)->first();

        if (! $operador) {
            $this->dispatch('notify', type: 'error', message: 'No hay un operador configurado con api_slug = "m2m_dataglobal".');
            return;
        }

        $resultado = $m2m->sincronizar($operador, session('empresa', 1));

        if ($resultado['error']) {
            $this->dispatch('notify', type: 'error', message: 'Error al sincronizar: ' . $resultado['error']);
            return;
        }

        $this->dispatch(
            'notify',
            type: 'success',
            message: "Sincronización completa: {$resultado['insertados']} nuevas, {$resultado['actualizados']} actualizadas."
        );

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

    public function openModalImport()
    {
        $this->dispatch('open-modal-import');
    }

    public function openModalUnAsign(SimCard $sim)
    {
        $this->dispatch('open-modal-unasign', sim: $sim);
    }

    #[On('update-table')]
    public function updateTable()
    {
        $this->render();
    }


    public function openModalCreate()
    {
        $this->dispatch('sim-card-open-modal-create');
    }

    public function openModalAsign()
    {
        $this->dispatch('open-modal-asign');
    }

    public function openModalCambios(SimCard $sim_card)
    {

        $this->dispatch('open-modal-cambios', sim_card: $sim_card);
    }

    public function openModalEdit(SimCard $sim_card)
    {
        $this->dispatch('sim-card-open-modal-edit', sim_card: $sim_card);
    }

    public function openModalCambiarNumero(SimCard $sim_card)
    {
        $this->dispatch('open-modal-cambiar-numero', sim_card: $sim_card);
    }
}
