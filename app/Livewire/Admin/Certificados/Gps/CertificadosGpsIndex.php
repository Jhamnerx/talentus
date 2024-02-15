<?php

namespace App\Livewire\Admin\Certificados\Gps;

use App\Models\Certificados;
use Livewire\Component;
use Livewire\WithPagination;

class CertificadosGpsIndex extends Component
{
    use WithPagination;
    public $search;


    protected $listeners = [
        'update-table' => 'render',
    ];

    public function render()
    {

        $certificados = Certificados::whereHas('ciudades', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orwhere('prefijo', 'like', '%' . $this->search . '%');
        })->orwhereHas('vehiculo', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%');
            $query->orWhereHas('cliente', function ($cliente) {
                $cliente->where('razon_social', 'like', '%' . $this->search . '%');
            });
        })->orWhere('fin_cobertura', 'like', '%' . $this->search . '%')
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->with('vehiculo.dispositivos.modelo', 'vehiculo.dispositivos')
            ->orderBy('numero', 'desc')
            ->paginate(10);

        return view('livewire.admin.certificados.gps.certificados-gps-index', compact('certificados'));
    }

    public function openModalSave()
    {
        $this->dispatch('guardarCertificado');
    }

    //Enviar datos para editar Certificado
    public function openModalEdit(Certificados $certificado)
    {
        $this->dispatch('actualizarCertificado', $certificado);
    }


    public function openModalDelete(Certificados $certificado)
    {
        $this->dispatch('EliminarCertificado', certificado: $certificado);
    }


    public function openModalShow(Certificados $certificado)
    {
        $this->dispatch('verDetalleCertificado', $certificado);
    }

    public function cambiarEstado(Certificados $certificado, $field, $value)
    {
        $certificado->setAttribute($field, $value)->save();
        $this->render();
    }

    public function modalOpenSend(Certificados $certificado)
    {
        $this->dispatch('modalOpenSend', certificado: $certificado);
    }

    public function toggleSello(Certificados $certificado)
    {
        $certificado->sello = !$certificado->sello; // Cambia el estado del toggle
        $certificado->save(); // Guarda el cambio en el modelo
    }

    public function toggleFondo(Certificados $certificado)
    {
        $certificado->fondo = !$certificado->fondo; // Cambia el estado del toggle
        $certificado->save(); // Guarda el cambio en el modelo
    }
}
