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

        // ── 3. Suspensiones de líneas ───────────────────────────────────
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

        // ── 4. Total ventas facturadas ──────────────────────────────────
        // (los totales semanales/mensuales se muestran ahora vía chart-facturadas)

        // ── 5. Facturas y recibos PAGADOS ───────────────────────────────
        $facturasPagadasSemana = Ventas::with(['payments.paymentMethod', 'cliente:id,razon_social', 'metodoPago'])
            ->where('pago_estado', Ventas::PAID)
            ->whereBetween('fecha_emision', [$semI, $semF])
            ->get();

        $facturasPagadasMes = Ventas::with(['payments.paymentMethod', 'cliente:id,razon_social', 'metodoPago'])
            ->where('pago_estado', Ventas::PAID)
            ->whereBetween('fecha_emision', [$mesI, $mesF])
            ->get();

        $recibosPagadosSemana = Recibos::with(['payments.paymentMethod', 'clientes:id,razon_social'])
            ->where('pago_estado', Recibos::PAID)
            ->whereBetween('fecha_emision', [$semI, $semF])
            ->whereNull('deleted_at')
            ->get();

        $recibosPagadosMes = Recibos::with(['payments.paymentMethod', 'clientes:id,razon_social'])
            ->where('pago_estado', Recibos::PAID)
            ->whereBetween('fecha_emision', [$mesI, $mesF])
            ->whereNull('deleted_at')
            ->get();

        $metodosFacturasMes = Payments::with('paymentMethod')
            ->whereHasMorph('paymentable', [Ventas::class])
            ->whereBetween('fecha', [$mesI, $mesF])
            ->whereNull('deleted_at')
            ->select('payment_method_id', DB::raw('SUM(monto) as total'), DB::raw('COUNT(*) as cantidad'))
            ->groupBy('payment_method_id')
            ->get();

        $metodosRecibosMes = Payments::with('paymentMethod')
            ->whereHasMorph('paymentable', [Recibos::class])
            ->whereBetween('fecha', [$mesI, $mesF])
            ->whereNull('deleted_at')
            ->select('payment_method_id', DB::raw('SUM(monto) as total'), DB::raw('COUNT(*) as cantidad'))
            ->groupBy('payment_method_id')
            ->get();

        // ── 6. Por cobrar ───────────────────────────────────────────────
        $facturasPorCobrar = Ventas::with('cliente:id,razon_social')
            ->where('pago_estado', Ventas::UNPAID)
            ->whereNotNull('fecha_vencimiento')
            ->orderBy('fecha_vencimiento')
            ->select('id', 'serie', 'correlativo', 'total', 'divisa', 'fecha_emision', 'fecha_vencimiento', 'cliente_id')
            ->limit(30)
            ->get()
            ->map(function ($v) {
                $v->dias_vencimiento = Carbon::now()->diffInDays($v->fecha_vencimiento, false);
                return $v;
            });

        $recibosPorCobrar = Recibos::with('cliente:id,razon_social')
            ->where('pago_estado', Recibos::UNPAID)
            ->whereNull('deleted_at')
            ->orderBy('fecha_emision')
            ->select('id', 'serie', 'numero', 'total', 'divisa', 'fecha_emision', 'clientes_id')
            ->limit(30)
            ->get();

        return view('livewire.admin.inicio.dashboard-reportes', compact(
            'suspensionesTotalSemana',
            'suspensionesTotalMes',
            'suspensionesDetallesMes',
            'facturasPagadasSemana',
            'facturasPagadasMes',
            'recibosPagadosSemana',
            'recibosPagadosMes',
            'metodosFacturasMes',
            'metodosRecibosMes',
            'facturasPorCobrar',
            'recibosPorCobrar',
        ));
    }
}
