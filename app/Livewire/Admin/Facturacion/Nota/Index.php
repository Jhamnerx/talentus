<?php

namespace App\Livewire\Admin\Facturacion\Nota;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Comprobantes;
use Livewire\WithPagination;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;

class Index extends Component
{
    use WithPagination;

    public $search;

    protected $listeners = [
        'update' => 'render'
    ];

    public function render()
    {
        $notas = Comprobantes::whereHas('cliente', function ($cliente) {
            $cliente->where('razon_social', 'LIKE', '%' . $this->search . '%')
                ->orWhere('numero_documento', 'LIKE', '%' . $this->search . '%');
        })
            ->orWhere('serie', 'LIKE', '%' . $this->search . '%')
            ->orWhere('correlativo', 'LIKE', '%' . $this->search . '%')
            ->orWhere('serie_correlativo', 'LIKE', '%' . $this->search . '%')
            ->orwhereDate('fecha_emision', $this->validateDate($this->search) ? Carbon::createFromFormat('d-m-Y', $this->search)->format('Y-m-d') : '')
            ->orderby('id', 'desc')
            ->with('cliente')
            ->paginate(10);

        return view('livewire.admin.facturacion.nota.index', compact('notas'));
    }

    function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function openModalDelete(Comprobantes $nota)
    {

        $this->emit('open-modal-delete', $nota);
    }

    public function getCdr(Comprobantes $nota)
    {
        try {

            $api = new ApiFacturacion();
            $mensaje =  $api->sendInvoiceOnlyNota($nota);

            if ($mensaje['fe_codigo_error']) {

                $this->afterGetCdr($mensaje['fe_mensaje_error'], 'ERROR AL ENVIAR COMPROBANTE', 'error');
            } else {

                $this->afterGetCdr($mensaje['fe_mensaje_sunat'], 'COMPROBANTE ENVIADO A SUNAT', 'success');
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
