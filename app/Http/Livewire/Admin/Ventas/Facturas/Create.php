<?php

namespace App\Http\Livewire\Admin\Ventas\Facturas;

use App\Http\Controllers\Admin\VentasFacturasController;
use App\Http\Requests\FacturasRequest;
use App\Models\Clientes;
use App\Models\Facturas;
use App\Models\PaymentMethods;
use App\Models\plantilla;
use App\Models\Productos;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{


    public $clientes_id, $serie, $numero, $serie_numero, $fecha_emision, $fecha_vencimiento, $divisa = 'PEN', $estado = "BORRADOR";
    public $forma_pago = 1, $fecha_pago, $sub_total = 0.00, $impuesto = 0.00, $total = 0.0;
    public $tipo_venta = "CONTADO", $adelanto = 0.00, $numero_cuotas = 0, $vence_cuotas = 30, $nota;


    public $showCredit = false;
    public Collection $items;

    public Collection $selected;
    public $simbolo = "S/. ";
    public $cliente;

    public Collection $detalle_cuotas;


    public function mount()
    {
        $facturaController = new VentasFacturasController();

        $this->numero = $facturaController->setNextSequenceNumber();
        $this->serie = plantilla::first()->series["factura"];
        $this->serie_numero = $this->serie . "-" . $this->numero;
        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        $this->fecha_vencimiento = Carbon::now()->addDays(1)->format('Y-m-d');
        $this->items = collect();
        $this->detalle_cuotas = collect();
        $this->selected = collect([
            'producto_id' => "",
            'producto' => "",
            'descripcion' => "",
            'cantidad' => 1,
            'total' => ""
        ]);
    }

    public function render()
    {

        $payments_methods = PaymentMethods::pluck('name', 'id');

        return view('livewire.admin.ventas.facturas.create', compact('payments_methods'));
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
                'igv' => $igv,
                'total' => $total,
            ]);

            $this->selected = collect();

            //calcular los totales al añadir un producto
            // $this->sub_total = $this->calcularSubTotal();
            // $this->impuesto = $this->calcularImpuesto();
            // $this->total = $this->calcularTotal();
            $this->reCalTotal();

            //$this->calcularTotalSoles();
            $this->dispatchBrowserEvent('add-producto');
            $this->calcularCuotas($this->numero_cuotas);
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
            $item["igv"] =  round(floatval($item["total"]) * 18 / 100, 2);

            return $item;
        });

        $this->reCalTotal();
    }


    public function reCalTotal()
    {
        $this->sub_total =   $this->calcularSubTotal();
        $this->impuesto =  $this->calcularImpuesto();
        $this->total =  $this->calcularTotal();
        $this->calcularCuotas($this->numero_cuotas);
    }


    public function calcularSubTotal()
    {
        $sub_total = $this->items->map(function ($item, $key) {

            $sub_total = 0;
            $sub_total =  $sub_total + $item["total"];

            return number_format($sub_total, 2, '.', '');
        });

        return $sub_total->sum();
    }

    public function calcularImpuesto()
    {
        $impuesto = (floatval($this->sub_total) * 18) / 100;

        return number_format($impuesto, 2, '.', '');
    }

    public function calcularTotal()
    {
        $total = $this->sub_total + $this->impuesto;

        return number_format($total, 2, '.', '');
    }


    public function updatedDivisa($value)
    {
        if ($value == "USD") {
            $this->simbolo = "$";
        } else {
            $this->simbolo = "S/. ";
        }
    }
    public function updatedTipoVenta()
    {
        $this->toggleShowCredit();
    }

    public function updatedNumeroCuotas($value)
    {

        $this->calcularCuotas($value);
    }


    public function calcularCuotas($value)
    {
        $this->detalle_cuotas = collect();
        $fecha = Carbon::now();

        for ($i = 0; $i < (int)$value; $i++) {

            $this->detalle_cuotas->push([
                'n_cuota' => $i + 1,
                'dias' => $this->vence_cuotas,
                'fecha' => $fecha->addDays($this->vence_cuotas)->format('Y-m-d'),
                'dia_semana' => $fecha->dayName,
                'importe' => $this->total > 0 ? round(floatval(($this->total - floatval($this->adelanto)) / $value), 2)  : 0.00,
            ]);
        }
    }

    public function updatedAdelanto()
    {
        $this->calcularCuotas($this->numero_cuotas);
    }

    public function updatedVenceCuotas($value)
    {
        $this->calcularCuotas($this->numero_cuotas);
    }

    public function updatedClientesId($value)
    {
        $this->cliente = Clientes::find($this->clientes_id);
    }

    public function toggleShowCredit()
    {

        if ($this->tipo_venta == "CREDITO") {

            $this->showCredit = true;
            $this->resetCrediFields();
        } else {
            $this->showCredit = false;
        }
    }

    public function resetCrediFields()
    {
        $this->numero_cuotas = 0;
        $this->adelanto = 0.00;
        $this->detalle_cuotas = collect();
    }

    public function unselectCliente()
    {
        $this->cliente = null;
        $this->clientes_id = null;
        $this->dispatchBrowserEvent('unselect-cliente');
    }

    public function updated($name, $value)
    {
        $request = new FacturasRequest();
        $error = $this->validateOnly($name, $request->rules(), $request->messages());
    }
    public function save()
    {


        $request = new FacturasRequest();
        $data = $this->validate($request->rules(), $request->messages());

        $factura = Facturas::create($data);

        Facturas::createItems($factura, $data["items"]);

        return redirect()->route('admin.ventas.facturas.index')->with('store', 'La factura se registro con exito');
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
        $this->reCalTotal();
    }
}
