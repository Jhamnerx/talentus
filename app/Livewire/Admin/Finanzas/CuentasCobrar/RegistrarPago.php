<?php

namespace App\Livewire\Admin\Finanzas\CuentasCobrar;

use Livewire\Component;
use App\Models\AccountReceivable;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class RegistrarPago extends Component
{
    use WireUiActions;

    public $showModal = false;
    public $cuenta_id;
    public $cuenta;
    public $monto_pago;
    public $metodo_pago = 'EFECTIVO';
    public $fecha_pago;
    public $referencia;

    public function mount()
    {
        $this->fecha_pago = date('Y-m-d');
    }

    #[On('registrar-pago')]
    public function open($id)
    {
        $this->cuenta_id = $id;
        $this->cuenta = AccountReceivable::findOrFail($id);
        $this->monto_pago = $this->cuenta->saldo_pendiente;
        $this->showModal = true;
    }

    public function registrar()
    {
        $this->validate([
            'monto_pago' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $this->cuenta->saldo_pendiente
            ],
            'metodo_pago' => 'required|string',
            'fecha_pago' => 'required|date',
        ], [
            'monto_pago.required' => 'El monto es obligatorio',
            'monto_pago.min' => 'El monto debe ser mayor a 0',
            'monto_pago.max' => 'El monto no puede exceder el saldo pendiente',
            'metodo_pago.required' => 'Seleccione un método de pago',
            'fecha_pago.required' => 'La fecha es obligatoria',
        ]);

        // Actualizar montos
        $this->cuenta->monto_pagado += $this->monto_pago;
        $this->cuenta->saldo_pendiente -= $this->monto_pago;

        // Actualizar estado
        if ($this->cuenta->saldo_pendiente <= 0) {
            $this->cuenta->estado = \App\Enums\PaymentStatus::PAGADO;
        } else {
            $this->cuenta->estado = \App\Enums\PaymentStatus::PARCIAL;
        }

        $this->cuenta->save();

        $this->notification()->success(
            title: 'Pago Registrado',
            description: 'El pago de S/ ' . number_format($this->monto_pago, 2) . ' ha sido registrado correctamente'
        );

        $this->dispatch('render')->to(Index::class);
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['cuenta_id', 'cuenta', 'monto_pago', 'metodo_pago', 'fecha_pago', 'referencia']);
    }

    public function render()
    {
        return view('livewire.admin.finanzas.cuentas-cobrar.registrar-pago');
    }
}
