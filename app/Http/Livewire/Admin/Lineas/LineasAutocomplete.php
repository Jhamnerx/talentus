<?php

use App\Http\Livewire\Admin\Lineas\AsignLinea;
use App\Models\Lineas;

class LineasAutocomplete extends AsignLinea
{
    protected $listeners = ['valueSelected'];

    public function valueSelected(Lineas $user)
    {
        $this->emitUp('userSelected', $user);
    }

    public function query()
    {
        return Lineas::where('sim_card', 'like', '%' . $this->search . '%')->orderBy('sim_card');
    }
}
