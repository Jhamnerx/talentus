<?php

namespace App\Livewire\Admin\Certificados\Gps;

use App\Http\Requests\CertificadosGpsRequest;
use App\Models\Certificados;
use App\Models\Ciudades;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $openModalEdit = false;

    public Certificados $certificado;
    public $numero, $vehiculos_id, $fecha_instalacion, $fin_cobertura, $ciudades_id, $fondo = true, $sello = true, $accesorios;
    public $buzzer_detalle = '';


    public function render()
    {
        return view('livewire.admin.certificados.gps.edit');
    }



    public function closeModal()
    {
        $this->openModalEdit = false;
        $this->resetProperties(); // Llamada al método para restablecer las propiedades
    }

    public function resetProperties()
    {
        $this->numero = null;
        $this->vehiculos_id = null;
        $this->fecha_instalacion = null;
        $this->fin_cobertura = null;
        $this->ciudades_id = null;
        $this->accesorios = [];
        $this->buzzer_detalle = '';
        $this->fondo = 1;
        $this->sello = 1;
    }

    #[On('actualizarCertificado')]
    public function openModal(Certificados $certificado)
    {
        $this->openModalEdit = true;

        $this->certificado = $certificado;

        $this->numero = $certificado->numero;
        $this->vehiculos_id = $certificado->vehiculos_id;
        $this->ciudades_id = $certificado->ciudades_id;

        // Procesar accesorios para extraer array simple y detalle de buzzer
        $accesoriosArray = [];
        $this->buzzer_detalle = '';

        foreach ($certificado->accesorios as $accesorio) {
            if (is_array($accesorio) && isset($accesorio['nombre']) && $accesorio['nombre'] === 'BUZZER') {
                $accesoriosArray[] = 'BUZZER';
                $this->buzzer_detalle = $accesorio['detalle'] ?? '';
            } else {
                $accesoriosArray[] = is_array($accesorio) ? $accesorio['nombre'] : $accesorio;
            }
        }

        $this->accesorios = $accesoriosArray;
        $this->fondo = $certificado->fondo;
        $this->sello = $certificado->sello;
        $this->fecha_instalacion = $certificado->fecha_instalacion->format('Y-m-d');
        $this->fin_cobertura = $certificado->fin_cobertura->format('Y-m-d');
    }

    public function save()
    {
        $certificadoRequest = new CertificadosGpsRequest();

        $data = $this->validate($certificadoRequest->rules($this->certificado), $certificadoRequest->messages());

        $ciudad = Ciudades::find($data["ciudades_id"]);
        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

        try {
            $codigo = $ciudad->prefijo . "-" . $data["numero"];

            // Procesar accesorios para incluir detalle de buzzer
            $accesoriosProcessed = [];
            foreach ($this->accesorios as $accesorio) {
                if ($accesorio === 'BUZZER' && !empty($this->buzzer_detalle)) {
                    $accesoriosProcessed[] = [
                        'nombre' => 'BUZZER',
                        'detalle' => $this->buzzer_detalle
                    ];
                } else {
                    $accesoriosProcessed[] = $accesorio;
                }
            }

            $this->certificado->update(
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
                    'accesorios' => $accesoriosProcessed,

                ]
            );


            $this->afterSave($data["numero"]);
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL ACTUALIZAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
    }

    public function updated($label)
    {
        $certificadoRequest = new CertificadosGpsRequest();
        $this->validateOnly($label, $certificadoRequest->rules($this->certificado), $certificadoRequest->messages());
    }

    public function afterSave($numero)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'CERTIFICADO ACTUALIZADO',
            mensaje: 'Se actualizo correctamente el certificado #' . $numero,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
}
