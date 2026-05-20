<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetalleRecibos;
use App\Models\Facturas;
use App\Models\VentasDetalle;
use App\Models\plantilla;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Recibos;
use App\Models\Ventas;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $plantilla = plantilla::where('empresa_id', session('empresa'));

        if (!$request->session()->has('empresa')) {

            //$request->session('empresa', '1');
            $request->session()->put('empresa', 1);
            //return $request->session()->all();
        }
        //$request->session()->pull('empresa', '1');

        return view('admin.index', compact('plantilla'));
    }


    public function getDataVentas(Request $request)
    {
        // dd($request->all());
        ///$df = new DataFeed();
        // Facturas::

        $fecha = Carbon::now();

        $labels = $this->getLabels(6);

        $total_facturas = $this->getTotalesFacturas(6, $request->divisa);
        $total_recibos = $this->getTotalesRecibos(6, $request->divisa);

        return (object)[

            'labels' => $labels,

            'data' => [
                'facturas' => [

                    'totales' => $total_facturas,

                ],
                'recibos' => [
                    'totales' => $total_recibos,
                ],
            ]

        ];
    }

    /**
     * Genera un array de labels con fechas en formato m-d-Y
     * retrocediendo desde el mes actual
     * 
     * @param int $months Número de meses a generar
     * @return array
     */
    private function getLabels($months = 1)
    {
        $labels = [];
        for ($i = 0; $i < $months; $i++) {
            array_push(
                $labels,
                Carbon::now()->startOfMonth()->subMonth($i)->format('m-d-Y')
            );
        }

        return $labels;
    }


    public function getTotalesFacturas($nMeses = 1, $divisa = "usd")
    {

        $totales = [];

        for ($i = 0; $i < $nMeses; $i++) {

            $total  = Ventas::whereMonth('created_at', Carbon::now()->subMonth($i)->format('m'))->Where('divisa', $divisa)->sum('total');

            array_push(
                $totales,
                floatval($total)
            );
        }

        return $totales;
    }

    public function getTotalesRecibos($nMeses = 1, $divisa = "usd")
    {

        $totales = [];

        for ($i = 0; $i < $nMeses; $i++) {

            //array_push($totales, Carbon::now()->subMonth($i)->format('m'));
            $total  = Recibos::whereMonth('created_at', Carbon::now()->subMonth($i)->format('m'))->where('estado', \App\Models\Recibos::COMPLETADO)->Where('divisa', $divisa)->sum('total');
            array_push(
                $totales,
                floatval($total)

            );
        }

        return $totales;
    }



    /**
     * Obtiene datos de períodos de cobro para gráficos del dashboard
     *
     * @return object
     */
    public function getDataNotificacionesCobro()
    {
        $periodos = \App\Models\PeriodoCobro::query()
            ->selectRaw('DATE(fecha_fin) as fecha, COUNT(*) as total, estado')
            ->whereBetween('fecha_fin', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->addMonth()->endOfMonth()
            ])
            ->groupBy('fecha', 'estado')
            ->orderBy('fecha')
            ->get();

        $estadisticas = [
            'pendientes'       => \App\Models\PeriodoCobro::where('estado', 'PENDIENTE')->count(),
            'vencidos'         => \App\Models\PeriodoCobro::where('estado', 'PENDIENTE')->where('fecha_fin', '<', Carbon::today())->count(),
            'hoy'              => \App\Models\PeriodoCobro::whereDate('fecha_fin', Carbon::today())->count(),
            'proximos_7_dias'  => \App\Models\PeriodoCobro::where('estado', 'PENDIENTE')->whereBetween('fecha_fin', [Carbon::today(), Carbon::today()->addDays(7)])->count(),
            'monto_pendiente'  => \App\Models\PeriodoCobro::where('estado', 'PENDIENTE')->sum('monto'),
        ];

        $topClientes = \App\Models\PeriodoCobro::query()
            ->select('cliente_id')
            ->selectRaw('COUNT(*) as total_notificaciones')
            ->selectRaw('SUM(monto) as monto_total')
            ->with('cliente:id,razon_social')
            ->where('estado', 'PENDIENTE')
            ->groupBy('cliente_id')
            ->orderByDesc('monto_total')
            ->limit(10)
            ->get();

        $porEstado = \App\Models\PeriodoCobro::query()
            ->selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->get();

        return (object) [
            'notificaciones_por_fecha' => $periodos,
            'estadisticas'             => $estadisticas,
            'top_clientes'             => $topClientes,
            'por_estado'               => $porEstado,
        ];
    }

    /**
     * Obtiene períodos de cobro vencidos hoy para alertas del dashboard
     *
     * @return \Illuminate\Support\Collection
     */
    public function getNotificacionesVencidasHoy()
    {
        return \App\Models\PeriodoCobro::query()
            ->with(['cliente:id,razon_social', 'vehiculo:id,placa', 'detalleCobro'])
            ->whereDate('fecha_fin', Carbon::today())
            ->where('estado', 'PENDIENTE')
            ->orderBy('monto', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Endpoint JSON para los gráficos de barras del Dashboard Reportes.
     * GET /dashboard/chart-ventas?tipo=gps|monitoreo
     *
     * Usa whereHas (sin joins explícitos) para aprovechar EmpresaScope y SoftDeletes
     * de los modelos padre. Suma el total del detalle (no del comprobante padre)
     * para que una venta con items mixtos GPS/monitoreo solo cuente lo que corresponde.
     */
    public function getChartVentas(Request $request)
    {
        Carbon::setLocale('es');

        $tipo = $request->query('tipo', 'gps');

        $meses6      = collect(range(5, 0))->map(fn($i) => Carbon::now()->subMonths($i)->startOfMonth());
        $chartInicio = $meses6->first();
        $chartFin    = Carbon::now()->endOfMonth();

        $labels        = $meses6->map(fn($m) => ucfirst($m->isoFormat('MMM YY')))->toArray();
        $columnaFiltro = $tipo === 'gps' ? 'es_dispositivo' : 'es_servicio_cobro';

        // ── VentasDetalle ───────────────────────────────────────────────
        // whereHas('venta') aplica EmpresaScope de Ventas automáticamente
        $ventasDetalles = VentasDetalle::whereHas('producto', fn($q) => $q->where($columnaFiltro, 1))
            ->whereHas('venta', fn($q) => $q->whereBetween('fecha_emision', [$chartInicio, $chartFin]))
            ->with('venta:id,fecha_emision,divisa')
            ->get();

        // ── DetalleRecibos ──────────────────────────────────────────────
        // whereHas('recibos') aplica EmpresaScope + SoftDeletes de Recibos automáticamente
        $recibosDetalles = DetalleRecibos::whereHas('producto', fn($q) => $q->where($columnaFiltro, 1))
            ->whereHas('recibos', fn($q) => $q->whereBetween('fecha_emision', [$chartInicio, $chartFin])->where('estado', \App\Models\Recibos::COMPLETADO))
            ->with('recibos:id,fecha_emision,divisa')
            ->get();

        // ── Agrupar en PHP por divisa y mes ─────────────────────────────
        $agrupar = fn($detalles, $parentRel, $fechaField = 'fecha_emision') =>
        $detalles->groupBy(fn($d) => $d->{$parentRel}?->divisa ?? 'PEN')
            ->map(
                fn($items) =>
                $items->groupBy(fn($d) => optional($d->{$parentRel}?->{$fechaField})->format('Y-m'))
                    ->map(fn($g) => round($g->sum('total'), 2))
            );

        // Closure para contar unidades vendidas (campo 'cantidad')
        $agruparCount = fn($detalles, $parentRel, $fechaField = 'fecha_emision') =>
        $detalles->groupBy(fn($d) => $d->{$parentRel}?->divisa ?? 'PEN')
            ->map(
                fn($items) =>
                $items->groupBy(fn($d) => optional($d->{$parentRel}?->{$fechaField})->format('Y-m'))
                    ->map(fn($g) => (int) $g->sum('cantidad'))
            );

        $agrupVentas  = $agrupar($ventasDetalles,  'venta');
        $agrupRecibos = $agrupar($recibosDetalles, 'recibos');
        $countVentas  = $agruparCount($ventasDetalles,  'venta');
        $countRecibos = $agruparCount($recibosDetalles, 'recibos');

        // ── Rellenar los 6 meses por divisa, combinando ambas fuentes ───
        $fillMeses = fn($divisa) => $meses6->map(function ($m) use ($agrupVentas, $agrupRecibos, $divisa) {
            $key = $m->format('Y-m');
            $v   = $agrupVentas[$divisa][$key]   ?? 0;
            $r   = $agrupRecibos[$divisa][$key]  ?? 0;
            return round((float) $v + (float) $r, 2);
        })->values()->toArray();

        $fillCount = fn($divisa) => $meses6->map(function ($m) use ($countVentas, $countRecibos, $divisa) {
            $key = $m->format('Y-m');
            return (int) (($countVentas[$divisa][$key] ?? 0) + ($countRecibos[$divisa][$key] ?? 0));
        })->values()->toArray();

        return response()->json([
            'labels'   => $labels,
            'dataPEN'  => $fillMeses('PEN'),
            'dataUSD'  => $fillMeses('USD'),
            'countPEN' => $fillCount('PEN'),
            'countUSD' => $fillCount('USD'),
        ]);
    }

    /**
     * Endpoint JSON para el gráfico de Ventas Facturadas (Ventas + Recibos pagados).
     * GET /dashboard/chart-facturadas
     *
     * Ventas: pago_estado=PAID, sin nota de crédito, sin baja.
     * Recibos: estado=COMPLETADO + pago_estado=PAID.
     * Separado por divisa (PEN / USD) y fuente (ventas / recibos).
     */
    public function getChartFacturadas(Request $request)
    {
        Carbon::setLocale('es');

        $meses6      = collect(range(5, 0))->map(fn($i) => Carbon::now()->subMonths($i)->startOfMonth());
        $chartInicio = $meses6->first();
        $chartFin    = Carbon::now()->endOfMonth();
        $labels      = $meses6->map(fn($m) => ucfirst($m->isoFormat('MMM YY')))->toArray();

        // ── Ventas pagadas, sin nota de crédito y sin baja ──────────────
        $ventas = Ventas::whereBetween('fecha_emision', [$chartInicio, $chartFin])
            ->where('pago_estado', Ventas::PAID)
            ->whereNull('nota_credito_id')
            ->whereNull('id_baja')
            ->get(['fecha_emision', 'total', 'divisa']);

        // ── Recibos: estado COMPLETADO + pago_estado PAID ───────────────
        $recibos = Recibos::whereBetween('fecha_emision', [$chartInicio, $chartFin])
            ->where('estado', Recibos::COMPLETADO)
            ->where('pago_estado', Recibos::PAID)
            ->get(['fecha_emision', 'total', 'divisa']);

        // ── Agrupar en PHP por divisa y mes ─────────────────────────────
        $agrupar = fn($collection) =>
        $collection->groupBy(fn($r) => $r->divisa ?? 'PEN')
            ->map(
                fn($items) =>
                $items->groupBy(fn($r) => optional($r->fecha_emision)->format('Y-m'))
                    ->map(fn($g) => round($g->sum('total'), 2))
            );

        $agrupVentas  = $agrupar($ventas);
        $agrupRecibos = $agrupar($recibos);

        $fill = fn($agrup, $divisa) => $meses6->map(function ($m) use ($agrup, $divisa) {
            return round((float) ($agrup[$divisa][$m->format('Y-m')] ?? 0), 2);
        })->values()->toArray();

        return response()->json([
            'labels'      => $labels,
            'ventasPEN'   => $fill($agrupVentas,  'PEN'),
            'ventasUSD'   => $fill($agrupVentas,  'USD'),
            'recibosPEN'  => $fill($agrupRecibos, 'PEN'),
            'recibosUSD'  => $fill($agrupRecibos, 'USD'),
        ]);
    }

    public function getDataFeed()
    {

        Ventas::whereMonth('created_at', '08')->get();



        // $query = $this->where('data_type', $dataType)
        //     ->where(function($q) use ($field){
        //         if ('label' == $field) {
        //             $q->whereNotNull('label');
        //         }
        //     })->pluck($field)
        //     ->toArray();

        // if (null !== $limit) {
        //     return array_slice($query, 0, $limit);
        // }

        //return $query;
    }
}
