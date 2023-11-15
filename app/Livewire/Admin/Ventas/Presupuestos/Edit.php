<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use App\Models\Presupuestos;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Http\Controllers\Admin\UtilesController;
use App\Http\Requests\PresupuestosRequest;
use App\Models\Productos;

class Edit extends Component
{
    public $clientes_id, $numero, $fecha, $fecha_caducidad, $divisa, $nota;
    public $sub_total = 0.00, $impuesto = 0.00, $total = 0.00;
    public $sub_total_soles = 0.00, $impuesto_soles = 0.00, $total_soles = 0.00;
    public $features = false;
    public Presupuestos $presupuesto;

    public $tipoCambio = 0;
    public $ConvertirSoles = false;

    public Collection $items;
    public Collection $selected;
    public $simbolo = "S/. ";

    public function mount()
    {
        $this->tipoCambio  = UtilesController::tipoCambio();
        $this->numero = $this->presupuesto->numero;
        $this->clientes_id = $this->presupuesto->clientes_id;
        $this->fecha = $this->presupuesto->fecha->format('Y-m-d');
        $this->fecha_caducidad = $this->presupuesto->fecha_caducidad->format('Y-m-d');
        $this->divisa = $this->presupuesto->divisa;
        $this->sub_total = $this->presupuesto->sub_total;
        $this->impuesto = $this->presupuesto->impuesto;
        $this->total = $this->presupuesto->total;
        $this->features = $this->presupuesto->features;



        if ($this->presupuesto->divisa == "USD") {

            $this->sub_total_soles = $this->presupuesto->sub_total_soles;
            $this->impuesto_soles = $this->presupuesto->impuesto_soles;
            $this->total_soles = $this->presupuesto->total_soles;
        }
        $this->nota = $this->presupuesto->nota;

        $this->items = collect($this->presupuesto->detalles);

        $this->selected = collect([
            'id' => "",
            'producto' => "",
            'descripcion' => "",
            'cantidad' => 1,
            'total' => ""
        ]);
    }

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.edit');
    }

    function addProducto()
    {
        $this->validate([
            'selected.id' => 'required',
            'selected.producto' => 'required',
            'selected.descripcion' => 'nullable',
            'selected.cantidad' => 'required',
            'selected.precio' => 'required',

        ], [
            'selected.id.required' => 'Seleccion una producto',
            'selected.producto.required' => 'Por favor ingresa un producto',
            'selected.cantidad.required' => 'Por favor ingresa una cantidad',
            'selected.precio.required' => 'Por favor ingresa un precio',
        ]);

        try {
            $this->items->push([
                'id' => $this->selected["id"],
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
            'id' => $producto->id,
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
        $error = $this->validateOnly($name, $request->rules($this->presupuesto), $request->messages());
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
        $this->reCalTotal();
    }

    public function actualizarPresupuesto()
    {
        $request = new PresupuestosRequest();
        $data = $this->validate($request->rules($this->presupuesto), $request->messages());

        $this->presupuesto->update($data);

        $this->presupuesto->detalles()->delete();

        Presupuestos::createItems($this->presupuesto, $data["items"]);

        return redirect()->route('admin.ventas.presupuestos.index')->with('update', 'El Presupuesto se actualizo con exito');
    }
}
