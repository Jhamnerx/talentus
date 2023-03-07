<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas;

use App\Models\Tareas;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;
use App\Http\Controllers\Admin\UtilesController;
use App\Http\Controllers\Admin\WhatsAppApi;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class TablaHistorial extends Component
{
    use WithPagination;
    public $search = '';
    public $pages = 10;

    protected $listeners = [
        'updateIndex' => 'render'
    ];

    public function render()
    {

        $tareas = Tareas::whereHas('vehiculo', function ($vehiculo) {
            $vehiculo->where('placa', 'LIKE', '%' . $this->search . '%');
        })->orWhereHas('cliente', function ($cliente) {
            $cliente->where('razon_social', 'LIKE', '%' . $this->search . '%');
        })->orWhereHas('user', function ($user) {
            $user->where('name', 'LIKE', '%' . $this->search . '%');
        })->orWhereHas('tipo_tarea', function ($user) {
            $user->where('nombre', 'LIKE', '%' . $this->search . '%');
        })->orWhere('dispositivo', 'LIKE', '%' . $this->search . '%')
            ->orWhere('token', 'LIKE', '%' . $this->search . '%')
            ->orWhere('numero', 'LIKE', '%' . $this->search . '%')
            ->with('vehiculo', 'cliente', 'user', 'tipo_tarea')
            ->orderBy('id', 'desc')
            ->paginate($this->pages);

        return view('livewire.admin.tecnico.tareas.tabla-historial', compact('tareas'));
    }

    public function addTask()
    {
        $this->emit('addTask');
    }

    public function editTask(Tareas $task)
    {
        $this->emit('openModalEdit', $task);
    }

    public function showTecnicos()
    {
        $this->emit('openModalTecnicos');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function pagination($pages)
    {
        $this->pages = $pages;
    }
    public function deleteTask(Tareas $task)
    {

        $this->emit('deleteTarea', $task);
    }

    public function sendGroupWhatsApp(Tareas $task)
    {
        $util = new UtilesController();
        $respuesta = $util->whatsAppSendMessageInstalationGroup($task);
    }

    public function infoTask(Tareas $tarea)
    {
    }

    public function exportTask(Tareas $tarea)
    {
        $pdfContent = PDF::loadView('pdf.reportes.tarea', ['tarea' => $tarea])
            ->setPaper('Legal', 'landscape')->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            "reporte_tarea-" . $tarea->token . ".pdf"
        );
    }


    public function notifyTecnico(Tareas $tarea)
    {
        $whatsApp = new WhatsAppApi();

        if ($tarea->tecnico->telefonos) {

            $respuesta = $whatsApp->notifyTecnico($tarea);

            $this->mensajeRespuesta($respuesta);
            $tarea->sent_message = true;
            $tarea->save();
        } else {

            $this->dispatchBrowserEvent('not-number');
        }
    }

    public function mensajeRespuesta($respuesta): bool
    {

        if ($respuesta->httpStatusCode() == 200) {

            $this->dispatchBrowserEvent('mensaje-enviado');

            return true;
        } else {

            $this->dispatchBrowserEvent('error-mensaje-whatsapp', ['error' => $respuesta->responseData()['error']['message']]);
            return false;
        }
    }
}
