<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use App\Http\Controllers\Admin\PresupuestoController;
use Livewire\Component;
use App\Http\Controllers\Admin\UtilesController;
use App\Http\Requests\PresupuestosRequest;
use App\Models\Presupuestos;
use App\Models\Productos;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $clientes_id, $serie, $correlativo, $serie_correlativo, $numero, $fecha, $fecha_caducidad, $divisa = 'PEN', $nota;
    public $sub_total = 0.00, $impuesto = 0.00, $total = 0.00;
    public $sub_total_soles = 0.00, $impuesto_soles = 0.00, $total_soles = 0.00;
    public $features = false;

    public $tipoCambio = 0;
    public $ConvertirSoles = false;

    public Collection $items;
    public Collection $selected;

    public $simbolo = "S/. ";
    public $productoSelected;
    public function mount()
    {
        $this->tipoCambio  = UtilesController::tipoCambio();
        $this->numero = 1;
        $this->fecha = Carbon::now()->format('Y-m-d');
        $this->fecha_caducidad = Carbon::now()->addDays(15)->format('Y-m-d');
        $this->items = collect();
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
        return view('livewire.admin.ventas.presupuestos.create');
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

            $this->items->push([
                'producto_id' => $this->selected["producto_id"],
                'producto' => $this->selected->get('producto'),
                'descripcion' => $this->selected["descripcion"],
                'cantidad' => $this->selected["cantidad"],
                'precio' => $this->selected["precio"],
                'igv' => round(round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2) * 18 / 100, 2),
                'total' => round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2),
            ]);

            $this->selected = collect();

            //calcular los totales al añadir un producto
            $this->sub_total = $this->calcularSubTotal();
            $this->impuesto = $this->calcularImpuesto();
            $this->total = $this->calcularTotal();

            $this->calcularTotalSoles();
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

        $this->calcularTotalSoles();
    }

    public function calcularTotalSoles()
    {
        if ($this->divisa == "USD") {

            $this->sub_total_soles = number_format(floatval($this->tipoCambio * $this->sub_total), 2, '.', '');

            $this->impuesto_soles = number_format((floatval($this->sub_total_soles) * 18) / 100, 2, '.', '');
            $this->total_soles = number_format((floatval($this->impuesto_soles) + floatval($this->sub_total_soles)), 2, '.', '');
        }
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
            $this->ConvertirSoles = true;
            $this->simbolo = "$";
            $this->calcularTotalSoles();
        } else {
            $this->ConvertirSoles = false;
            $this->simbolo = "S/. ";
        }
    }

    public function updated($name, $value)
    {
        $request = new PresupuestosRequest();
        $error = $this->validateOnly($name, $request->rules(), $request->messages());
    }

    public function save()
    {

        $request = new PresupuestosRequest();
        $data = $this->validate($request->rules(), $request->messages());
        $presupuesto = Presupuestos::create($data);
        $presupuesto->save();

        Presupuestos::createItems($presupuesto, $data["items"]);

        return redirect()->route('admin.ventas.presupuestos.index')->with('store', 'El Presupuesto se creo con exito');
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
        $this->reCalTotal();
    }


    public function OpenModalCliente($busqueda)
    {
        $this->dispatch('open-modal-save-cliente', busqueda: $busqueda);
    }
}
