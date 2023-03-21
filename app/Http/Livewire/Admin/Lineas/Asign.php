<?php

namespace App\Http\Livewire\Admin\Lineas;

use App\Models\Lineas;
use App\Models\SimCard;
use Livewire\Component;
use App\Models\CambiosLineas;
use BaconQrCode\Renderer\Path\Line;

class Asign extends Component
{
    public $sim_card_id = null, $sim_card;

    public $linea_id = null, $numero;


    protected function rules()
    {
        return [
            'linea_id' => 'required|exists:lineas,id',
            'numero' => 'required|exists:lineas,numero',
            'sim_card' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'linea_id' => 'Debes seleccionar una linea existente',
            'sim_card' => 'Ingresa o selecciona un sim card',
        ];
    }

    public function render()
    {
        return view('livewire.admin.lineas.asign');
    }

    public function save()
    {
        $this->validate();

        $linea = Lineas::findOrFail($this->linea_id);


        // si la linea tiene asignada un sim card se cambiara
        if ($linea->sim_card) {

            $this->setOldSimCard($linea, $linea->sim_card->sim_card);
            $this->updateSimCard($linea->sim_card);
        }

        $sim_card = SimCard::firstOrCreate(
            ['sim_card' => $this->sim_card],
            [
                'lineas_id' => null,
                'sim_card' => $this->sim_card,
                'operador' => $linea->operador,
            ]
        );


        #Registra el cambio
        CambiosLineas::create([
            'tipo_cambio' => 'Se asigno el numero al sim card',
            'sim_card_id' => $sim_card->id,
            'old_numero' => $sim_card->linea ? $sim_card->linea->id : NULL,
            'new_numero' => $linea->id,
            'user_id' => auth()->user()->id,
        ]);

        //establecer sim card old si la sim card ingresada tiene una asignada
        if ($sim_card->linea) {

            $this->updateExistLineaSimCard($sim_card->linea, $sim_card);
        }

        if ($sim_card) {

            $this->setLineaToSim($sim_card, $linea);
        }





        return redirect()->route('admin.almacen.lineas.index')->with('asign', 'Se asigno la linea, Con el numero existente');
    }

    public function setOldSimCard(Lineas $linea, $sim_card_old)
    {
        $linea->old_sim_card = $sim_card_old;

        $linea->save();
    }

    public function updateSimCard(SimCard $sim_card)
    {

        $sim_card->lineas_id = null;
        $sim_card->save();
    }

    public function setLineaToSim(SimCard $sim_card, Lineas $linea)
    {

        $sim_card->lineas_id = $linea->id;
        $sim_card->save();
    }

    public function updateExistLineaSimCard(Lineas $linea, SimCard $sim_card)
    {

        $linea->old_sim_card = $sim_card->sim_card;
        $linea->save();
    }


    public function updated($prop)
    {

        $this->validateOnly($prop);
    }

    public function updatingNumero($value)
    {

        if ($value == "") {
            $this->linea_id = null;
        }
    }
}
