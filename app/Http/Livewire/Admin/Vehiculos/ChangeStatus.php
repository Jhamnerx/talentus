<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Monolog\Handler\IFTTTHandler;

class ChangeStatus extends Component
{
    public Model $model;

    public $field;

    public $is_active;

    public function mount()
    {
        $this->is_active = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        if(!$value){

            $this->model->setAttribute($this->field, $value);

            if($this->model->numero){

                $this->model->setAttribute('old_numero', $this->model->numero);
                $this->model->setAttribute('old_sim_card', $this->model->sim_card->sim_card);
            }



            $this->model->setAttribute('numero', NULL);
            $this->model->setAttribute('sim_card_id', NULL);
            $this->model->save();

        }else{

            $this->model->setAttribute($this->field, $value);
            $this->model->save();
        }
        $this->emit('updateTable');
        $this->dispatchBrowserEvent('change-status', ['status' => $value]);
    }
    public function render()
    {
        return view('livewire.admin.vehiculos.change-status');
    }
}
