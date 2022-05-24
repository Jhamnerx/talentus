<?php

namespace App\Http\Livewire\Admin\Certificados\Gps;

use App\Http\Requests\CertificadosGpsRequest;
use App\Models\Certificados;
use App\Models\Ciudades;
use Livewire\Component;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class Save extends Component
{


    public $openModalSave = false;
    public $numero, $vehiculos_id, $fin_cobertura, $ciudades_id, $fondo = 1, $sello = 1;

    protected $listeners = [
        'guardarCertificado' => 'openModal'
    ];

    public function render()
    {
        return view('livewire.admin.certificados.gps.save');
    }

    public function openModal()
    {
        $this->openModalSave = true;
    }
    public function closeModal()
    {
        $this->openModalSave = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function guardarCertificado()
    {
        $certificadoRequest = new CertificadosGpsRequest();
        $values = $this->validate($certificadoRequest->rules(), $certificadoRequest->messages());

        //  dd($values);

        $ciudad = Ciudades::find($values["ciudades_id"]);

        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

        $certificado = Certificados::create($values);

        $codigo = $ciudad->prefijo . "-" . date('y') . "-" . $certificado->numero;
        $certificado->year = today()->year;
        $certificado->user_id = auth()->user()->id;

        $certificado->unique_hash = Hashids::connection(certificados::class)->encode($certificado->id);
        $certificado->empresa_id = session('empresa');
        $certificado->codigo = $codigo;
        $certificado->fecha = $fecha;
        $certificado->save();

        //$this->openModalSave = false;
        $this->dispatchBrowserEvent('certificado-save', ['vehiculo' => $certificado->vehiculos->placa]);
        $this->emit('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $certificadoRequest = new CertificadosGpsRequest();
        $this->validateOnly($label, $certificadoRequest->rules(), $certificadoRequest->messages());
    }
}
