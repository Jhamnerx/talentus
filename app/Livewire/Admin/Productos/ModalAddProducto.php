<?php

namespace App\Livewire\Admin\Productos;

use App\Models\Empresa;
use App\Models\plantilla;
use Livewire\Component;
use App\Models\Productos;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;

class ModalAddProducto extends Component
{
    public plantilla $plantilla;
    public $showModal = false;

    public $divisa = "PEN";

    public $product_selected_id;
    public Collection $selected;
    public $tipo_afectacion = "10";

    public function mount(Productos $productos)
    {
        $this->plantilla = plantilla::first();

        $this->selected = collect([
            'producto_id' => "",
            'codigo' => "",
            'cantidad' => 1,
            'unit' => "NIU",
            'unit_name' => "UNIDAD",
            'descripcion' => "",
            'valor_unitario' => 0.00,
            'precio_unitario' => 0.00,
            'igv' => 0.00,
            'icbper' => 0.00,
            'total_icbper' => 0.00,
            'total' => 0.00,
            'porcentaje_igv' => 18,
            'codigo_afectacion' => $this->tipo_afectacion,
            'afecto_icbper' => false
        ]);
    }

    #[On('openModalAddProducto')]
    public function showModal()
    {

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function updatedProductos()
    {
    }

    public function render()
    {
        return view('livewire.admin.productos.modal-add-producto');
    }

    public function updated($name, $value)
    {
    }
    //BUSCAR PRODUCTO SELECCIONADO Y AÑADIRLO

    public function prueba()
    {
    }

    function updatedProductSelectedId($id)
    {

        $producto = Productos::find($id);

        $igv = $this->calcularIgvProducto($producto->valor_unitario);

        $this->selected->put('producto_id', $producto->id);
        $this->selected->put('codigo', $producto->codigo);
        $this->selected->put('unit', $producto->unit_code);
        $this->selected->put('unit_name', $producto->unit->descripcion);
        $this->selected->put('descripcion', $producto->descripcion);
        $this->selected->put('valor_unitario', round(floatval($producto->valor_unitario), 4));
        $this->selected->put('precio_unitario', round(floatval($this->calcularPrecioUnitario($producto->valor_unitario)), 4));
        //$this->selected->put('igv', round(floatval($igv_p), 4));
        $this->selected->put('icbper', ($producto->afecto_icbper) ? round(floatval($this->plantilla->icbper), 4) : 0.00);
        $this->selected->put('total_icbper', ($producto->afecto_icbper) ? round(floatval($this->plantilla->icbper) * floatval($this->selected["cantidad"]), 4) : 0.00);
        // $this->selected->put('total', round(floatval($producto->valor_unitario), 4) + round(floatval($igv_p), 4));
        $this->selected->put('codigo_afectacion', $this->tipo_afectacion);
        $this->selected->put('afecto_icbper', $producto->afecto_icbper);
        $this->calcularMontosProducto();
    }


    public function calcularPrecioUnitario($valor_unitario)
    {
        return ($valor_unitario * $this->plantilla->igv) + $valor_unitario;
    }

    public function calcularIgvProducto($valor_unitario)
    {

        $igv = 0.00;
        if ($this->tipo_afectacion == 10) {

            $sub_total = ($this->selected["valor_unitario"] * floatval($this->selected["cantidad"]));
            $igv = round($sub_total * $this->plantilla->igv, 4);
        } else {

            $sub_total = ($this->selected["valor_unitario"] * floatval($this->selected["cantidad"]));
            $igv = 0.00;
        }


        return $igv;
    }



    public function updatedTipoAfectacion($value)
    {

        $this->calcularMontosProducto();
        $this->selected["codigo_afectacion"] = $this->tipo_afectacion;
    }

    //CALCULAR SUB TOTAL DEL ITEM SELECCIONADO
    public function updatedSelected($value, $name)
    {

        if ($name == "cantidad" && $value == "") {

            $this->selected['cantidad'] = 0;
        }

        $this->calcularMontosProducto();
    }




    public function calcularMontosProducto()
    {

        $igv = 0.00;
        $sub_total = 0.00;
        $total_icbper = 0.00;
        $total = 0.00;

        if ($this->tipo_afectacion == 10) {

            $sub_total = ($this->selected["valor_unitario"] * floatval($this->selected["cantidad"]));
            $igv = round($sub_total * $this->plantilla->igv, 4);
            $total_icbper = ($this->selected['afecto_icbper']) ? floatval($this->selected["cantidad"] * floatval($this->plantilla->icbper)) : 0.00;
            $total = $sub_total + $igv;
        } else {

            $sub_total = ($this->selected["valor_unitario"] * floatval($this->selected["cantidad"]));
            $igv = 0.00;
            $total_icbper = ($this->selected['afecto_icbper']) ? floatval($this->selected["cantidad"] * floatval($this->plantilla->icbper)) : 0.00;
            $total = $sub_total + $igv;
        }

        $this->selected["igv"] = round($igv, 4);
        $this->selected["porcentaje_igv"] = ($this->tipo_afectacion == 10) ? $this->plantilla->igvbnormal : 0.00;
        $this->selected["total"] = ($this->selected["afecto_icbper"]) ? round($total + $total_icbper, 4) : round($total, 4);
        $this->selected["precio_unitario"] = ($this->selected["afecto_icbper"]) ? round(floatval($this->calcularPrecioUnitario($this->selected["valor_unitario"])), 4) : round(floatval($this->calcularPrecioUnitario($this->selected["valor_unitario"])), 4);
        $this->selected["total_icbper"] = $total_icbper;
    }

    #[On('reset-selected')]
    public function resetSelected()
    {
        $this->selected = collect([
            'producto_id' => "",
            'codigo' => "",
            'cantidad' => 1,
            'unit' => "NIU",
            'unit_name' => "UNIDAD",
            'descripcion' => "",
            'valor_unitario' => 0.00,
            'igv' => 0.00,
            'porcentaje_igv' => 0.00,
            'icbper' => 0.00,
            'total_icbper' => 0.00,
            'total' => 0.00,
            'codigo_afectacion' => $this->tipo_afectacion,
            'afecto_icbper' => false
        ]);
        $this->reset('product_selected_id', 'divisa');
    }

    public function addProducto()
    {


        $this->validate([
            'selected.producto_id' => 'required',
            'selected.codigo' => 'required',
            'selected.cantidad' => 'required|integer|min:1',
            'selected.unit' => 'required|exists:units,codigo',
            'selected.descripcion' => 'required',
            'selected.valor_unitario' => 'required|',
            'selected.igv' => 'required',
            'selected.icbper' => 'required',
            'selected.total' => 'required',

        ], [
            'selected.producto_id.required' => 'Seleccion una producto',
            'selected.codigo.required' => 'Seleccion una producto',
            'selected.cantidad.required' => 'Por favor ingresa una cantidad',
            'selected.cantidad.integer' => 'Debe ser un numero entero',
            'selected.cantidad.min' => 'La cantidad debe ser mayor a 1',
            'selected.unit.required' => 'Seleccion una producto',
            'selected.unit.exists' => 'Error no existe la unidad',
            'selected.descripcion.required' => 'Seleccion una producto',
            'selected.valor_unitario.required' => 'Valor unitario requerido',

            'selected.total.required' => 'Sub Total requerido',

        ]);

        $this->dispatch('add-producto', selected: $this->selected);

        $this->closeModal();
    }
}
