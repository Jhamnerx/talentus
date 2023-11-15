<?php

namespace App\Livewire\Admin\Certificados\Actas;

use App\Http\Controllers\Admin\UtilesController;
use App\Models\Actas;
use Livewire\Component;
use Livewire\WithPagination;
use Vinkla\Hashids\Facades\Hashids;

class ActasIndex extends Component
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

        $actas = Actas::whereHas('ciudades', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orwhere('prefijo', 'like', '%' . $this->search . '%');
        })->orwhereHas('vehiculo', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%');
        })->orWhere('inicio_cobertura', 'like', '%' . $this->search . '%')
            ->orWhere('fecha_instalacion', 'like', '%' . $this->search . '%')
            ->orWhere('fin_cobertura', 'like', '%' . $this->search . '%')
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $total = Actas::all()->count();
        if (!empty($desde)) {

            $actas = Actas::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(inicio_cobertura like ? OR fecha like ? OR fin_cobertura like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('livewire.admin.certificados.actas.actas-index', compact('actas', 'total'));
    }

    public function filter($dias)
    {
        $this->search = null;
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
        $this->dispatch('guardarActa');
        $this->openModalSave = true;
    }

    //Enviar datos para editar acta
    public function openModalEdit(Actas $acta)
    {
        $this->dispatch('actualizarActa', $acta);
        $this->openModalEdit = true;
    }


    public function openModalDelete(Actas $acta)
    {
        $this->dispatch('EliminarActa', $acta);
        $this->openModalDelete = true;
    }

    public function openModalShow(Actas $acta)
    {
        $this->dispatch('verDetalleActa', $acta);
        //$this->openModalDetalle = true;
    }

    public function cambiarEstado(Actas $acta, $field, $value)
    {
        $acta->setAttribute($field, $value)->save();
    }
    public function modalOpenSend(Actas $acta)
    {

        $this->dispatch('modalOpenSend', $acta);
    }

    public function openModalImport()
    {

        $this->dispatch('openModalImport');
    }
    public function test(Actas $acta)
    {

        $hash = Hashids::connection(Actas::class)->encode($acta->id);


        dd($hash);
        // $ctr = new UtilesController();

        // $value = $ctr->test();
        // dd($value);



    }
}
