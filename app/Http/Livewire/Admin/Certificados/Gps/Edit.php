<?php

namespace App\Http\Livewire\Admin\Certificados\Gps;

use App\Http\Requests\CertificadosGpsRequest;
use App\Models\Certificados;
use App\Models\Ciudades;
use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component
{
    public $openModalEdit = false;

    public $certificado;
    public $numero, $vehiculos_id, $fecha_instalacion, $fin_cobertura, $ciudades_id, $fondo, $sello, $accesorios;


    protected $listeners = [
        'actualizarCertificado' => 'openModal'
    ];

    public function render()
    {
        return view('livewire.admin.certificados.gps.edit');
    }


    public function closeModal()
    {
        $this->openModalEdit = false;
        $this->reset();
        $this->resetErrorBag();
    }


    public function openModal(Certificados $certificado)
    {
        $this->openModalEdit = true;

        $this->certificado = $certificado;

        $this->numero = $certificado->numero;
        $this->vehiculos_id = $certificado->vehiculos_id;
        $this->ciudades_id = $certificado->ciudades_id;
        $this->accesorios = $certificado->accesorios;
        $this->dispatchBrowserEvent('set-vehiculo', ['vehiculo' => $certificado->vehiculo, 'ciudad' => $certificado->ciudades]);
        $this->fecha_instalacion = $certificado->fecha_instalacion->format('Y-m-d');
        $this->fin_cobertura = $certificado->fin_cobertura->format('Y-m-d');
    }

    public function actualizarCertificado()
    {
        $certificadoRequest = new CertificadosGpsRequest();

        $values = $this->validate($certificadoRequest->rules($this->certificado), $certificadoRequest->messages());

        $ciudad = Ciudades::find($values["ciudades_id"]);
        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;


        $update = Certificados::find($this->certificado->id);

        $codigo = $ciudad->prefijo . "-" . $update->numero;

        $update->numero = $values["numero"];

        $update->vehiculos_id = $values["vehiculos_id"];
        $update->fecha = $fecha;
        $update->fecha_instalacion = $values["fecha_instalacion"];
        $update->fin_cobertura = $values["fin_cobertura"];
        $update->codigo = $codigo;
        $update->accesorios = $this->accesorios;
        $update->ciudades_id = $values["ciudades_id"];
        $update->save();

        $this->openModalEdit = false;
        $this->dispatchBrowserEvent('certificado-edit', ['certificado' => $values["numero"]]);
        $this->emit('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $certificadoRequest = new CertificadosGpsRequest();
        $this->validateOnly($label, $certificadoRequest->rules($this->certificado), $certificadoRequest->messages());
    }
}
