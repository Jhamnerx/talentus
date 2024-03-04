<?php

namespace App\Livewire\Admin\Facturacion\Ventas;

use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;
use App\Http\Controllers\Admin\Facturacion\ComprobantesController;
use App\Models\Ventas;
use Livewire\Component;
use Livewire\WithPagination;
use DateTime;
use Carbon\Carbon;

class Index extends Component
{

    use WithPagination;

    public $search;

    protected $listeners = [
        'update' => 'render'
    ];


    public function render()
    {
        $ventas = Ventas::whereHas('cliente', function ($cliente) {
            $cliente->where('razon_social', 'LIKE', '%' . $this->search . '%')
                ->orWhere('numero_documento', 'LIKE', '%' . $this->search . '%');
        })
            ->orWhere('serie', 'LIKE', '%' . $this->search . '%')
            ->orWhere('correlativo', 'LIKE', '%' . $this->search . '%')
            ->orWhere('serie_correlativo', 'LIKE', '%' . $this->search . '%')
            ->orwhereDate('fecha_emision', $this->validateDate($this->search) ? Carbon::createFromFormat('d-m-Y', $this->search)->format('Y-m-d') : '')
            ->orderby('id', 'desc')
            ->with('cliente')
            ->paginate(10);;;

        return view('livewire.admin.facturacion.ventas.index', compact('ventas'));
    }


    function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function openModalDelete(Ventas $venta)
    {

        $this->emit('openModalDelete', $venta);
    }

    public function emitFactura()
    {
        return redirect()->route('admin.factura.create');
    }
    public function emitBoleta()
    {
        return redirect()->route('admin.boleta.create');
    }
    public function emitNotaVenta()
    {
        return redirect()->route('admin.nota.venta.create');
    }

    public function getCdr(Ventas $venta)
    {
        $api = new ApiFacturacion();
        $mensaje =  $api->sendInvoiceOnly($venta);

        if ($mensaje['fe_codigo_error']) {

            $this->afterGetCdr($mensaje['fe_mensaje_error'], 'ERROR AL ENVIAR COMPROBANTE', 'error');
        } else {

            $this->afterGetCdr($mensaje['fe_mensaje_sunat'], 'COMPROBANTE ENVIADO A SUNAT', 'success');
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
