<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\UtilesController;
use App\Models\Ciudades;
use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Dispositivos;
use App\Models\Facturas;
use App\Models\Flotas;
use App\Models\Lineas;
use App\Models\Productos;
use App\Models\Proveedores;
use App\Models\SimCard;
use App\Models\Vehiculos;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Arr;

class SearchController extends Controller
{
    // buscar clientes por nombre
    public function clientes(Request $request)
    {


        // $data = [];
        // $arrays = [
        //     "warehouse_id" => [
        //         0 => "7",
        //         2 => "7",
        //         3 => "7",
        //         4 => "7",
        //         5 => "7",
        //         6 => "7",
        //     ],
        //     "detalle_servicio" => [
        //         0 => "Valida 1",
        //         2 => "Valida 2",
        //         3 => "Valida 3",
        //         4 => "Valida 4",
        //         5 => "Valida 5",
        //         6 => "Valida 6",
        //     ],
        //     "valor" => [
        //         0 => "10",
        //         2 => "20",
        //         3 => "30",
        //         4 => "40",
        //         5 => "50",
        //         6 => "60",
        //     ]
        // ];
        // for ($i = 0; $i < count($arrays["warehouse_id"]) + 1; $i++) {
        //     if (array_key_exists($i, $arrays["warehouse_id"])) {
        //         $data[] = [
        //             'warehouse_id' => $arrays["warehouse_id"][$i],
        //             'detalle_servicio' => $arrays["detalle_servicio"][$i],
        //             'valor' => $arrays["valor"][$i]
        //         ];
        //     }
        // }
        // return $data;



        // return $array;

        $term = $request->get('term');
        $querys = Clientes::where('razon_social', 'LIKE', '%' . $term . '%')->orderBy('id', 'desc')->get();

        $data = [];

        foreach ($querys as $query) {
            $data[] = [
                'value' => $query->razon_social,
                'data' => $query->id,
                'flotas' => $query->flotas,

            ];
        }

        return array("suggestions" => $data);
    }

    //buscar cliente por id
    public function cliente(Request $request)
    {

        $query = Clientes::where('id', $request->proveedor)->first();


        $data = [];
        if ($query) {

            $data = array(
                'razon_social' => $query->razon_social,
                'id' => $query->id,
            );
        }



        return $data;
    }

    //buscar proveedores por razon social
    public function proveedores(Request $request)
    {

        $term = $request->get('term');
        $querys = Proveedores::where('razon_social', 'LIKE', '%' . $term . '%')->orderBy('id', 'desc')->get();

        $data = [];

        foreach ($querys as $query) {
            $data[] = [
                'value' => $query->razon_social,
                'data' => $query->id,

            ];
        }

        // return array("suggestions" => $data);
        return array("suggestions" => $data);
    }

    public function proveedor(Request $request)
    {

        $query = Proveedores::where('id', $request->proveedor)->first();


        $data = [];
        if ($query) {

            $data = array(
                'razon_social' => $query->razon_social,
                'id' => $query->id,
            );
        }



        return $data;
    }


    public function flotas(Request $request)
    {

        $term = $request->get('term');
        $querys = Flotas::where('nombre', 'LIKE', '%' . $term . '%')->active()->orderBy('id', 'desc')->get();

        $data = [];

        foreach ($querys as $query) {
            $data[] = [
                'value' => $query->id,
                'data' => $query->nombre,
                'cliente' => $query->clientes,

            ];
        }

        // return array("suggestions" => $data);
        return array("suggestions" => $data);
    }
    public function flota(Request $request)
    {

        $term = $request->get('term');
        $query = Flotas::where('id', $term)->first();



        // return array("suggestions" => $data);
        return $query;
    }

    public function busqueda(Request $request)
    {

        $query = $request->get('query');
        $querys = Clientes::where('razon_social', 'LIKE', '%' . $query . '%')->get();

        $clientes = [];
        $data = [];

        $data['emptyOptionsMessage'] = 'No hay coincidencias.';
        $data['name'] = 'country';
        $data['placeholder'] = 'Selecciona un cliente';


        foreach ($querys as $query) {

            $clientes[$query->id] = $query->razon_social;
        }

        $data['data'] = $clientes;

        return $data;
    }


    public function sim_card(Request $request)
    {

        $term = $request->get('term');

        $sims = SimCard::where('sim_card', 'LIKE', '%' . $term . '%')->orderBy('id', 'desc')->get();
        //$sim = sim::all();

        $data = [];

        foreach ($sims as $sim) {
            $data[] = [
                'value' => $sim->sim_card,
                'data' => $sim->id,

            ];
        }


        return array("suggestions" => $data);
    }

    public function lineas(Request $request)
    {

        $term = $request->get('term');

        $lineas = Lineas::where('numero', 'LIKE', '%' . $term . '%')->orderBy('id', 'desc')->get();
        //$lineas = Lineas::all();

        $data = [];

        foreach ($lineas as $linea) {

            if ($linea->sim) {
                $sim_card = $linea->sim->sim_card;
                $sim_card_id = $linea->sim->id;
            } else {
                $sim_card = null;
                $sim_card_id = null;
            }

            if ($linea->sim) {
                $operador = $linea->sim->operador;
            } else {
                $operador = null;
            }

            $data[] = [
                'value' => $linea->numero,
                'data' => $linea->id,
                'sim_card' => $sim_card,
                'sim_card_id' => $sim_card_id,
                'operador' => $operador,
            ];
        }


        return array("suggestions" => $data);
    }

    public function dispositivos(Request $request)
    {

        $term = $request->get('term');

        $dipositivos = Dispositivos::where('imei', 'LIKE', '%' . $term . '%')->orderBy('id', 'desc')->get();
        //$lineas = Lineas::all();

        $data = [];

        foreach ($dipositivos as $dipositivo) {

            $data[] = [
                'value' => $dipositivo->imei,
                'data' => $dipositivo->id,
                'modelo' => $dipositivo->modelo->modelo,
                'marca' => $dipositivo->modelo->marca,
            ];
        }


        return array("suggestions" => $data);
    }
    public function vehiculos(Request $request)
    {

        $term = $request->get('term');

        $vehiculos = Vehiculos::where('placa', 'LIKE', '%' . $term . '%')->active(1)->orderBy('id', 'desc')->get();
        //$lineas = Lineas::all();

        $data = [];

        foreach ($vehiculos as $vehiculo) {

            $data[] = [
                'value' => $vehiculo->id,
                'data' => $vehiculo->placa,
                'flota' => $vehiculo->flotas,
            ];
        }


        return array("suggestions" => $data);
    }


    public function ciudades(Request $request)
    {

        $term = $request->get('term');

        $ciudades = Ciudades::active(true)->where('nombre', 'LIKE', '%' . $term . '%')->orderby('id', 'desc')->get();
        $data = [];
        foreach ($ciudades as $ciudad) {

            $data[] = [
                'value' => $ciudad->id,
                'data' => $ciudad->nombre,
            ];
        }

        return array('suggestions' => $data);
    }

    public function productos(Request $request)
    {

        $term = $request->get('term');
        $tipo = $request->get('tipo');

        if ($tipo) {
            $productos = Productos::active(true)->where('nombre', 'LIKE', '%' . $term . '%')->where('tipo', $tipo)->orderby('id', 'desc')->get();
        } else {
            $productos = Productos::active(true)->where('nombre', 'LIKE', '%' . $term . '%')->orderby('id', 'desc')->get();
        }


        $data = [];
        foreach ($productos as $producto) {

            $data[] = [
                'data' => $producto->id,
                'value' => $producto->nombre,
                'precio' => $producto->precio,
                'divisa' => $producto->divisa,
            ];
        }

        return array('suggestions' => $data);
    }


    public function sunat(Request $request)
    {

        $term = $request->get('numero');
        $tipo = $request->get('tipo');
        // return $term;
        $util = new UtilesController;
        if ($tipo == 'DNI') {
            $resultado = $util->consultaPersona($term);
        } else {
            $resultado = $util->consultaEmpresa($term);
        }



        return $resultado;
    }

    public function facturas(Request $request)
    {

        $term = $request->get('term');
        $querys = Facturas::where('numero', 'LIKE', '%' . $term . '%')->orderBy('id', 'desc')->get();

        $data = [];

        foreach ($querys as $query) {
            $data[] = [
                'value' => $query->numero,
                'data' => $query->id,

            ];
        }

        // return array("suggestions" => $data);
        return array("suggestions" => $data);
    }
}
