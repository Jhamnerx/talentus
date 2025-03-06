<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use Carbon\Carbon;
use App\Models\Cobros;
use App\Models\Series;
use App\Models\Recibos;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\plantilla;
use App\Models\Productos;
use App\Models\DetalleCobros;
use Illuminate\Support\Collection;
use App\Http\Requests\RecibosRequest;

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


    //DETALLE DESDE COBRO
    public $detalle_ids;
    public $cobro_id;
    public $empresa_id;

    public function mount($detalle_ids = null, $cobro_id = null)
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

        $this->empresa_id = plantilla::first()->empresa->id;


        // Asignar cliente_id
        $cobro = Cobros::find($cobro_id);

        if ($cobro) {
            $this->cliente = Clientes::find($cobro->clientes_id);
            $this->clientes_id = $cobro->clientes_id;
        }

        // Procesar items si no son nulos
        if ($detalle_ids) {
            $this->procesarItems($detalle_ids);
        }
    }

    public function render()
    {

        return view('livewire.admin.ventas.recibos.create');
    }

    public function setSerieMount()
    {
        $serie = Series::where('tipo_comprobante_id', '10')->first();
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
    public function procesarItems($items)
    {
        $this->detalle_ids = $items;
        $detalles = DetalleCobros::whereIn('id', $items)->get();

        $detalles->each(function ($item) {
            $cantidad = $this->calcularCantidad($item->cobro->periodo);
            $valor_unitario = $item->cobro->producto->valor_unitario;

            $this->items->push([
                'producto_id' => $item->cobro->producto->id,
                'producto' => $item->cobro->producto->descripcion,
                'descripcion' => $item->cobro->descripcion,
                'cantidad' => $cantidad,
                'precio' => $valor_unitario,
                'total' => round((floatval($cantidad) * floatval($valor_unitario)), 2),
            ]);
        });

        $this->reCalTotal();
    }

    public function calcularCantidad($periodo)
    {
        switch ($periodo) {
            case 'MENSUAL':
                return 1;
            case 'BIMENSUAL':
                return 2;
            case 'TRIMESTRAL':
                return 3;
            case 'SEMESTRAL':
                return 6;
            case 'ANUAL':
                return 12;
            default:
                return 1;
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
                title: 'PRODUCTO AÑADIDO',
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
        $request = new RecibosRequest();
        $error = $this->validateOnly($name, $request->rules(), $request->messages());
    }

    public function save()
    {

        $request = new RecibosRequest();
        $data = $this->validate($request->rules(), $request->messages());

        $recibo = Recibos::create($data);

        Recibos::createItems($recibo, $data["items"]);

        //ACTUALIZAR CORRELATIVO DE SERIE UTILIZADA
        $recibo->getSerie->increment('correlativo');

        session()->flash('recibo-registrado', 'El Recibo se registro con exito');
        $this->redirectRoute('admin.ventas.recibos.index');
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
        $this->reCalTotal();
    }
    public function addProductoModal($producto)
    {
        $this->dispatch('add-producto-modal', producto: $producto);
    }
}
