<?php

namespace App\Http\Livewire\Admin\Lineas;

use App\Models\SimCard;
use Livewire\Component;
use Livewire\WithPagination;
class LineasIndex extends Component
{
    use WithPagination;

    public $search;
    public $from = '';
    public $to = '';
    public $modalOpenImport = false;
    // public $openUnAsign = false;
    protected $listeners = [
        'render' => 'render',
        'echo:sim,SimCardImportUpdated' => 'updateSimCard'
    ];


    public function updateSimCard(){

        $this->render();
        $this->dispatchBrowserEvent('sim-import');
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
            ->orWhere('operador', 'like', '%' . $this->search . '%')->with('linea', 'vehiculos')
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
        
        return view('livewire.admin.lineas.lineas-index', compact('sim_cards', 'total'));
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

    public function openModalImport(){

        $this->emit('openModalImport');

    }

}
