<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facturas;
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
            $total  = Recibos::whereMonth('created_at', Carbon::now()->subMonth($i)->format('m'))->Where('divisa', $divisa)->sum('total');
            array_push(
                $totales,
                floatval($total)

            );
        }

        return $totales;
    }



    /**
     * Obtiene datos de notificaciones de cobro para gr\u00e1ficos del dashboard
     * 
     * @return object
     */
    public function getDataNotificacionesCobro()
    {
        $notificaciones = \App\Models\NotificacionCobro::query()
            ->selectRaw('DATE(fecha_vencimiento) as fecha, COUNT(*) as total, estado')
            ->whereBetween('fecha_vencimiento', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->addMonth()->endOfMonth()
            ])
            ->groupBy('fecha', 'estado')
            ->orderBy('fecha')
            ->get();

        $estadisticas = [
            'pendientes' => \App\Models\NotificacionCobro::pendientes()->count(),
            'vencidos' => \App\Models\NotificacionCobro::vencidos()->count(),
            'hoy' => \App\Models\NotificacionCobro::whereDate('fecha_vencimiento', Carbon::today())->count(),
            'proximos_7_dias' => \App\Models\NotificacionCobro::porVencer(7)->count(),
            'monto_pendiente' => \App\Models\NotificacionCobro::pendientes()->sum('monto'),
        ];

        $topClientes = \App\Models\NotificacionCobro::query()
            ->select('cliente_id')
            ->selectRaw('COUNT(*) as total_notificaciones')
            ->selectRaw('SUM(monto) as monto_total')
            ->with('cliente:id,razon_social')
            ->where('estado', 'PENDIENTE')
            ->groupBy('cliente_id')
            ->orderByDesc('monto_total')
            ->limit(10)
            ->get();

        $porEstado = \App\Models\NotificacionCobro::query()
            ->selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->get();

        return (object) [
            'notificaciones_por_fecha' => $notificaciones,
            'estadisticas' => $estadisticas,
            'top_clientes' => $topClientes,
            'por_estado' => $porEstado,
        ];
    }

    /**
     * Obtiene notificaciones de cobro vencidas hoy para alertas del dashboard
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getNotificacionesVencidasHoy()
    {
        return \App\Models\NotificacionCobro::query()
            ->with(['cliente:id,razon_social', 'vehiculo:id,placa', 'detalleCobro'])
            ->whereDate('fecha_vencimiento', Carbon::today())
            ->where('estado', 'PENDIENTE')
            ->orderBy('monto', 'desc')
            ->limit(5)
            ->get();
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
