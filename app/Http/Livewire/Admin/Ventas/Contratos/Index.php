<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Models\Cobros;
use App\Models\Contratos;
use Carbon\Carbon;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';

    public $openModalDelete = false;
    public $modalOpenSend = false;

    protected $listeners = [
        'updateTable' => 'render',
    ];

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $contratos = Contratos::whereHas('cliente', function ($query) {
            $query->where('razon_social', 'LIKE', '%' . $this->search . '%');
        })->with(['detalle', 'detalle.vehiculos'])->with('cliente')
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
    public function openModalDelete(Contratos $contrato)
    {

        $this->emit('openModalDelete', $contrato);
        $this->openModalDelete = true;
    }
    public function modalOpenSend(Contratos $contrato)
    {


        $this->emit('modalOpenSend', $contrato);
    }


    public function createCobro(Contratos $contrato)
    {

        try {

            foreach ($contrato->detalle as  $detalle) {

                Cobros::create([
                    'clientes_id' => $contrato["clientes_id"],
                    'vehiculos_id' => $detalle["vehiculos_id"],
                    'contratos_id' => $contrato["id"],
                    'comentario' => "",
                    'periodo' => "MENSUAL",
                    'monto_unidad' => $detalle["plan"],
                    'fecha_vencimiento' => Carbon::now()->addYear(1)->format('Y-m-d'),
                    'tipo_pago' => 'FACTURA',
                    'nota' => "",
                    'observacion' => "",
                ]);
            }
            $this->dispatchBrowserEvent('create-cobro');
        } catch (Exception $e) {

            $this->dispatchBrowserEvent('error-cobro');
        }
    }
}
