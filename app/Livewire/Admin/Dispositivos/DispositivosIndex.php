<?php

namespace App\Livewire\Admin\Dispositivos;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Dispositivos;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Http\Controllers\Admin\FotaWebApiController;

class DispositivosIndex extends Component
{
    use WithPagination;
    #[Url(except: '')]
    public $search = '';

    protected $listeners = ['render' => 'render'];

    public function render()
    {

        $dispositivos = Dispositivos::whereHas('modelo', function ($query) {
            $query->where('marca', 'like', '%' . $this->search . '%')
                ->orWhere('modelo', 'like', '%' . $this->search . '%');
        })->orwhereHas('vehiculos', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%');
        })->orwhereHas('user', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->orWhere('imei', 'like', '%' . $this->search . '%')
            ->orWhere('estado', 'like', $this->search === "Equipo Disponible" ? '%STOCK%' : '%' . $this->search . '%')
            ->orWhere('in_fota', 'like', $this->search === "no fota" ? false : '%' . $this->search . '%')
            ->orwhereDate('created_at', $this->validateDate($this->search) ? Carbon::createFromFormat('d-m-Y', $this->search)->format('Y-m-d') : '')
            ->with('vehiculos', 'modelo')
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('livewire.admin.dispositivos.dispositivos-index', compact('dispositivos'));
    }

    #[On('update-table')]
    public function updateTable()
    {
        $this->render();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


    public function verInfoDispositivo(Dispositivos $dispositivo)
    {

        $this->dispatch('show-info-dispositivo', $dispositivo);
    }


    public function consultaFota()
    {

        $dispositivos = Dispositivos::where('consultado', false)->whereHas('modelo', function ($query) {
            $query
                ->Where('marca', 'TELTONIKA');
        })->get();

        $api = new FotaWebApiController();

        foreach ($dispositivos as $key => $dispositivo) {

            $device = $api->getDevice($dispositivo->imei);

            if ($device) {
                $dispositivo->in_fota = true;
                $dispositivo->consultado = true;
                $dispositivo->save();
            }
        }
        $this->afterSave();
    }

    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'SE HA CONSULTADO A FOTA WEB',
            mensaje: 'se ha completado la consulta correctamente a la api de fota web'
        );

        $this->render();
    }

    public function openModalCreate()
    {

        $this->dispatch('open-modal-create');
    }
}
