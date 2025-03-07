<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\Cobros;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\DetalleCobros;

class Show extends Component
{
    public Cobros $cobro;
    public $detalleIds = [];

    public function mount(Cobros $cobro)
    {
        $this->cobro = $cobro;
    }

    public function render()
    {
        return view('livewire.admin.cobros.show');
    }

    public function openModalPayment(DetalleCobros $detalle)
    {
        $this->dispatch('open-modal-payment', detalle: $detalle);
    }

    #[On('update-cobros')]
    public function r()
    {
        $this->render();
    }


    public function createBoleta(array $detalleIds)
    {
        return redirect()->route('admin.boleta.create', ['detalle_ids' => json_encode($detalleIds), 'cobro_id' => $this->cobro->id]);
    }
    public function createFactura(array $detalleIds)
    {
        return redirect()->route('admin.factura.create', ['detalle_ids' => json_encode($detalleIds), 'cobro_id' => $this->cobro->id]);
    }
    public function createRecibo(array $detalleIds)
    {
        return redirect()->route('admin.ventas.recibos.create', ['detalle_ids' => json_encode($detalleIds), 'cobro_id' => $this->cobro->id]);
    }

    public function createBoletaGeneral()
    {
        return redirect()->route('admin.boleta.create', ['detalle_ids' => json_encode($this->detalleIds), 'cobro_id' => $this->cobro->id]);
    }
    public function createFacturaGeneral()
    {
        return redirect()->route('admin.factura.create', ['detalle_ids' => json_encode($this->detalleIds), 'cobro_id' => $this->cobro->id]);
    }
    public function createReciboGeneral()
    {
        return redirect()->route('admin.ventas.recibos.create', ['detalle_ids' => json_encode($this->detalleIds), 'cobro_id' => $this->cobro->id]);
    }
}
