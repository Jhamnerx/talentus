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


    public function save()
    {
        $request = new CertificadosGpsRequest();

        $data = $this->validate($request->rules(), $request->messages());

        $ciudad = Ciudades::find($data["ciudades_id"]);

        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

        try {
            $codigo = $ciudad->prefijo . "-" . $data["numero"];

            $certificado = Certificados::create(

                [
                    'numero' => $data["numero"],
                    'fecha_instalacion' => $data["fecha_instalacion"],
                    'fin_cobertura' => $data["fin_cobertura"],
                    'fecha' => $fecha,
                    'year' => today()->year,
                    'sello' => $data["sello"],
                    'fondo' => $data["fondo"],
                    'vehiculos_id' => $data["vehiculos_id"],
                    'ciudades_id' => $data["ciudades_id"],
                    'codigo' =>  $codigo,
                    'accesorios' => $this->accesorios,



                ]
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
