<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LineasExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\LineasRequest;
use App\Models\CambiosLineas;
use App\Models\Lineas;
use App\Models\SimCard;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LineasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.almacen.lineas.index');
    }
    public function disponibles()
    {
        return view('admin.almacen.lineas.disponibles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.almacen.lineas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LineasRequest $request)

    {
        //dd($request);
        // SimCard::create($request->all());
        // return redirect()->route('admin.almacen.lineas.index')->with('store', 'Se guardo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lineas  $lineas
     * @return \Illuminate\Http\Response
     */
    public function show(Lineas $lineas)
    {
        return view('admin.almacen.lineas.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lineas  $lineas
     * @return \Illuminate\Http\Response
     */
    public function edit(Lineas $lineas)
    {
        return view('admin.almacen.lineas.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lineas  $lineas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lineas $lineas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lineas  $lineas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lineas $lineas)
    {
        //
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function exportExcel()
    {
        return Excel::download(new LineasExport, 'lineas.xls');
    }

    public function asignLinea(Request $request)
    {
        return view('admin.almacen.lineas.asign');
    }


    public function asignLineaStore(Request $request)
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

      //dd($request->all());
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
                    'old_numero' => $sim_card->linea ? $sim_card->linea->id: NULL,
                    'new_numero' => $request->lineas_id,
                    'user_id' => auth()->user()->id,
                ]);

                #colocar nullo la linea en el sim card
                $sim_card_linea->lineas_id = null;
                $sim_card_linea->save();


                //consultamos el nuevo sim card
                $sim_card_new = SimCard::where('id',$request->sim_card_id)->first();

                //asignamos la nueva linea al sim card
                $sim_card_new->lineas_id = $request->lineas_id;
                $sim_card_new->save();

                //consultamos la linea
                $linea = Lineas::find($request->lineas_id);

                #Colocar el old sim card a la linea
                $linea->old_sim_card = $sim_card_linea->sim_card;
                $linea->save();

                return redirect()->route('admin.almacen.lineas.index')->with('asign', 'Se asigno la linea, Con el numero existente');


            } else {
                # si no esta asignada
               # Si la linea no esta asignada hacer lo siguiente
               #lo mismo pero no verificamos el antiguo sim card
                #Registra el cambio
                CambiosLineas::create([
                    'tipo_cambio' => 'Asinacion de numero, existe numero',
                    'sim_card_id' => $request->sim_card_id,
                    'old_numero' => $sim_card->linea ? $sim_card->linea->id: NULL,
                    'new_numero' => $request->lineas_id,
                    'user_id' => auth()->user()->id,
                ]);

                //consultamos el nuevo sim card
                $sim_card_new = SimCard::where('id',$request->sim_card_id)->first();

                //asignamos la nueva linea al sim card
                $sim_card_new->lineas_id = $request->lineas_id;
                $sim_card_new->save();

                //consultamos la linea
                $linea = Lineas::find($request->lineas_id);

                #Colocar el old sim card a la linea
                $linea->old_sim_card = null;
                $linea->save();

                return redirect()->route('admin.almacen.lineas.index')->with('asign', 'Se asigno la linea, Con el numero existente');
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
                'old_numero' => $sim_card->linea ? $sim_card->linea->id: NULL,
                'new_numero' => $linea->id,
                'user_id' => auth()->user()->id,
            ]);

            #asignamos la linea creado al sim card
            $sim_card->lineas_id = $linea->id;

            $sim_card->save();
            return redirect()->route('admin.almacen.lineas.index')->with('asign', 'Se asigno la linea, Con el numero creado');

        }
        

    }
}
