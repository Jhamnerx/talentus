<?php

namespace App\Livewire\Admin\Certificados\Gps;

use App\Http\Controllers\Admin\CertificadosGpsController;
use App\Http\Requests\CertificadosGpsRequest;
use App\Models\Certificados;
use App\Models\Ciudades;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class Save extends Component
{

    public $openModalSave = false;
    public $numero, $vehiculos_id, $ciudades_id, $fondo = 1, $sello = 1;
    public $fecha_instalacion;
    public $fin_cobertura;
    public $accesorios = [];


    public function render()
    {
        return view('livewire.admin.certificados.gps.save');
    }

    #[On('guardarCertificado')]
    public function openModal()
    {
        $this->openModalSave = true;
        $certController = new CertificadosGpsController();
        $this->numero = $certController->setNextSequenceNumber();
        $this->fecha_instalacion = Carbon::now()->format('Y-m-d');
        $this->fin_cobertura = Carbon::now()->addDays(30)->format('Y-m-d');
    }

    function updatedCiudadesId()
    {
        // $this->numero = $this->setNextSequenceNumber($this->ciudad_prefijo);
    }

    public function closeModal()
    {
        $this->openModalSave = false;
        $this->resetProperties(); // Llamada al método para restablecer las propiedades
    }


    public function guardarCertificado()
    {
        $certificadoRequest = new CertificadosGpsRequest();

        $values = $this->validate($certificadoRequest->rules(), $certificadoRequest->messages());

        $ciudad = Ciudades::find($values["ciudades_id"]);

        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

        try {

            $certificado = new Certificados();
            $certificado->vehiculos_id = $values["vehiculos_id"];
            $certificado->numero = $values["numero"];
            $certificado->fin_cobertura = $values["fin_cobertura"];
            $certificado->fecha_instalacion = $values["fecha_instalacion"];
            $certificado->ciudades_id = $values["ciudades_id"];
            $certificado->fondo = $values["fondo"];
            $certificado->sello = $values["sello"];
            $certificado->accesorios = $this->accesorios;
            $certificado->year = today()->year;
            $codigo = $ciudad->prefijo . "-" . $certificado->numero;
            $certificado->codigo = $codigo;
            $certificado->fecha = $fecha;
            $certificado->save();


            $certificado = Certificados::create(
                []
            );
            $this->afterSave($certificado->codigo);
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                tittle: 'ERROR AL ACTUALIZAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
    }
    public function afterSave($numero)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'CERTIFICADO REGISTRADO',
            mensaje: 'Se registro correctamente el certificado #' . $numero,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
    public function updated($label)
    {
        $certificadoRequest = new CertificadosGpsRequest();
        $this->validateOnly($label, $certificadoRequest->rules(), $certificadoRequest->messages());
    }

    public function resetProperties()
    {
        $this->numero = null;
        $this->vehiculos_id = null;
        $this->fecha_instalacion = null;
        $this->fin_cobertura = null;
        $this->ciudades_id = null;
        $this->accesorios = [];
        $this->fondo = 1;
        $this->sello = 1;
    }
}
