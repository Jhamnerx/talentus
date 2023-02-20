<?php

namespace App\Http\Livewire\Admin\SimCard;


use App\Models\SimCard;
use Livewire\Component;

class Save extends Component
{
    public $sim_card, $sim_card_n, $operador;
    public $empresa_id;
    public $inputs = [];
    public $i = 0;


    protected $rules = [
        'operador.0' => 'required',
        "sim_card_n.0"  => "required|distinct|unique:sim_card,sim_card",

        'operador.*' => 'required',
        "sim_card_n.*"  => "required|distinct|unique:sim_card,sim_card",

    ];

    protected $messages = [
        'sim_card_n.0.required' => 'El sim card es requerido',
        'sim_card_n.0.unique' => 'El sim card ya existe',
        'sim_card_n.0.distinct' => 'ya estas registrando este sim',
        'operador.0.required' => 'El operador es requerido',

        'sim_card_n.*.required' => 'El sim card es requerido',
        'sim_card_n.*.unique' => 'El sim card ya existe',
        'sim_card_n.*.distinct' => 'ya estas registrando este numero',
        'operador.*.required' => 'El operador es requerido',
    ];




    public function mount()
    {
        $this->empresa_id = session('empresa');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove($i)
    {
        unset($this->inputs[$i]);
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    private function resetInputFields()
    {
        $this->sim_card_n = '';
        $this->operador = '';
    }

    public function store()
    {
        $validatedDate = $this->validate();

        foreach ($this->operador as $key => $value) {

            SimCard::create([
                'sim_card' => $this->sim_card_n[$key],
                'operador' => $this->operador[$key],
                'empresa_id' => $this->empresa_id,
            ]);
        }

        $this->inputs = [];

        $this->resetInputFields();

        return redirect()->route('admin.almacen.sim-card.index')->with('store', 'Se guardo con exito');
    }
    public function render()
    {
        $this->sim_card = SimCard::all();
        return view('livewire.admin.sim-card.save');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
