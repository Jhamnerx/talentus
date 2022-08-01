<?php










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
                //1
             
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