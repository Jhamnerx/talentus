<?php

namespace App\Http\Livewire\Admin;

use App\Models\Empresa;
use Livewire\Component;

class Header extends Component
{
    public $page;

    public function render()
    {

        $empresas = Empresa::all();
        $empresa_actual = Empresa::where('id', session('empresa'))->first()->plantilla->razon_social;
        return view('livewire.admin.header', compact('empresas', 'empresa_actual'));
    }

    public function mount($page)
    {

        $this->page = $page;
    }

    public function changeBussines(Empresa $empresa)
    {

        session()->put('empresa', $empresa->id);
        $this->emit('render');
        $mensaje = "SE CAMBIO DE EMPRESA, ahora veras los registros de la EMPRESA: " . $empresa->plantilla->razon_social . "";
        return redirect($this->page)->with('flash.banner', $mensaje);
        return redirect($this->page)->with('flash.abnnerStyle', 'success');
        //  return redirect($this->page);
    }

    public function showInfo(Empresa $empresa)
    {

        dd($empresa->plantilla->razon_social);
    }
}
