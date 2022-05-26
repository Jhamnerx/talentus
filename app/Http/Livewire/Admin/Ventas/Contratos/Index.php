<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Models\Contratos;
use Livewire\Component;

class Index extends Component
{
    public $search;
    public $from = '';
    public $to = '';

    protected $listeners = [
        'updateTable' => 'render',
    ];

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $contratos = Contratos::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'LIKE', '%' . $this->search . '%');
        })
            ->orWhere('fecha', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);


        $total = Contratos::all()->count();
        return view('livewire.admin.ventas.contratos.index', compact('contratos', 'total'));

        if (!empty($desde)) {


            $contratos = Contratos::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(fecha like ?)",
                [
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('id', 'desc')
                ->paginate(10);
        }
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
}
