<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facturas;
use App\Models\plantilla;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\UtilesController;
use App\Models\Recibos;
use Illuminate\Support\Arr;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $plantilla = plantilla::where('empresas_id', session('empresa'));

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

        //$labels = $this->getLabels(6);
        $labels = UtilesController::getLabels(6);

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


    public function getTotalesFacturas($nMeses = 1, $divisa = "usd")
    {

        $totales = [];

        for ($i = 0; $i < $nMeses; $i++) {

            $total  = Facturas::whereMonth('created_at', Carbon::now()->subMonth($i)->format('m'))->Where('divisa', $divisa)->sum('total');

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




    public function getDataFeed()
    {

        Facturas::whereMonth('created_at', '08')->get();



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
