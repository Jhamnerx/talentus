<?php

namespace App\Livewire\Admin\Certificados\Velocimetros;

use App\Models\CertificadosVelocimetros;
use Livewire\Component;
use Livewire\WithPagination;

class VelocimetrosIndex extends Component
{
    use WithPagination;
    public $search;

    protected $listeners = [
        'update-table' => 'render',
    ];

    public function render()
    {

        $certificados = CertificadosVelocimetros::whereHas('vehiculo', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%')
                ->orwhere('motor', 'like', '%' . $this->search . '%');
        })->orwhereHas('ciudades', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orderBy('numero', 'desc')
            ->paginate(10);


        return view('livewire.admin.certificados.velocimetros.velocimetros-index', compact('certificados'));
    }


    public function openModalSave()
    {
        $this->dispatch('guardarCertificado');
    }

    //Enviar datos para editar Certificado
    public function openModalEdit(CertificadosVelocimetros $certificado)
    {
        $this->dispatch('actualizarCertificado', $certificado);
    }

    public function openModalDelete(CertificadosVelocimetros $certificado)
    {
        $this->dispatch('EliminarCertificado', $certificado);
    }


    public function openModalShow(CertificadosVelocimetros $certificado)
    {
        $this->dispatch('verDetalleCertificado', $certificado);
    }

    public function openModalAddVehiculo()
    {
        $this->dispatch('open-modal-add-vehiculo');
    }

    public function cambiarEstado(CertificadosVelocimetros $certificado, $field, $value)
    {
        $certificado->setAttribute($field, $value)->save();
        $this->render();
    }
    public function modalOpenSend(CertificadosVelocimetros $certificado)
    {
        $this->dispatch('modalOpenSend', $certificado);
    }

    public function toggleSello(CertificadosVelocimetros $certificado)
    {
        $certificado->sello = !$certificado->sello; // Cambia el estado del toggle
        $certificado->save(); // Guarda el cambio en el modelo
    }

    public function toggleFondo(CertificadosVelocimetros $certificado)
    {
        $certificado->fondo = !$certificado->fondo; // Cambia el estado del toggle
        $certificado->save(); // Guarda el cambio en el modelo
    }
}
