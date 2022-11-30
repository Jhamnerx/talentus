<?php

namespace App\Http\Livewire\Admin\Certificados\Velocimetros;

use App\Http\Requests\CertificadosVelocimetrosRequest;
use App\Models\CertificadosVelocimetros;
use App\Models\Ciudades;
use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component
{
    public $openModalEdit = false;

    public $certificado;
    public $numero, $vehiculos_id, $ciudades_id, $fondo, $sello;


    protected $listeners = [
        'actualizarCertificado' => 'openModal'
    ];

    public function render()
    {
        return view('livewire.admin.certificados.velocimetros.edit');
    }

    public function closeModal()
    {
        $this->openModalEdit = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function openModal(CertificadosVelocimetros $certificado)
    {
        $this->openModalEdit = true;

        $this->certificado = $certificado;
        $this->numero = $certificado->numero;
        $this->vehiculos_id = $certificado->vehiculos_id;
        $this->ciudades_id = $certificado->ciudades_id;
        $this->dispatchBrowserEvent('set-vehiculo', ['vehiculo' => $certificado->vehiculos, 'ciudad' => $certificado->ciudades]);
    }

    public function actualizarCertificado()
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $values = $this->validate($certificadoRequest->rules($this->certificado), $certificadoRequest->messages());

        $update = CertificadosVelocimetros::find($this->certificado->id);
        $ciudad = Ciudades::find($values["ciudades_id"]);
        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

        $update->numero = $values["numero"];
        $update->vehiculos_id = $values["vehiculos_id"];
        $update->ciudades_id = $values["ciudades_id"];
        $update->fecha = $fecha;
        $codigo = $ciudad->prefijo . "-" . $values["numero"];
        $update->codigo = $codigo;
        $update->save();

        $this->openModalEdit = false;
        $this->dispatchBrowserEvent('certificado-velocimetro-edit', ['certificado' => $values["numero"]]);
        $this->emit('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $this->validateOnly($label, $certificadoRequest->rules($this->certificado), $certificadoRequest->messages());
    }
}
