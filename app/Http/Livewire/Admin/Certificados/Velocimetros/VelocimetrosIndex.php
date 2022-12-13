<?php

namespace App\Http\Livewire\Admin\Certificados\Velocimetros;

use App\Models\CertificadosVelocimetros;
use Livewire\Component;
use Livewire\WithPagination;

class VelocimetrosIndex extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';

    public $openModalSave = false;
    public $openModalEdit = false;
    public $openModalDelete = false;
    public $openModalAddVehiculo = false;

    protected $listeners = [
        'updateTable' => 'render',
    ];

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $certificados = CertificadosVelocimetros::whereHas('vehiculo', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%')
                ->orwhere('motor', 'like', '%' . $this->search . '%');
        })->orwhereHas('ciudades', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orderBy('numero', 'desc')
            ->paginate(10);

        $total = CertificadosVelocimetros::all()->count();
        if (!empty($desde)) {


            $certificados = CertificadosVelocimetros::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(fecha like ? OR numero like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('id', 'desc')
                ->paginate(10);
        }
        return view('livewire.admin.certificados.velocimetros.velocimetros-index', compact('certificados', 'total'));
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 7 days"));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 month"));
                $this->to = date('Y-m-d');
                break;
            case '12':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 year"));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }
    public function openModalSave()
    {
        $this->emit('guardarCertificado');
        $this->openModalSave = true;
    }

    //Enviar datos para editar Certificado
    public function openModalEdit(CertificadosVelocimetros $certificado)
    {
        $this->emit('actualizarCertificado', $certificado);
        $this->openModalEdit = true;
    }

    public function openModalDelete(CertificadosVelocimetros $certificado)
    {
        $this->emit('EliminarCertificado', $certificado);
        $this->openModalDelete = true;
    }


    public function openModalShow(CertificadosVelocimetros $certificado)
    {
        $this->emit('verDetalleCertificado', $certificado);
        $this->openModalDetalle = true;
    }

    public function openModalAddVehiculo()
    {

        $this->emit('openModalAddVehiculo');
        $this->openModalAddVehiculo = true;
    }

    public function cambiarEstado(CertificadosVelocimetros $certificado, $field, $value)
    {
        $certificado->setAttribute($field, $value)->save();
        $this->render();
    }
    public function modalOpenSend(CertificadosVelocimetros $certificado)
    {
        $this->emit('modalOpenSend', $certificado);
    }
}
