<?php

namespace App\Livewire\Admin\Ajustes\Sunat;

use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;
use Livewire\Component;
use App\Models\plantilla;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\Facturacion\Api\Util;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Certificado extends Component
{
    use WithFileUploads;

    public $file;
    public plantilla $plantilla;

    protected $rules = [
        'file' => 'extensions:bin,p12'
    ];

    protected $messages = [
        'file.extensions' => 'El Archivo debe ser del tipo .P12'
    ];

    public function mount()
    {
        $this->plantilla = plantilla::first();
    }


    public function render()
    {
        return view('livewire.admin.ajustes.sunat.certificado');
    }

    public function uploadCertificado()
    {
        $this->validate();

        try {

            $ruta = $this->plantilla->empresa->nombre . '/certificado';

            $this->file->storeAs($ruta,  $this->file->getClientOriginalName(), 'facturacion');

            $util = new ApiFacturacion();
            $mensaje = $util->convertCertificado($ruta . "/" .  $this->file->getClientOriginalName(), $this->plantilla->sunat_datos['clave_certificado_cdt']);

            if ($mensaje != 'exito') {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'ERROR',
                    mensaje: 'mensaje: ' . $mensaje,
                );
                return;
            }
            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'CERTIFICADO SUBIDO Y CONVERTIDO',
                mensaje: 'Se guardo y se convertio el certificado',
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
