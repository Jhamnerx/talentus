<?php

namespace App\Livewire\Admin\Inicio;

use App\Enums\LineasStatus;
use App\Models\Lineas;
use App\Models\Payments;
use App\Models\Recibos;
use App\Models\Ventas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardReportes extends Component
{
    public string $fechaInicio = '';
    public string $fechaFin    = '';
    public string $periodo     = 'mensual'; // 'semanal' | 'mensual'

    protected $listeners = [
        'dashboard-filtro-actualizado' => 'actualizarFiltro',
    ];

    public function mount(): void
    {
        $this->fechaInicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fechaFin    = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function actualizarFiltro(string $fechaInicio, string $fechaFin): void
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin    = $fechaFin;
    }

    private function rangos(): array
    {
        $ahora    = Carbon::now();
        $semanaI  = $ahora->copy()->startOfWeek();
        $semanaF  = $ahora->copy()->endOfWeek();
        $mesI     = $ahora->copy()->startOfMonth();
        $mesF     = $ahora->copy()->endOfMonth();
        return compact('semanaI', 'semanaF', 'mesI', 'mesF');
    }

    public function render()
    {
        ['semanaI' => $semI, 'semanaF' => $semF, 'mesI' => $mesI, 'mesF' => $mesF] = $this->rangos();

        // Rango del datepicker (afecta la sección de pagados)
        $inicio = Carbon::parse($this->fechaInicio)->startOfDay();
        $fin    = Carbon::parse($this->fechaFin)->endOfDay();

        // ── Suspensiones (siempre semana/mes actuales) ──────────────────
        $suspensionesTotalSemana = Lineas::where('estado', LineasStatus::SUSPENDIDA)
            ->whereBetween('updated_at', [$semI, $semF])
            ->count();

        $suspensionesTotalMes = Lineas::where('estado', LineasStatus::SUSPENDIDA)
            ->whereBetween('updated_at', [$mesI, $mesF])
            ->count();

        $suspensionesDetallesMes = Lineas::where('estado', LineasStatus::SUSPENDIDA)
            ->whereBetween('updated_at', [$mesI, $mesF])
            ->with(['sim_card'])
            ->select('id', 'numero', 'operador', 'updated_at')
            ->limit(20)
            ->get();

        // ── Pagos por método/destino — rango del datepicker ─────────────
        // Consulta directa a Payments para evitar desfase fecha_emision vs fecha de pago
        $metodosFacturasMes = Payments::with(['paymentMethod', 'destination'])
            ->where('paymentable_type', Ventas::class)
            ->whereBetween('fecha', [$inicio, $fin])
            ->select(
                'payment_method_id',
                'destination_type',
                'destination_id',
                DB::raw('SUM(monto) as total'),
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('COUNT(DISTINCT paymentable_id) as documentos')
            )
            ->groupBy('payment_method_id', 'destination_type', 'destination_id')
            ->get();

        $totalFacturasMes  = $metodosFacturasMes->sum('total');
        $countFacturasMes  = $metodosFacturasMes->sum('documentos');

        $metodosRecibosMes = Payments::with(['paymentMethod', 'destination'])
            ->where('paymentable_type', Recibos::class)
            ->whereBetween('fecha', [$inicio, $fin])
            ->select(
                'payment_method_id',
                'destination_type',
                'destination_id',
                DB::raw('SUM(monto) as total'),
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('COUNT(DISTINCT paymentable_id) as documentos')
            )
            ->groupBy('payment_method_id', 'destination_type', 'destination_id')
            ->get();

        $totalRecibosMes  = $metodosRecibosMes->sum('total');
        $countRecibosMes  = $metodosRecibosMes->sum('documentos');

        // ── Por cobrar (totales agrupados por divisa) ───────────────────
        // Ventas: excluye las que tienen NC/ND (comprobantes.invoice_id) o baja SUNAT (envio_resumen_detalles.venta_id)
        $facturasPorCobrar = Ventas::where('pago_estado', Ventas::UNPAID)
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('comprobantes')
                    ->whereColumn('comprobantes.invoice_id', 'ventas.id');
            })
            ->whereDoesntHave('envioResumen')
            ->select('divisa', DB::raw('COUNT(*) as cantidad'), DB::raw('SUM(total) as monto_total'))
            ->groupBy('divisa')
            ->get()
            ->keyBy('divisa');

        // Recibos: SoftDeletes filtra automáticamente los eliminados
        $recibosPorCobrar = Recibos::where('pago_estado', Recibos::UNPAID)
            ->select('divisa', DB::raw('COUNT(*) as cantidad'), DB::raw('SUM(total) as monto_total'))
            ->groupBy('divisa')
            ->get()
            ->keyBy('divisa');

        return view('livewire.admin.inicio.dashboard-reportes', compact(
            'suspensionesTotalSemana',
            'suspensionesTotalMes',
            'suspensionesDetallesMes',
            'metodosFacturasMes',
            'totalFacturasMes',
            'countFacturasMes',
            'metodosRecibosMes',
            'totalRecibosMes',
            'countRecibosMes',
            'facturasPorCobrar',
            'recibosPorCobrar',
        ));
    }
}
