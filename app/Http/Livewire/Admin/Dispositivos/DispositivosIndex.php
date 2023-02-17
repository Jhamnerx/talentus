<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Dispositivos;
use Livewire\WithPagination;
use App\Http\Controllers\Admin\FotaWebApiController;
use DateTime;

class DispositivosIndex extends Component
{
    use WithPagination;
    public $search;
    public $estado = 0;

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


        if ($this->estado == "VENDIDO") {

            $dispositivos = Dispositivos::whereHas('modelo', function ($query) {
                $query->where('marca', 'like', '%' . $this->search . '%')
                    ->orWhere('modelo', 'like', '%' . $this->search . '%');
            })->orwhereHas('vehiculos', function ($query) {
                $query->where('placa', 'like', '%' . $this->search . '%');
            })->orWhere('imei', 'like', '%' . $this->search . '%')
                ->vendido()
                ->with('vehiculos', 'modelo')
                ->orderBy('id', 'desc')
                ->paginate(10);
        }

        if ($this->estado == "STOCK") {

            $dispositivos = Dispositivos::whereHas('modelo', function ($query) {
                $query->where('marca', 'like', '%' . $this->search . '%')
                    ->orWhere('modelo', 'like', '%' . $this->search . '%');
            })->orwhereHas('vehiculos', function ($query) {
                $query->where('placa', 'like', '%' . $this->search . '%');
            })->orWhere('imei', 'like', '%' . $this->search . '%')
                ->stock()
                ->with('vehiculos', 'modelo')
                ->orderBy('id', 'desc')
                ->paginate(10);
        }

        return view('livewire.admin.dispositivos.dispositivos-index', compact('dispositivos'));
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

    public function filter($estado)
    {
        $this->estado = $estado;
        $this->resetPage();
    }

    public function verInfoDispositivo(Dispositivos $dispositivo)
    {

        $this->emit('show-info-dispositivo', $dispositivo);
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

        $this->dispatchBrowserEvent('consulta-finish', ['cantidad' => $dispositivos->count()]);
        $this->render();
    }
}
