<?php

namespace App\Http\Livewire\Admin\Certificados\Gps;

use App\Http\Requests\CertificadosGpsRequest;
use App\Models\Certificados;
use Livewire\Component;

class Edit extends Component
{
    public $openModalEdit = false;

    public $certificado;
    public $numero, $vehiculos_id, $fin_cobertura, $ciudades_id, $fondo, $sello;


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
        $this->dispatchBrowserEvent('set-vehiculo', ['vehiculo' => $certificado->vehiculos, 'ciudad' => $certificado->ciudades]);
        $this->fin_cobertura = $certificado->fin_cobertura;
    }

    public function actualizarCertificado()
    {
        $certificadoRequest = new CertificadosGpsRequest();
        $values = $this->validate($certificadoRequest->rules($this->certificado), $certificadoRequest->messages());

        $update = Certificados::find($this->certificado->id);
        $update->numero = $values["numero"];
        $update->vehiculos_id = $values["vehiculos_id"];
        $update->fin_cobertura = $values["fin_cobertura"];
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
