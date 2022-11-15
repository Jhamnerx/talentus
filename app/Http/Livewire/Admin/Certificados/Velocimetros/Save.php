<?php

namespace App\Http\Livewire\Admin\Certificados\Velocimetros;

use App\Http\Controllers\Admin\CertificadosVelocimetrosController;
use App\Http\Requests\CertificadosVelocimetrosRequest;
use App\Models\CertificadosVelocimetros;
use App\Models\Ciudades;
use Livewire\Component;
use Illuminate\Support\Str;

class Save extends Component
{

    public $openModalSave = false;
    public $numero, $vehiculos_id, $ciudades_id, $fondo = 1, $sello = 1;

    protected $listeners = [
        'guardarCertificado' => 'openModal'
    ];

    public function render()
    {
        return view('livewire.admin.certificados.velocimetros.save');
    }

    public function openModal()
    {
        $this->openModalSave = true;
        $certController = new CertificadosVelocimetrosController();
        $this->numero = $certController->setNextSequenceNumber();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function closeModal()
    {
        $this->openModalSave = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function guardarCertificado()
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $values = $this->validate($certificadoRequest->rules(), $certificadoRequest->messages());

        $ciudad = Ciudades::find($values["ciudades_id"]);

        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

        $certificado = new CertificadosVelocimetros();
        $certificado->vehiculos_id = $values["vehiculos_id"];
        $certificado->numero = $values["numero"];
        $certificado->ciudades_id = $values["ciudades_id"];
        $certificado->fondo = $values["fondo"];
        $certificado->sello = $values["sello"];

        $codigo = $ciudad->prefijo . "-" . $certificado->numero;
        $certificado->year = today()->year;
        $certificado->codigo = $codigo;
        $certificado->fecha = $fecha;
        $certificado->save();

        $this->dispatchBrowserEvent('certificado-velocimetro-save', ['vehiculo' => $certificado->vehiculo->placa]);
        $this->emit('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $this->validateOnly($label, $certificadoRequest->rules(), $certificadoRequest->messages());
    }
}
