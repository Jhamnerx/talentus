<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\Cobros;
use App\Models\PeriodoCobro;
use Livewire\Component;
use Livewire\WithPagination;

class VerPeriodos extends Component
{
    use WithPagination;

    public bool $modalOpen = false;
    public ?int $cobro_id  = null;

    protected $listeners = [
        'abrirVerPeriodos' => 'abrir',
    ];

    public function abrir(int $cobroId): void
    {
        $this->cobro_id  = $cobroId;
        $this->resetPage();
        $this->modalOpen = true;
    }

    public function generarDocumento(int $periodoId): void
    {
        $periodo = PeriodoCobro::with(['cobro.clientes'])->find($periodoId);
        if (!$periodo) {
            return;
        }

        $cobro          = $periodo->cobro;
        $tipo           = $cobro->tipo_pago ?? 'FACTURA';
        $cliente        = $cobro->clientes;
        $periodoIdsJson = json_encode([$periodoId]);

        session(['cobro_redirect_back' => route('admin.cobros.index')]);

        if ($tipo === 'RECIBO') {
            $this->redirect(route('admin.ventas.recibos.create', ['periodo_ids' => $periodoIdsJson]), navigate: true);
            return;
        }

        if (($cliente?->tipo_documento_id ?? null) == 6) {
            $this->redirect(route('admin.factura.create', ['periodo_ids' => $periodoIdsJson]), navigate: true);
            return;
        }

        $this->redirect(route('admin.boleta.create', ['periodo_ids' => $periodoIdsJson]), navigate: true);
    }

    public function render()
    {
        $cobro = $this->cobro_id
            ? Cobros::with(['vehiculo', 'clientes', 'plan'])->find($this->cobro_id)
            : null;

        $periodos = $this->cobro_id
            ? PeriodoCobro::with(['venta', 'recibo'])
            ->where('cobros_id', $this->cobro_id)
            ->orderByDesc('fecha_inicio')
            ->paginate(6)
            : null;

        return view('livewire.admin.cobros.ver-periodos', compact('cobro', 'periodos'));
    }
}
