<?php

namespace App\Livewire\Admin\Ajustes\Sunat;

use Livewire\Component;
use App\Models\plantilla;
use Illuminate\Support\Facades\Storage;

class CertificadoPem extends Component
{
    public $data = '';
    public plantilla $plantilla;


    public function mount()
    {
        $this->plantilla = plantilla::first();
        $ruta = $this->plantilla->empresa->nombre . '/certificado';
        $this->data = Storage::disk('facturacion')->get($ruta . '/' . $this->plantilla->empresa->nombre . '_certificado.pem');
    }


    public function render()
    {
        return view('livewire.admin.ajustes.sunat.certificado-pem');
    }

    public function uploadCertificado()
    {

        try {
            $ruta = $this->plantilla->empresa->nombre . '/certificado' .  '/' . $this->plantilla->empresa->nombre . '_certificado.pem';

            //actualizar la ruta del certificado
            $this->plantilla->update(['ruta_cert' => '/certificado' .  '/' . $this->plantilla->empresa->nombre . '_certificado']);

            Storage::disk('facturacion')->put($ruta, $this->data);

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'CERTIFICADO SUBIDO',
                mensaje: 'Se guardo el certificado',
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'mensaje: ' . $th->getMessage(),
            );
        }
    }
}
