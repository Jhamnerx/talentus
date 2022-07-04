<?php

namespace App\Http\Livewire\Admin;

use App\Models\Empresa;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {

        $empresas = Empresa::all();
        return view('livewire.admin.header', compact('empresas'));


    }

    public function changeBussines(Empresa $empresa){

        session()->put('empresa', $empresa->id);
        $this->emit('render');
        $mensaje = "SE CAMBIO DE EMPRESA, ahora veras los registros de la EMPRESA: ".$empresa->nombre."";
        return redirect()->route('admin.home')->with('flash.banner', $mensaje);
        return redirect()->route('admin.home')->with('flash.abnnerStyle', 'success');
    }
}
