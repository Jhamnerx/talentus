<?php

namespace App\Livewire\Admin\Ventas\Contratos;

use App\Models\Cobros;
use App\Models\Contratos;
use Carbon\Carbon;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;


    #[On('update-table')]
    public function render()
    {

        $contratos = Contratos::whereHas('cliente', function ($query) {
            $query->where('razon_social', 'LIKE', '%' . $this->search . '%');
        })->with(['detalle', 'detalle.vehiculos', 'cliente'])
            ->orWhere('fecha', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.ventas.contratos.index', compact('contratos'));
    }

    public function openModalDelete(Contratos $contrato)
    {
        $this->dispatch('open-modal-delete', $contrato);
    }


    public function modalOpenSend(Contratos $contrato)
    {

        $this->dispatch('modalOpenSend', $contrato);
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
                    'divisa' => "PEN",
                    'periodo' => "MENSUAL",
                    'monto_unidad' => $detalle["plan"],
                    'fecha_vencimiento' => Carbon::now()->addYear(1)->format('Y-m-d'),
                    'tipo_pago' => 'FACTURA',
                    'nota' => "",
                    'observacion' => "",
                ]);
            }

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'COBRO REGISTRADO',
                mensaje: 'se creo el cobro de este contrato',
            );
        } catch (Exception $e) {

            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR EL CREAR',
                mensaje: $e->getMessage(),
            );
        }
    }
}
