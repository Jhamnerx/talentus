<?php

namespace App\Http\Livewire\Admin\Cobros;

use Livewire\Component;
use App\Models\Cobros;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';
    public $status = null;


    protected $listeners = [
        'render'
    ];

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $cobros = Cobros::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orwhereHas('vehiculos', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%');
        })->orWhere('tipo_pago', 'like', '%' . $this->search . '%')
            ->orWhere('periodo', 'like', '%' . $this->search . '%')
            ->orWhere('monto_unidad', 'like', '%' . $this->search . '%')
            ->Where('estado', $this->status)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.cobros.index', compact('cobros'));
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

    public function status($status = null)
    {
        $this->status = $status;
        //$this->render();
        
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }   
}
