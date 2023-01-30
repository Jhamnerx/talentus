<?php

namespace App\Http\Livewire\Admin\Gerencia\Recibos;

use Livewire\Component;
use App\Models\Clientes;
use App\Models\PaymentMethods;
use App\Models\RecibosPagosVarios;
use Illuminate\Support\Collection;
use App\Http\Requests\RecibosPagosRequest;

class Edit extends Component
{
    public $clientes_id, $serie, $numero, $serie_numero, $fecha_emision, $fecha_pago, $divisa, $estado;
    public $forma_pago, $total = 0.0;
    public $tipo_pago, $nota;


    public $showCredit = false;

    public RecibosPagosVarios $recibo;

    public Collection $items;

    public Collection $selected;
    public $simbolo = "S/. ";
    public $cliente;

    public function mount()
    {
        $this->clientes_id = $this->recibo->clientes_id;
        $this->serie = $this->recibo->serie;
        $this->numero = $this->recibo->numero;
        $this->serie_numero = $this->serie . "-" . $this->numero;
        $this->fecha_emision = $this->recibo->fecha_emision->format('Y-m-d');
        $this->fecha_pago = $this->recibo->fecha_pago->format('Y-m-d');
        $this->divisa = $this->recibo->divisa;
        $this->estado = $this->recibo->estado;
        $this->forma_pago = $this->recibo->forma_pago;
        $this->total = $this->recibo->total;
        $this->tipo_pago = $this->recibo->tipo_pago;

        $this->nota = $this->recibo->nota;

        $this->items = collect($this->recibo->detalles);

        $this->selected = collect([
            'producto' => "",
            'descripcion' => "",
            'cantidad' => 1,
            'total' => ""
        ]);

        if ($this->recibo->tipo_pago == "CREDITO") {
            $this->showCredit = true;
        }
        $this->cliente = Clientes::find($this->clientes_id);
    }

    public function render()
    {
        $payments_methods = PaymentMethods::pluck('name', 'id');

        return view('livewire.admin.gerencia.recibos.edit', compact('payments_methods'));
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

            $igv = round(round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2) * 18 / 100, 2);
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
            /// $this->sub_total = $this->calcularSubTotal();
            //$this->impuesto = $this->calcularImpuesto();
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
    public function actualizarRecibo()
    {

        $request = new RecibosPagosRequest();

        $data = $this->validate($request->rules($this->recibo), $request->messages());

        $this->recibo->update($data);

        $this->recibo->detalles()->delete();

        RecibosPagosVarios::createItems($this->recibo, $data["items"]);

        return redirect()->route('admin.gerencia.recibos.index')->with('update', 'El Recibo se actualizo con exito');
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
        $this->reCalTotal();
    }
}
