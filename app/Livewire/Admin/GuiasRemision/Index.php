<?php

namespace App\Livewire\Admin\GuiasRemision;

use App\Models\Guias;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\GuiaRemision;
use Livewire\WithPagination;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;

class Index extends Component
{
    use WithPagination;
    public $search = '';


    protected $listeners = [
        'updateTable' => 'render',
    ];

    public function render()
    {
        $guias = GuiaRemision::whereHas('motivoTraslado', function ($query) {
            $query->where('descripcion', 'like', '%' . $this->search . '%');
        })
            ->orWhereHas('cliente', function ($cliente) {
                $cliente->where('razon_social', 'like', '%' . $this->search . '%')
                    ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
            })
            ->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
            ->orWhere('serie_correlativo', 'like', '%' . $this->search . '%')
            ->orWhere('serie', 'like', '%' . $this->search . '%')
            ->orWhere('correlativo', 'like', '%' . $this->search . '%')
            ->orWhere('ubigeo_partida', 'like', '%' . $this->search . '%')
            ->orWhere('ubigeo_llegada', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(10);


        return view('livewire.admin.guias-remision.index', compact('guias'));
    }


    public function openDetallePanel(GuiaRemision $guia)
    {
        $this->dispatch('open-detalle-panel', $guia);
    }


    public function openModalDelete(GuiaRemision $guia)
    {
        $this->dispatch('EliminarGuia', $guia);
    }

    public function getCdr(GuiaRemision $guia)
    {
        try {
            $api = new ApiFacturacion();
            $mensaje =  $api->sendInvoiceOnlyGuia($guia);

            if ($mensaje['fe_codigo_error']) {

                $this->afterGetCdr($mensaje['fe_mensaje_error'], 'ERROR AL ENVIAR GUIA', 'error');
            } else {

                $this->afterGetCdr($mensaje['fe_mensaje_sunat'], 'GUIA ENVIADO A SUNAT', 'success');
            }
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function consultaTicket(GuiaRemision $guia)
    {

        try {
            $api = new ApiFacturacion();
            $mensaje =  $api->consultaTicket($guia);
            if ($mensaje['fe_codigo_error']) {

                $this->afterGetCdr($mensaje['fe_mensaje_error'], 'ERROR AL ENVIAR GUIA', 'error');
            } else {

                $this->afterGetCdr($mensaje['fe_mensaje_sunat'], 'GUIA ENVIADO A SUNAT', 'success');
            }
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function afterGetCdr($mensaje, $titulo, $icono)
    {
        $this->dispatch(
            'notify',
            icon: $icono,
            title: $titulo,
            mensaje: $mensaje,
        );
        $this->render();
    }
}
