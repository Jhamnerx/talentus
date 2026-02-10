<?php

namespace App\Livewire\Admin\Cobros;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DetalleCobros;
use App\Enums\CobroEstado;
use App\Enums\EstadoFacturacion;
use Livewire\Attributes\Url;

class Mensualidades extends Component
{
    use WithPagination;

    // Filtros
    #[Url(keep: true)]
    public$search = '';
    
    #[Url(keep: true)]
    public $filtroEstado = ''; // SIN_FACTURAR, FACTURADO, PAGADO, por_vencer, vencidos
    
    #[Url(keep: true)]
    public $filtroPeriodo = '';
    
    #[Url(keep: true)]
    public $filtroCliente = '';
    
    // Período de fechas
    public $fecha_desde = '';
    public $fecha_hasta = '';

    // Estadísticas
    public $stats = [
        'total' => 0,
        'sin_facturar' => 0,
        'facturados' => 0,
        'pagados' => 0,
        'por_vencer' => 0,
        'vencidos' => 0,
        'monto_pendiente' => 0,
        'monto_facturado_pendiente' => 0,
    ];

    public function mount()
    {
        // Fechas por defecto: mes actual
        $this->fecha_desde = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fecha_hasta = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $this->calcularEstadisticas();

        $query = DetalleCobros::query()
            ->with(['vehiculo', 'cobro.clientes', 'venta', 'recibo'])
            ->where('estado', true)
            ->where('estado_detalle', CobroEstado::ACTIVO);

        // Filtro por búsqueda (placa, cliente)
        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('vehiculo', function($vehiculo) {
                    $vehiculo->where('placa', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('cobro.clientes', function($cliente) {
                    $cliente->where('razon_social', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
                });
            });
        }

        // Filtro por estado de facturación
        if ($this->filtroEstado) {
            switch ($this->filtroEstado) {
                case 'SIN_FACTURAR':
                    $query->where('estado_facturacion', EstadoFacturacion::SIN_FACTURAR);
                    break;
                case 'FACTURADO':
                    $query->where('estado_facturacion', EstadoFacturacion::FACTURADO);
                    break;
                case 'PAGADO':
                    $query->where('estado_facturacion', EstadoFacturacion::PAGADO);
                    break;
                case 'por_vencer':
                    $hoy = Carbon::now();
                    $proximosDias = $hoy->copy()->addDays(7);
                    $query->whereBetween('fecha', [$hoy->format('Y-m-d'), $proximosDias->format('Y-m-d')])
                        ->where('estado_facturacion', EstadoFacturacion::SIN_FACTURAR);
                    break;
                case 'vencidos':
                    $query->where('fecha', '<', Carbon::now()->format('Y-m-d'))
                        ->where('estado_facturacion', EstadoFacturacion::SIN_FACTURAR);
                    break;
            }
        }

        // Filtro por período
        if ($this->filtroPeriodo) {
            $query->whereHas('cobro', function($cobro) {
                $cobro->where('periodo', $this->filtroPeriodo);
            });
        }

        // Filtro por rango de fechas de vencimiento
        if ($this->fecha_desde && $this->fecha_hasta) {
            $query->whereBetween('fecha', [$this->fecha_desde, $this->fecha_hasta]);
        }

        // Ordenar por fecha de vencimiento ascendente
        $query->orderBy('fecha', 'asc');

        $detalles = $query->paginate(20);

        return view('livewire.admin.cobros.mensualidades', [
            'detalles' => $detalles,
        ]);
    }

    private function calcularEstadisticas()
    {
        $query = DetalleCobros::query()
            ->where('estado', true)
            ->where('estado_detalle', CobroEstado::ACTIVO);

        // Aplicar mismo filtro de fechas
        if ($this->fecha_desde && $this->fecha_hasta) {
            $query->whereBetween('fecha', [$this->fecha_desde, $this->fecha_hasta]);
        }

        $this->stats['total'] = $query->count();
        
        $this->stats['sin_facturar'] = (clone $query)->where('estado_facturacion', EstadoFacturacion::SIN_FACTURAR)->count();
        $this->stats['facturados'] = (clone $query)->where('estado_facturacion', EstadoFacturacion::FACTURADO)->count();
        $this->stats['pagados'] = (clone $query)->where('estado_facturacion', EstadoFacturacion::PAGADO)->count();

        $hoy = Carbon::now();
        $proximosDias = $hoy->copy()->addDays(7);
        
        $this->stats['por_vencer'] = (clone $query)
            ->whereBetween('fecha', [$hoy->format('Y-m-d'), $proximosDias->format('Y-m-d')])
            ->where('estado_facturacion', EstadoFacturacion::SIN_FACTURAR)
            ->count();

        $this->stats['vencidos'] = (clone $query)
            ->where('fecha', '<', $hoy->format('Y-m-d'))
            ->where('estado_facturacion', EstadoFacturacion::SIN_FACTURAR)
            ->count();

        $this->stats['monto_pendiente'] = (clone $query)
            ->where('estado_facturacion', EstadoFacturacion::SIN_FACTURAR)
            ->sum('plan');

        $this->stats['monto_facturado_pendiente'] = (clone $query)
            ->where('estado_facturacion', EstadoFacturacion::FACTURADO)
            ->sum('plan');
    }

    public function limpiarFiltros()
    {
        $this->reset(['search', 'filtroEstado', 'filtroPeriodo', 'filtroCliente']);
        $this->fecha_desde = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fecha_hasta = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFiltroEstado()
    {
        $this->resetPage();
    }

    public function facturarContado($detalleId)
    {
        $this->dispatch('open-modal-facturar-cobrar', detalle: $detalleId, forma_pago: 'CONTADO');
    }

    public function facturarCredito($detalleId)
    {
        $this->dispatch('open-modal-facturar-cobrar', detalle: $detalleId, forma_pago: 'CRÉDITO');
    }

    public function registrarPago($detalleId)
    {
        $this->dispatch('open-modal-payment', detalle: $detalleId);
    }

    public function verDetalle($cobroId)
    {
        return redirect()->route('admin.cobros.show', $cobroId);
    }
}
