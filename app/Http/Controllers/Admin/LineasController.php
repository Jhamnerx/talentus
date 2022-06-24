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

  
        if ($request->linea == null) {
            $request->validate([
                'sim_card' => 'required|exists:sim_card,id',
                'numero' => 'required',
            ]);
        } elseif ($request->numero == null) {
            $request->validate([
                'sim_card' => 'required|exists:sim_card,id',

                'linea' => 'required',
            ]);
        } else {
            $request->validate([
                'sim_card' => 'required|exists:sim_card,id',
            ]);
        }




        if ($request->numero) {

            // si existe numero consulto para obtener sim card
            $sim_card = SimCard::where('id', $request->sim_card)->first();

           

            // $linea = Lineas::whereHas('sim_card', function ($query)  use ($request) {
            //     $query->where('numero', $request->numero)->first();
            // });

            if ($sim_card) {

                //dd($sim_card);

                CambiosLineas::create([
                    'tipo_cambio' => 'Asinacion de numero, existe numero',
                    'sim_card_id' => $sim_card->id,
                    'old_numero' => $sim_card->lineas_id,
                    'new_numero' => $request->numero,
                    'user_id' => auth()->user()->id,
                ]);

                $linea = Lineas::find($sim_card->lineas_id);
                $linea->old_sim_card = $sim_card->sim_card;
                $linea->save();
             
                $exists = SimCard::where('lineas_id', $request->numero)->update(['lineas_id' => null]);


                $updated = SimCard::where('id', $request->sim_card)
                    ->update(['lineas_id' => $request->numero]);



                return redirect()->route('admin.almacen.lineas.index')->with('asign', 'Se asigno la linea, Con el numero existente');
            } else {



                CambiosLineas::create([
                    'tipo_cambio' => 'Asinacion de numero',
                    'sim_card_id' => $sim_card->id,
                    'old_numero' => $sim_card->lineas_id,
                    'new_numero' => $request->numero,
                    'user_id' => auth()->user()->id,
                ]);

                $updated = SimCard::where('id', $request->sim_card)
                    ->update(['lineas_id' => $request->numero]);



                return redirect()->route('admin.almacen.lineas.index')->with('asign', 'Se asigno la linea');
            }
        } else {

            $sim_card = SimCard::where('id', $request->sim_card)->first();

            //dd($sim_card);

            //dd($request->sim_card);
            $linea_old = Lineas::find($sim_card->lineas_id);
            $linea_old->old_sim_card = $sim_card->sim_card;
            $linea_old->save();


            //si no existe la linea la creamos
            $linea = Lineas::create([
                'numero' => $request->linea,
                'operador' => "",
                'empresa_id' => session('empresa'),
            ]);

            CambiosLineas::create([
                'tipo_cambio' => 'Asinacion de numero, no existe numero',
                'sim_card_id' => $request->sim_card,
                'old_numero' => $sim_card->lineas_id,
                'new_numero' => $linea->id,
                'user_id' => auth()->user()->id,
            ]);

            //dd($linea);
            //luego la asignamos la linea al sim card
            SimCard::where('id', $request->sim_card)
                ->update([
                    'lineas_id' => $linea->id
                ]);




            return redirect()->route('admin.almacen.lineas.index')->with('asign', 'Se Asigno y se guardo el numero');
        }



        // Lineas::where('sim_card', $request->sim_card)
        //     ->update(['numero' => $request->numero]);

        // return redirect()->route('admin.almacen.lineas.index')->with('update', 'Se asigno el número con exito');
    }
}
