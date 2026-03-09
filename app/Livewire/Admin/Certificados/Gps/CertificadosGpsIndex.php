<?php

namespace App\Livewire\Admin\Certificados\Gps;

use App\Models\Certificados;
use Livewire\Component;
use Livewire\WithPagination;

class CertificadosGpsIndex extends Component
{
    use WithPagination;
    public $search;
    public $estadoFiltro = '';
    public $vigenciaFiltro = '';

    protected $listeners = [
        'update-table' => 'render',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingEstadoFiltro()
    {
        $this->resetPage();
    }
    public function updatingVigenciaFiltro()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Certificados::query()
            ->where(function ($q) {
                $q->whereHas('ciudades', function ($q2) {
                    $q2->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('prefijo', 'like', '%' . $this->search . '%');
                })->orWhereHas('vehiculo', function ($q2) {
                    $q2->where('placa', 'like', '%' . $this->search . '%')
                        ->orWhereHas('cliente', function ($q3) {
                            $q3->where('razon_social', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('dispositivos', function ($q3) {
                            $q3->where('imei', 'like', '%' . $this->search . '%');
                        });
                })->orWhere('fin_cobertura', 'like', '%' . $this->search . '%')
                    ->orWhere('numero', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha', 'like', '%' . $this->search . '%');
            });

        if ($this->estadoFiltro !== '' && $this->estadoFiltro !== null) {
            $query->where('estado', (int) $this->estadoFiltro);
        }

        if ($this->vigenciaFiltro !== '' && $this->vigenciaFiltro !== null) {
            $today = \Carbon\Carbon::today();
            if ($this->vigenciaFiltro === 'vigente') {
                $query->where('estado', 1)->where('fin_cobertura', '>=', $today);
            } elseif ($this->vigenciaFiltro === 'vencida') {
                $query->where('estado', 1)->where('fin_cobertura', '<', $today);
            }
        }

        $certificados = $query
            ->with('vehiculo.dispositivos.dispositivo.modelo', 'vehiculo.dispositivos')
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
