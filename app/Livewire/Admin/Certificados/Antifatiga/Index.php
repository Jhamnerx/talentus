<?php

namespace App\Livewire\Admin\Certificados\Antifatiga;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CertificadosAntifatiga;

class Index extends Component
{
    use WithPagination;

    public $search;

    protected $listeners = [
        'update-table' => 'render',
    ];

    public function render()
    {

        $query = CertificadosAntifatiga::query();

        $query->whereHas('ciudades', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('prefijo', 'like', '%' . $this->search . '%');
        })->orWhereHas('vehiculo', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%');
        })->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
            ->orWhere('fecha_instalacion', 'like', '%' . $this->search . '%')
            ->orWhere('inicio_cobertura', 'like', '%' . $this->search . '%')
            ->orWhere('fin_cobertura', 'like', '%' . $this->search . '%');


        $certificados = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.certificados.antifatiga.index', compact('certificados'));
    }


    public function openModalSave()
    {
        $this->dispatch('open-modal-save');
    }

    //Enviar datos para editar certificado
    public function openModalEdit(CertificadosAntifatiga $certificado)
    {
        $this->dispatch('actualizarCertificado', certificado: $certificado);
    }


    public function openModalDelete(CertificadosAntifatiga $certificado)
    {
        $this->dispatch('EliminarActa', certificado: $certificado);
    }

    public function openModalShow(CertificadosAntifatiga $certificado)
    {
        $this->dispatch('verDetalleActa', certificado: $certificado);
        //$this->openModalDetalle = true;
    }

    public function cambiarEstado(CertificadosAntifatiga $certificado, $field, $value)
    {
        $certificado->setAttribute($field, $value)->save();
    }

    public function modalOpenSend(CertificadosAntifatiga $certificado)
    {

        $this->dispatch('modalOpenSend', certificado: $certificado); // Abre el modal para enviar el certificado         
    }

    public function toggleStatus(CertificadosAntifatiga $certificado)
    {
        $certificado->estado = !$certificado->estado; // Cambia el estado del toggle
        $certificado->save(); // Guarda el cambio en el modelo
    }
    public function toggleSello(CertificadosAntifatiga $certificado)
    {
        $certificado->sello = !$certificado->sello; // Cambia el estado del toggle
        $certificado->save(); // Guarda el cambio en el modelo
    }

    public function toggleFondo(CertificadosAntifatiga $certificado)
    {
        $certificado->fondo = !$certificado->fondo; // Cambia el estado del toggle
        $certificado->save(); // Guarda el cambio en el modelo
    }
}
