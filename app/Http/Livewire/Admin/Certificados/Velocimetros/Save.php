<?php

namespace App\Http\Livewire\Admin\Certificados\Velocimetros;

use App\Http\Requests\CertificadosVelocimetrosRequest;
use App\Models\CertificadosVelocimetros;
use App\Models\Ciudades;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;
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

        //  dd($values);

        $ciudad = Ciudades::find($values["ciudades_id"]);

        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

        $certificado = CertificadosVelocimetros::create($values);

        $codigo = $ciudad->prefijo . "-" . date('y') . "-" . $certificado->numero;
        $certificado->year = today()->year;
        $certificado->user_id = auth()->user()->id;

        $certificado->unique_hash = Hashids::connection(CertificadosVelocimetros::class)->encode($certificado->id);
        $certificado->empresa_id = session('empresa');
        $certificado->codigo = $codigo;
        $certificado->fecha = $fecha;
        $certificado->save();

        //$this->openModalSave = false;
        $this->dispatchBrowserEvent('certificado-velocimetro-save', ['vehiculo' => $certificado->vehiculos->placa]);
        $this->emit('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $this->validateOnly($label, $certificadoRequest->rules(), $certificadoRequest->messages());
    }
}
