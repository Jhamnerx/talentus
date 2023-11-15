<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use App\Http\Controllers\Admin\RecibosController;
use App\Http\Requests\RecibosRequest;
use App\Models\Clientes;
use App\Models\plantilla;
use App\Models\PaymentMethods;
use App\Models\Productos;
use App\Models\Recibos;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{


    public $clientes_id, $serie, $numero, $serie_numero, $fecha_emision, $fecha_pago, $divisa = 'PEN', $estado = "BORRADOR";
    public $forma_pago = 1, $total = 0.0;
    public $tipo_venta = "CONTADO", $nota;


    public $showCredit = false;
    public Collection $items;

    public Collection $selected;
    public $simbolo = "S/. ";
    public $cliente;

    public Collection $detalle_cuotas;


    public function mount()
    {
        $reciboController = new RecibosController();

        $this->numero = $reciboController->setNextSequenceNumber();
        $this->serie = plantilla::first()->series["recibo"];
        $this->serie_numero = $this->serie . "-" . $this->numero;
        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        $this->fecha_pago = Carbon::now()->format('Y-m-d');
        $this->items = collect();
    }

    public function render()
    {
        $payments_methods = PaymentMethods::pluck('name', 'id');
        return view('livewire.admin.ventas.recibos.create', compact('payments_methods'));
    }


    function addProducto()
    {

        $this->validate([
            'selected.producto_id' => 'required',
            'selected.producto' => 'required',
            'selected.descripcion' => 'nullable',
            'selected.cantidad' => 'required',
            'selected.precio' => 'required',

        ], [
            'selected.producto_id.required' => 'Seleccion una producto',
            'selected.producto.required' => 'Por favor ingresa un producto',
            'selected.cantidad.required' => 'Por favor ingresa una cantidad',
            'selected.precio.required' => 'Por favor ingresa un precio',
        ]);

        try {

            $igv = round(round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2) * 18 / 100, 2);
            $total = round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2);
            $this->items->push([
                'producto_id' => $this->selected["producto_id"],
                'producto' => $this->selected->get('producto'),
                'descripcion' => $this->selected["descripcion"],
                'cantidad' => $this->selected["cantidad"],
                'precio' => $this->selected["precio"],
                'total' => $total,
            ]);

            $this->selected = collect();

            //calcular los totales al añadir un producto
            $this->total = $this->calcularTotal();
            $this->dispatch('add-producto');
        } catch (\Exception $e) {
            throw $e;
        }
    }
    function selectProduct(Productos $producto)
    {
        $this->selected = collect([
            'producto_id' => $producto->id,
            'producto' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'cantidad' => "1",
            'precio' => $producto->precio
        ]);
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
        $this->dispatch('unselect-cliente');
    }

    public function updated($name, $value)
    {
        $request = new RecibosRequest();
        $error = $this->validateOnly($name, $request->rules(), $request->messages());
    }

    public function save()
    {

        $request = new RecibosRequest();
        $data = $this->validate($request->rules(), $request->messages());

        $factura = Recibos::create($data);

        Recibos::createItems($factura, $data["items"]);

        return redirect()->route('admin.ventas.recibos.index')->with('store', 'El Recibo se registro con exito');
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
        $this->reCalTotal();
    }
}
