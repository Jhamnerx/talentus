<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facturas;
use App\Models\plantilla;
use Illuminate\Http\Request;

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

    public function getDataVentas()
    {
        ///$df = new DataFeed();


        return (object)[
            'labels' => [
                '12-01-2020',
                '01-01-2021',
                '02-01-2021'
            ],
            'data' =>[
                'facturas' =>[  
                    'totales' => [
                        1000,
                        900,
                        300
                    ],
                ],
                'recibos' =>[   
                    'totales' => [
                        800,
                        500,
                        100
                    ],
                ],
            ]

        ];
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
