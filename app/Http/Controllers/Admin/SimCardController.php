<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lineas;
use App\Models\SimCard;
use Illuminate\Http\Request;
use App\Exports\LineasExport;
use App\Models\CambiosLineas;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class SimCardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-sim_card', ['only' => ['index', 'disponibles']]);
        $this->middleware('permission:crear-sim_card', ['only' => ['create']]);
        $this->middleware('permission:editar-sim_card', ['only' => ['edit']]);
    }


    public function index()
    {
        return view('admin.almacen.sim-card.index');
    }

    public function create()
    {
        return view('admin.almacen.sim-card.create');
    }


    public function exportExcel()
    {
        return Excel::download(new LineasExport, 'lineas.xls');
    }

    public function asign(Request $request)
    {
        return view('admin.almacen.sim-card.asign');
    }


    public function asignSimCardStore(Request $request)
    {

        if ($request->lineas_id == null) {

            $request->validate([
                'sim_card_id' => 'required|exists:sim_card,id',
                'numero' => 'required',
            ]);
        } elseif ($request->numero == null) {

            $request->validate([
                'sim_card_id' => 'required|exists:sim_card,id',
                'lineas_id' => 'required',
            ]);
        } else {

            $request->validate([
                'sim_card_id' => 'required|exists:sim_card,id',
            ]);
        }

        //verificar si enviamos el id de la linea
        if ($request->lineas_id) {

            $sim_card_linea = SimCard::where('lineas_id', $request->lineas_id)->first();

            $sim_card = SimCard::where('id', $request->sim_card_id)->first();


            if ($sim_card_linea) {



                # Si la linea esta asignada hacer lo siguiente
                #Registra el cambio
                CambiosLineas::create([
                    'tipo_cambio' => 'Asinacion de numero, existe numero',
                    'sim_card_id' => $request->sim_card_id,
                    'old_numero' => $sim_card->linea ? $sim_card->linea->id : NULL,
                    'new_numero' => $request->lineas_id,
                    'user_id' => auth()->user()->id,
                ]);

                #colocar nullo la linea en el sim card
                $sim_card_linea->lineas_id = null;
                $sim_card_linea->save();


                //consultamos el nuevo sim card
                $sim_card_new = SimCard::where('id', $request->sim_card_id)->first();

                //asignamos la nueva linea al sim card
                $sim_card_new->lineas_id = $request->lineas_id;
                $sim_card_new->save();

                //consultamos la linea
                $linea = Lineas::where('id', $request->lineas_id)->first();

                #Colocar el old sim card a la linea
                $linea->old_sim_card = $sim_card_linea->sim_card;
                $linea->save();

                return redirect()->route('admin.almacen.sim-card.index')->with('asign', 'Se asigno la linea, Con el numero existente');
            } else {
                # si no esta asignada
                # Si la linea no esta asignada hacer lo siguiente
                #lo mismo pero no verificamos el antiguo sim card
                #Registra el cambio
                CambiosLineas::create([
                    'tipo_cambio' => 'Asinacion de numero, existe numero',
                    'sim_card_id' => $request->sim_card_id,
                    'old_numero' => $sim_card->linea ? $sim_card->linea->id : NULL,
                    'new_numero' => $request->lineas_id,
                    'user_id' => auth()->user()->id,
                ]);

                //consultamos el nuevo sim card
                $sim_card_new = SimCard::where('id', $request->sim_card_id)->first();

                //asignamos la nueva linea al sim card
                $sim_card_new->lineas_id = $request->lineas_id;
                $sim_card_new->save();

                //consultamos la linea
                $linea = Lineas::where('id', $request->lineas_id)->first();

                #Colocar el old sim card a la linea
                $linea->old_sim_card = null;
                $linea->save();

                return redirect()->route('admin.almacen.sim-card.index')->with('asign', 'Se asigno la linea, Con el numero existente');
            }
        }
        //si la linea no existe
        else {


            #buscamos el sim card que seleciconamos
            $sim_card = SimCard::where('id', $request->sim_card_id)->first();

            # creamos la linea
            // dd($request->all());
            $linea = Lineas::create([
                'numero' => $request->numero,
                'operador' => $sim_card->operador,
                'empresa_id' => session('empresa'),
            ]);


            #registramso el cambio realizado
            CambiosLineas::create([
                'tipo_cambio' => 'Asinacion de numero,No existia el numero',
                'sim_card_id' => $request->sim_card_id,
                'old_numero' => $sim_card->linea ? $sim_card->linea->id : NULL,
                'new_numero' => $linea->id,
                'user_id' => auth()->user()->id,
            ]);

            #asignamos la linea creado al sim card
            $sim_card->lineas_id = $linea->id;

            $sim_card->save();
            return redirect()->route('admin.almacen.sim-card.index')->with('asign', 'Se asigno la linea, Con el numero creado');
        }
    }
}
