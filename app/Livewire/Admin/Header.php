<?php

namespace App\Livewire\Admin;

use App\Models\Empresa;
use Livewire\Component;
use App\Models\plantilla;
use App\Services\FactilizaService;

class Header extends Component
{
    public $page;
    public $variant;

    public function render()
    {

        if (!session()->has('empresa')) {

            session()->put('empresa', 1);
        }
        $empresas = Empresa::all();
        $empresa_actual = plantilla::first()->razon_social;
        return view('livewire.admin.header', compact('empresas', 'empresa_actual'));
    }

    public function mount($page)
    {

        $this->page = $page;
    }

    public function changeBussines(Empresa $empresa)
    {

        session()->put('empresa', $empresa->id);
        $this->dispatch('render');
        $mensaje = "SE CAMBIO DE EMPRESA, ahora veras los registros de la EMPRESA: " . $empresa->plantilla->razon_social . "";
        return redirect($this->page)->with('flash.banner', $mensaje);
        return redirect($this->page)->with('flash.abnnerStyle', 'success');
        //  return redirect($this->page);
    }

    public function getTipoCambio()
    {
        $resultado = actualizar_tipo_cambio();

        if ($resultado) {
            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'TIPO CAMBIO ACTUALIZADO',
                mensaje: "Venta: S/ {$resultado['venta']} | Compra: S/ {$resultado['compra']}"
            );
        } else {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'No se pudo obtener el tipo de cambio'
            );
        }
    }
    public function showInfo(Empresa $empresa)
    {

        dd($empresa->plantilla->razon_social);
    }
}
