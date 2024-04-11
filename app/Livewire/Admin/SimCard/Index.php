<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\SimCard;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;
    public $from = '';
    public $to = '';
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
        $desde = $this->from;
        $hasta = $this->to;

        $sim_cards = SimCard::whereHas('linea', function ($query) {

            $query->where('numero', 'like', '%' . $this->search . '%')
                ->orwhere('operador', 'like', '%' . $this->search . '%');
        })->orwhereHas('vehiculos', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%');
        })->orWhere('sim_card', 'like', '%' . $this->search . '%')
            ->orWhere('operador', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);


        if (!empty($desde)) {


            $sim_cards = SimCard::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(sim_card like ? OR operador like ? )",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('id')
                ->paginate(10);
        }
        $total = SimCard::all()->count();

        return view('livewire.admin.sim-card.index', compact('sim_cards', 'total'));
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
        $this->dispatch('open-modal-create');
    }

    public function openModalAsign()
    {
        $this->dispatch('open-modal-asign');
    }

    public function openModalCambios(SimCard $sim_card)
    {

        $this->dispatch('open-modal-cambios', sim_card: $sim_card);
    }
}
