<?php

namespace App\Livewire\Admin\Gerencia\Recibos;

use Carbon\Carbon;
use App\Models\Series;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Productos;
use App\Models\PaymentMethods;
use App\Models\RecibosPagosVarios;
use Illuminate\Support\Collection;
use App\Http\Requests\RecibosPagosRequest;
use App\Http\Controllers\Admin\RecibosPagosVariosController;

class Create extends Component
{

    public $clientes_id, $serie, $numero, $serie_numero, $fecha_emision, $fecha_pago, $divisa = 'PEN', $estado = "BORRADOR";
    public $forma_pago = "009", $total = 0.0;
    public $tipo_venta = "CONTADO", $nota;


    public $showCredit = false;
    public Collection $items;

    public Collection $selected;
    public $simbolo = "S/. ";
    public $cliente;
    public $product_selected_id;

    public Collection $detalle_cuotas;


    public function mount()
    {
        $this->setSerieMount();

        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        $this->fecha_pago = Carbon::now()->format('Y-m-d');
        $this->items = collect();

        $this->selected = collect([
            'producto_id' => null,
            'producto' => "",
            'descripcion' => "",
            'cantidad' => "1",
            'precio' => 0.00
        ]);
    }


    public function render()
    {

        return view('livewire.admin.gerencia.recibos.create');
    }

    public function setSerieMount()
    {
        $serie = Series::where('tipo_comprobante_id', '11')->first();
        $this->serie = $serie->serie;
        $this->numero = $serie->correlativo + 1;
        $this->serie_numero = $this->serie . "-" . $this->numero;
    }

    public function updatedSerie($value)
    {
        $this->changeSerieUpdate($value);
    }

    public function updatedNumero($value)
    {

        $this->serie_numero = $this->serie . "-" . $this->numero;
    }

    public function changeSerieUpdate($serie)
    {

        if ($serie) {

            $serie = Series::where('serie', $serie)->first();
            $this->serie = $serie->serie;
            $this->numero = $serie->correlativo + 1;
            $this->serie_numero = $this->serie . "-" . $this->numero;
        } else {

            $this->reset('numero');
        }
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

            // $igv = round(round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2) * 18 / 100, 2);
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
            $this->reset('product_selected_id');

            //calcular los totales al añadir un producto
            $this->total = $this->calcularTotal();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                tittle: 'PRODUCTO AÑADIDO',
                mensaje: 'añadiste el producto ' . $this->selected->get('producto'),
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR EL AÑADIR',
                mensaje: $e->getMessage(),
            );
        }
    }
    function updatedProductSelectedId(Productos $producto)
    {

        $this->selected = collect([
            'producto_id' => $producto->id,
            'producto' => $producto->descripcion,
            'descripcion' => $producto->descripcion,
            'cantidad' => "1",
            'precio' => $producto->valor_unitario
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
        $request = new RecibosPagosRequest();
        $error = $this->validateOnly($name, $request->rules(), $request->messages());
    }

    public function save()
    {

        $request = new RecibosPagosRequest();
        $data = $this->validate($request->rules(), $request->messages());

        try {
            $recibo = RecibosPagosVarios::create($data);

            //CREAR ITEMS DE LA VENTA
            RecibosPagosVarios::createItems($recibo, $data["items"]);

            //ACTUALIZAR CORRELATIVO DE SERIE UTILIZADA
            $recibo->getSerie->increment('correlativo');
            return redirect()->route('admin.gerencia.recibos.index')->with('recibog-store', 'El Recibo se registro con exito');
        } catch (\Throwable $th) {

            $this->dispatch(
                'error',
                tittle: 'ERROR EN FUNCION: ',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
        $this->reCalTotal();
    }
}
