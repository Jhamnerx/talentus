<?php

namespace App\Livewire\Admin\Facturacion\Ventas;

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

        $api = new ComprobantesController();
        $mensaje =  $api->enviarSunat($venta);
        return redirect()->route('admin.ventas.index')->with('get-cdr', $mensaje);
    }
}
