<?php

namespace App\Livewire\Admin\Certificados\Velocimetros;

use App\Http\Controllers\Admin\CertificadosVelocimetrosController;
use App\Http\Requests\CertificadosVelocimetrosRequest;
use App\Models\CertificadosVelocimetros;
use App\Models\Ciudades;
use App\Models\Productos;
use Livewire\Component;
use Illuminate\Support\Str;

class Save extends Component
{

    public $openModalSave = false;
    public $numero, $vehiculos_id, $ciudades_id, $fondo = 1, $sello = 1, $velocimetro_modelo, $observacion;

    protected $listeners = [
        'guardarCertificado' => 'openModal'
    ];

    public function render()
    {
        $velocimetros = Productos::velocimetro()->get();
        return view('livewire.admin.certificados.velocimetros.save', compact('velocimetros'));
    }

    public function openModal()
    {
        $this->openModalSave = true;
        $certController = new CertificadosVelocimetrosController();
        $this->numero = $certController->setNextSequenceNumber();
        $this->dispatch('close-modal');
    }

    public function closeModal()
    {
        $this->openModalSave = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function save()
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $values = $this->validate($certificadoRequest->rules(), $certificadoRequest->messages());

        try {

            $ciudad = Ciudades::find($values["ciudades_id"]);

            $fecha = $ciudad->nombre . " a los " . today()->day . " del mes de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

            $certificado = new CertificadosVelocimetros();
            $certificado->vehiculos_id = $values["vehiculos_id"];
            $certificado->numero = $values["numero"];
            $certificado->velocimetro_modelo = $values["velocimetro_modelo"];
            $certificado->ciudades_id = $values["ciudades_id"];
            $certificado->fondo = $values["fondo"];
            $certificado->sello = $values["sello"];

            $codigo = $ciudad->prefijo . "-" . $certificado->numero;
            $certificado->year = today()->year;
            $certificado->codigo = $codigo;
            $certificado->fecha = $fecha;
            $certificado->observacion = $values["observacion"];
            $certificado->save();

            $this->afterSave($certificado->codigo);
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL GUARDAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
    }

    public function afterSave($numero)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'CERTIFICADO REGISTRADO',
            mensaje: 'Se registro correctamente el certificado #' . $numero,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }


    public function updated($label)
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $this->validateOnly($label, $certificadoRequest->rules(), $certificadoRequest->messages());
    }
}
