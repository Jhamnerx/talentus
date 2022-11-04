<?php

namespace App\Http\Livewire\Admin\Ventas\Presupuestos;

use App\Http\Controllers\Admin\PresupuestoController;
use Livewire\Component;
use App\Http\Controllers\Admin\UtilesController;
use App\Models\Productos;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $numero, $fecha, $fecha_caducidad, $divisa = 'PEN', $nota;

    public $tipoCambio = 0;
    public $producto;

    public Collection $items;

    public Collection $selected;
    public Collection $datos;


    public $sub_total = 0.00, $impuesto = 0.00, $total = 0.00;


    protected $messages = [
        'numero.required' => 'El número requerido',
        'numero.unique' => 'El número ya esta registrado',

    ];

    protected function rules()
    {
        return [

            'numero' => Rule::unique('presupuestos', 'numero')->where(fn ($query) => $query->where('empresa_id', session('empresa'))),
        ];
    }

    public function mount()
    {
        $this->tipoCambio  = UtilesController::tipoCambio();
        $this->numero = PresupuestoController::setNextSequenceNumber();
        $this->fecha = Carbon::now()->format('Y-m-d');
        $this->fecha_caducidad = Carbon::now()->addDays(15)->format('Y-m-d');
        $this->items = collect();
        $this->selected = collect([
            'producto_id' => "",
            'producto' => "",
            'descripcion' => "",
            'cantidad' => 1,
            'precio' => ""
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
            'selected.producto_id.required' => 'Seleccion un producto',
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
                'subtotal' => round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2),
            ]);

            $this->selected = collect();

            //calcular los totales al añadir un producto
            $this->sub_total = $this->calcularSubTotal();
            $this->impuesto = $this->calcularImpuesto();
            $this->total = $this->calcularTotal();
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

            $item["subtotal"] =  round(floatval($item["cantidad"]) *  floatval($item["precio"]), 2);

            return $item;
        });

        $this->sub_total = $this->calcularSubTotal();
        $this->impuesto = $this->calcularImpuesto();
        $this->total = $this->calcularTotal();
    }

    public function calcularSubTotal()
    {
        $sub_total = $this->items->map(function ($item, $key) {

            $sub_total = 0;
            $sub_total =  $sub_total + $item["subtotal"];

            return number_format($sub_total, 2);
        });

        return $sub_total->sum();
    }

    public function calcularImpuesto()
    {
        $impuesto = (floatval($this->sub_total) * 18) / 100;

        return number_format($impuesto, 2);
    }

    public function calcularTotal()
    {

        $total = $this->sub_total + $this->impuesto;

        return number_format($total, 2);
    }


    public function updatingSubTotal($name, $value)
    {
        dd($name, $value);
    }



    public function updated($name, $value)
    {
        //dd($name, $value);
        $error = $this->validateOnly($name);
    }
}
