<?php

namespace App\Livewire\Admin\Facturacion\Ventas;

use App\Models\CodigosDetracciones;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalDetraccion extends Component
{
    public $openModalDetraccion = false;

    public $codigo_detraccion, $porcentaje = 0.00, $monto, $metodo_pago_id = '001', $cuenta_bancaria;
    public $total_venta = 0.00, $divisa = 'PEN';
    public $tipo_cambio = 0.00;

    public function render()
    {
        return view('livewire.admin.facturacion.ventas.modal-detraccion');
    }

    public function setDatos()
    {

        $datos = $this->validate(
            [
                'codigo_detraccion' => 'required',
                'porcentaje' => 'required|decimal:0,2',
                'monto' => 'required|decimal:0,2',
                'metodo_pago_id' => 'required',
                'total_venta' => 'required',
                'cuenta_bancaria' => 'required|alpha_num',
            ],
            [
                'codigo_detraccion.required' => 'El código detracción es obligatorio',
                'porcentaje.required' => 'El porcentaje es obligatorio',
                'porcentaje.decimal' => 'El porcentaje debe ser un número decimal',
                'monto.required' => 'El monto es obligatorio',
                'monto.decimal' => 'El monto debe ser un número decimal',
                'metodo_pago_id.required' => 'El método de pago es obligatorio',
                'cuenta_bancaria.required' => 'El cuenta bancaria es obligatorio',
                'cuenta_bancaria.alpha_num' => 'El cuenta bancaria debe ser alfanumérico',
            ]
        );

        $this->dispatch('set-datos-detraccion', ['datos' => $datos]);
        $this->closeModal();
    }

    #[On('open-modal-detraccion')]
    public function openModal($total, $divisa, $tipo_cambio)
    {
        $this->openModalDetraccion = true;
        $this->total_venta = $total;
        $this->divisa = $divisa;
        $this->tipo_cambio = $tipo_cambio;

        if ($this->codigo_detraccion) {
            $dt = CodigosDetracciones::where('codigo', $this->codigo_detraccion)->first();
            $this->porcentaje = $dt->porcentaje;
            $this->calcularMonto($this->porcentaje);
        }
    }

    public function closeModal()
    {
        $this->openModalDetraccion = false;
    }

    public function updatedCodigoDetraccion($value)
    {

        if ($value) {
            $dt = CodigosDetracciones::where('codigo', $this->codigo_detraccion)->first();

            $this->porcentaje = $dt->porcentaje;
            $this->calcularMonto($this->porcentaje);
        }
    }

    public function calcularMonto($porcentaje)
    {
        if ($this->divisa == 'USD') {
            $this->monto = round(floatval(floatval($this->total_venta) * floatval($porcentaje) / 100) * floatval($this->tipo_cambio), 2);
        } else {
            $this->monto = round(floatval(floatval($this->total_venta) * floatval($porcentaje) / 100), 2);
        }
    }
}
