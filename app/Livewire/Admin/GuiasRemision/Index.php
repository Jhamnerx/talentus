<?php

namespace App\Livewire\Admin\GuiasRemision;

use App\Models\Guias;
use Livewire\Component;
use App\Models\GuiaRemision;
use Livewire\WithPagination;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $detallePanelOpen = false;

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

        $guia->sim_cards;
        $this->dispatch('DetallePanel', $guia);

        $this->setDetalleOpen();
    }

    public function setDetalleOpen()
    {
        $this->detallePanelOpen = true;
    }

    public function setDetalleClose()
    {
        $this->detallePanelOpen = false;
        sleep(5);
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
            dd($mensaje);
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
