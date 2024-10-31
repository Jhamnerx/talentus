<?php

namespace App\Livewire\Admin\Vehiculos;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Exports\VehiculosExport;
use Maatwebsite\Excel\Facades\Excel;

class VehiculosIndex extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';

    protected $listeners = [
        'update-table' => 'render',
        'echo:vehiculos,VehiculosImportUpdated' => 'updateVehiculos'
    ];

    public function updateVehiculos()
    {
        $this->render();
        $this->dispatch('vehiculos-import');
    }

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $vehiculos = Vehiculos::whereHas('sim_card', function ($query) {
            $query->where('sim_card', 'LIKE', '%' . $this->search . '%')
                ->orWhere('operador', 'LIKE', '%' . $this->search . '%');
            $query->orwhereHas('linea', function ($linea) {
                $linea->where('numero', 'LIKE', '%' . $this->search . '%');
            });
        })->orwhereHas('cliente', function ($query) {

            $query->where('razon_social', 'LIKE', '%' . $this->search . '%');
        })->orwhereHas('dispositivos', function ($query) {
            $query->where('imei', 'LIKE', '%' . $this->search . '%');
        })->orWhere('placa', 'like', '%' . $this->search . '%')
            ->orWhere('marca', 'like', '%' . $this->search . '%')
            ->orWhere('modelo', 'like', '%' . $this->search . '%')
            ->orWhere('tipo', 'like', '%' . $this->search . '%')
            ->orWhere('color', 'like', '%' . $this->search . '%')
            ->orWhere('motor', 'like', '%' . $this->search . '%')
            ->orWhere('serie', 'like', '%' . $this->search . '%')
            ->orWhere('dispositivo_imei', 'like', '%' . $this->search . '%')
            ->orWhere('old_numero', 'like', '%' . $this->search . '%')
            ->orWhere('old_sim_card', 'like', '%' . $this->search . '%')
            ->orWhere('year', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(15);




        $total = Vehiculos::all()->count();


        if (!empty($desde)) {


            $vehiculos = Vehiculos::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(placa like ? OR marca like  ? OR tipo like ? OR year like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('id')
                ->paginate(15);
        }
        return view('livewire.admin.vehiculos.vehiculos-index', compact('vehiculos', 'total'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
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
        $this->dispatch('open-modal-save');
    }

    public function openModalEdit(Vehiculos $vehiculo)
    {
        $this->dispatch('open-modal-edit', vehiculo: $vehiculo);
    }

    public function openModalImport()
    {

        $this->dispatch('open-modal.import');
    }


    public function deleteVehiculo(Vehiculos $vehiculo)
    {
        $this->dispatch('open-modal-delete', vehiculo: $vehiculo);
    }

    public function suspendVehiculo(Vehiculos $vehiculo)
    {
        $this->dispatch('open-modal-suspend-vehiculo', $vehiculo);
    }

    public function createMantenimiento(Vehiculos $vehiculo)
    {
        $this->dispatch('open-modal-save-mantenimiento', from: 'vehiculos-index', vehiculo: $vehiculo);
    }

    public function openModalAddVehiculo()
    {

        $this->dispatch('open-modal-add-vehiculo');
    }

    //EVENTO QUE ESCUCHA DESDE LA VISTA AL CAMBIAR EL NUMERO Y ABRIR EL MODAL
    #[On('create-mantenimiento')]
    public function openModalCreateMantenimiento($placa)
    {
        $this->dispatch('open-modal-mantenimiento', placa: $placa);
    }

    public function exportVehiculos()
    {
        try {
            $nombre = 'vehiculos_' . Carbon::now()->format('d-m') . '.xls';

            return Excel::download(new VehiculosExport,  $nombre);
        } catch (\Throwable $th) {

            $this->dispatch(
                'notify',
                icon: 'error',
                title: 'ERROR AL EXPORTAR',
                mensaje: 'No se pudo exportar: ' . $th->getMessage(),
            );
        }
    }

    public function getDevicesWox()
    {
        $this->dispatch('get-devices-wox');
    }

    public function openModalInfoWox(Vehiculos $vehiculo)
    {
        $this->dispatch('open-modal-info-wox', vehiculo: $vehiculo);
    }
}
