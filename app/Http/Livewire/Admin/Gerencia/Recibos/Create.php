<?php

namespace App\Http\Livewire\Admin\Gerencia\Recibos;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\PaymentMethods;
use Illuminate\Support\Collection;
use App\Http\Controllers\Admin\RecibosPagosVariosController;
use App\Http\Requests\RecibosPagosRequest;
use App\Models\RecibosPagosVarios;

class Create extends Component
{

    public $clientes_id, $serie, $numero, $serie_numero, $fecha_emision, $fecha_pago, $divisa = 'PEN', $estado = "BORRADOR";
    public $forma_pago = 1, $total = 0.0;
    public $tipo_pago = "CONTADO", $nota;


    public $showCredit = false;
    public Collection $items;

    public Collection $selected;
    public $simbolo = "S/. ";
    public $cliente;


    public function mount()
    {
        $reciboController = new RecibosPagosVariosController();
        $this->numero = $reciboController->setNextSequenceNumber();
        $this->serie = "RB";
        $this->serie_numero = $this->serie . "-" . $this->numero;
        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        $this->fecha_pago = Carbon::now()->format('Y-m-d');
        $this->items = collect();
        $this->selected = collect([
            'producto' => "",
            'descripcion' => "",
            'cantidad' => 1,
            'total' => ""
        ]);
    }


    public function render()
    {
        $payments_methods = PaymentMethods::pluck('name', 'id');
        return view('livewire.admin.gerencia.recibos.create', compact('payments_methods'));
    }

    function addProducto()
    {

        $this->validate([
            'selected.producto' => 'required',
            'selected.descripcion' => 'nullable',
            'selected.cantidad' => 'required',
            'selected.precio' => 'required',

        ], [
            'selected.producto.required' => 'Por favor ingresa un producto',
            'selected.cantidad.required' => 'Por favor ingresa una cantidad',
            'selected.precio.required' => 'Por favor ingresa un precio',
        ]);

        try {

            $total = round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2);
            $this->items->push([
                'producto' => $this->selected->get('producto'),
                'descripcion' => $this->selected["descripcion"],
                'cantidad' => $this->selected["cantidad"],
                'precio' => $this->selected["precio"],
                'total' => $total,
            ]);

            $this->selected = collect();


            //calcular los totales al añadir un producto
            $this->total = $this->calcularTotal();
            $this->dispatchBrowserEvent('add-producto');
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function updatedItems($name, $value)
    {
        $this->items = $this->items->map(function ($item, $key) {

            $item["total"] =  round(floatval($item["cantidad"]) *  floatval($item["precio"]), 2);
            return $item;
        });

        $this->reCalTotal();
    }


    public function reCalTotal()
    {
        $this->total =  $this->calcularTotal();
    }


    public function calcularTotal()
    {
        $sub_total = $this->items->map(function ($item, $key) {

            $sub_total = 0;
            $sub_total =  $sub_total + $item["total"];

            return number_format($sub_total, 2, '.', '');
        });

        return $sub_total->sum();
    }


    public function updatedDivisa($value)
    {
        if ($value == "USD") {
            $this->simbolo = "$";
        } else {
            $this->simbolo = "S/. ";
        }
    }
    public function updatedClientesId($value)
    {
        $this->cliente = Clientes::find($this->clientes_id);
    }
    public function unselectCliente()
    {
        $this->cliente = null;
        $this->clientes_id = null;
        $this->dispatchBrowserEvent('unselect-cliente');
    }

    public function updated($name, $value)
    {
        $request = new RecibosPagosRequest();
        $error = $this->validateOnly($name, $request->rules(), $request->messages());
    }

    public function save()
    {

        $request = new RecibosPagosRequest();
        $data = $this->validate($request->rules(), $request->messages());

        $factura = RecibosPagosVarios::create($data);

        RecibosPagosVarios::createItems($factura, $data["items"]);

        return redirect()->route('admin.gerencia.recibos.index')->with('store', 'El Recibo se registro con exito');
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
        $this->reCalTotal();
    }
}
