<?php

namespace App\Livewire\Admin\Certificados\Velocimetros;

use App\Http\Requests\CertificadosVelocimetrosRequest;
use App\Models\CertificadosVelocimetros;
use App\Models\Ciudades;
use App\Models\Productos;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $openModalEdit = false;

    public CertificadosVelocimetros $certificado;
    public $numero, $vehiculos_id, $ciudades_id, $fondo, $sello, $velocimetro_modelo, $observacion;



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


    #[On('actualizarCertificado')]
    public function openModal(CertificadosVelocimetros $certificado)
    {
        $this->openModalEdit = true;

        $this->certificado = $certificado;
        $this->numero = $certificado->numero;
        $this->observacion = $certificado->observacion;
        $this->vehiculos_id = $certificado->vehiculos_id;
        $this->ciudades_id = $certificado->ciudades_id;
        $this->velocimetro_modelo = $certificado->velocimetro_modelo;
    }

    public function save()
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $values = $this->validate($certificadoRequest->rules($this->certificado), $certificadoRequest->messages());

        try {

            $ciudad = Ciudades::find($values["ciudades_id"]);
            $fecha = $ciudad->nombre . " a los " . today()->day . " del mes de " . Str::ucfirst(today()->monthName) . " del " . today()->year;
            $codigo = $ciudad->prefijo . "-" . $values["numero"];

            $this->certificado->update([

                'numero' => $values["numero"],
                'velocimetro_modelo' => $values["velocimetro_modelo"],
                'vehiculos_id' => $values["vehiculos_id"],
                'ciudades_id' => $values["ciudades_id"],
                'sello' => $values["sello"],
                'fondo' => $values["fondo"],
                'fecha' => $fecha,
                'codigo' => $codigo,
                'observacion' => $values["observacion"],
            ]);
            $this->afterSave($values["numero"]);
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
            tittle: 'CERTIFICADO ACTUALIZADO',
            mensaje: 'Se actualizo correctamente el certificado #' . $numero,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
    public function updated($label)
    {
        $certificadoRequest = new CertificadosVelocimetrosRequest();
        $this->validateOnly($label, $certificadoRequest->rules($this->certificado), $certificadoRequest->messages());
    }
}
