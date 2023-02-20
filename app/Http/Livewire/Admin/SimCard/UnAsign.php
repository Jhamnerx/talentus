<?php

namespace App\Http\Livewire\Admin\SimCard;

use App\Models\CambiosLineas;
use App\Models\Lineas;
use App\Models\SimCard;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class UnAsign extends Component
{
    public Model $sim_card;
    public $openUnAsign = false;
    // protected $listeners = ['unAsign' => 'unAsign'];


    public function render()
    {
        return view('livewire.admin.sim-card.un-asign');
    }

    public function openModal()
    {
        $this->openUnAsign = true;
        //dd($this->sim_card);
    }

    public function unAsign()
    {



        CambiosLineas::create([
            'tipo_cambio' => 'Se elimino el numero asignado',
            'sim_card_id' => $this->sim_card->id,
            'old_numero' => $this->sim_card->lineas_id,
            'new_numero' => null,
            'user_id' => auth()->user()->id,
        ]);

        $linea = Lineas::findOrFail($this->sim_card->lineas_id);

        if ($linea) {
            $linea->old_sim_card = $this->sim_card->sim_card;
            $linea->save();
        }


        $this->sim_card->update([
            "lineas_id" => null,
        ]);

        $this->openUnAsign = false;
        return redirect()->route('admin.almacen.sim-card.index')->with('unasign', 'Se Elimino el numero del Sim Card');;
    }
}
