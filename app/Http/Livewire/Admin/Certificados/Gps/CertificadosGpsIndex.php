<?php

namespace App\Http\Livewire\Admin\Certificados\Gps;

use App\Models\Certificados;
use Livewire\Component;
use Livewire\WithPagination;

class CertificadosGpsIndex extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';

    public $openModalSave = false;
    public $openModalEdit = false;
    public $openModalDelete = false;

    protected $listeners = [
        'updateTable' => 'render',
    ];

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;


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
            ->orderBy('numero', 'desc')
            ->paginate(10);

        $total = Certificados::all()->count();
        if (!empty($desde)) {


            $certificados = Certificados::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(fecha like ? OR fin_cobertura like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('id')
                ->paginate(10);
        }
        return view('livewire.admin.certificados.gps.certificados-gps-index', compact('certificados', 'total'));
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
    public function openModalEdit(Certificados $certificado)
    {
        dd($certificado);
        $this->emit('actualizarCertificado', $certificado);
        $this->openModalEdit = true;
    }


    public function openModalDelete(Certificados $certificado)
    {
        $this->emit('EliminarCertificado', $certificado);
        $this->openModalDelete = true;
    }




    public function openModalShow(Certificados $certificado)
    {
        $this->emit('verDetalleCertificado', $certificado);
        $this->openModalDetalle = true;
    }

    public function cambiarEstado(Certificados $certificado, $field, $value)
    {
        $certificado->setAttribute($field, $value)->save();
        $this->render();
    }
}
