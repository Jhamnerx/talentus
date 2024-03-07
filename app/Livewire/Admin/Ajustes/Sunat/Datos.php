<?php

namespace App\Livewire\Admin\Ajustes\Sunat;

use Livewire\Component;
use App\Models\plantilla;

class Datos extends Component
{
    public plantilla $plantilla;
    public $sunat;
    public function mount()
    {

        $this->sunat = $this->plantilla->sunat_datos;
    }

    public function render()
    {
        return view('livewire.admin.ajustes.sunat.datos');
    }

    public function saveSunat()
    {

        $data = $this->validate([
            'sunat.usuario_sol_sunat' => 'required',
            'sunat.clave_sol_sunat' => 'required',
            'sunat.clave_certificado_cdt' => 'nullable',
        ]);


        $this->plantilla->update([
            'sunat_datos' => [
                'usuario_sol_sunat' => $data['sunat']['usuario_sol_sunat'],
                'clave_sol_sunat' => $data['sunat']['clave_sol_sunat'],
                'clave_certificado_cdt' => $data['sunat']['clave_certificado_cdt'],
            ]
        ]);

        $this->afterSave();
    }


    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'INFORMACION ACTUALIZADA',
            mensaje: 'se actualizo la informacion'
        );
    }
}
