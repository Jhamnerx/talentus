<?php

namespace App\Livewire\Admin\Certificados\Velocimetros;

use App\Http\Requests\CertificadosVelocimetrosRequest;
use App\Models\CertificadosVelocimetros;
use App\Models\Ciudades;
use App\Models\Productos;
use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component
{
    public $openModalEdit = false;

    public $certificado;
    public $numero, $vehiculos_id, $ciudades_id, $fondo, $sello, $velocimetro_modelo, $observacion;


    protected $listeners = [
        'actualizarCertificado' => 'openModal'
    ];

    public function render()
    {
        $velocimetros = Productos::velocimetro()->get();
        return view('livewire.admin.certificados.velocimetros.edit', compact('velocimetros'));
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
        $this->observacion = $certificado->observacion;
        $this->vehiculos_id = $certificado->vehiculos_id;
        $this->ciudades_id = $certificado->ciudades_id;
        $this->velocimetro_modelo = $certificado->velocimetro_modelo;
        $this->dispatch('set-vehiculo', ['vehiculo' => $certificado->vehiculo, 'ciudad' => $certificado->ciudades]);
    }

    public function actualizarCertificado()
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $values = $this->validate($certificadoRequest->rules($this->certificado), $certificadoRequest->messages());

        $update = CertificadosVelocimetros::find($this->certificado->id);
        $ciudad = Ciudades::find($values["ciudades_id"]);
        $fecha = $ciudad->nombre . " a los " . today()->day . " del mes de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

        $update->numero = $values["numero"];
        $update->velocimetro_modelo = $values["velocimetro_modelo"];
        $update->vehiculos_id = $values["vehiculos_id"];
        $update->ciudades_id = $values["ciudades_id"];
        $update->fecha = $fecha;
        $codigo = $ciudad->prefijo . "-" . $values["numero"];
        $update->codigo = $codigo;
        $update->observacion = $values["observacion"];
        $update->save();

        $this->openModalEdit = false;
        $this->dispatch('certificado-velocimetro-edit', ['certificado' => $values["numero"]]);
        $this->dispatch('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $this->validateOnly($label, $certificadoRequest->rules($this->certificado), $certificadoRequest->messages());
    }
}