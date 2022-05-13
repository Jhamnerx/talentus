<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Dispositivos;
use App\Models\Flotas;
use App\Models\Lineas;
use App\Models\SimCard;
use Dflydev\DotAccessData\Data;

class SearchController extends Controller
{
    //
    public function clientes(Request $request)
    {

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

        // return array("suggestions" => $data);
        return array("suggestions" => $data);
    }

    public function flotas(Request $request)
    {

        $term = $request->get('term');
        $querys = Flotas::where('nombre', 'LIKE', '%' . $term . '%')->orderBy('id', 'desc')->get();

        $data = [];

        foreach ($querys as $query) {
            $data[] = [
                'value' => $query->id,
                'data' => $query->nombre,
                'flotas' => $query->clientes,

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
}
