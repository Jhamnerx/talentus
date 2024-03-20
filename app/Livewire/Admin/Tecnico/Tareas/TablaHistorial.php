<?php

namespace App\Livewire\Admin\Tecnico\Tareas;

use App\Models\Tareas;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Admin\WhatsAppApi;
use App\Http\Controllers\Admin\UtilesController;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class TablaHistorial extends Component
{
    use WithPagination;
    public $search = '';
    public $pages = 10;

    protected $listeners = [
        'updateIndex' => 'render',
        'update-unread' => 'render',
        'update-table-save-task' => 'render'
    ];

    public function render()
    {

        $tareas = Tareas::whereHas('vehiculo', function ($vehiculo) {
            $vehiculo->where('placa', 'LIKE', '%' . $this->search . '%');
        })->orWhereHas('cliente', function ($cliente) {
            $cliente->where('razon_social', 'LIKE', '%' . $this->search . '%');
        })->orWhereHas('tecnico', function ($user) {
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
        $this->dispatch('addTask');
    }

    public function editTask(Tareas $task)
    {
        $this->dispatch('openModalEdit', $task);
    }

    public function showTecnicos()
    {
        $this->dispatch('openModalTecnicos');
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

        $this->dispatch('deleteTarea', $task);
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
            ->setOption(['isHtml5ParserEnabled' => true])->setPaper('Legal')->output();

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

            $this->dispatch('not-number');
        }
    }

    public function mensajeRespuesta($respuesta): bool
    {

        if ($respuesta->httpStatusCode() == 200) {

            $this->dispatch('mensaje-enviado');

            return true;
        } else {

            $this->dispatch('error-mensaje-whatsapp', ['error' => $respuesta->responseData()['error']['message']]);
            return false;
        }
    }
    public function openModalInform(Tareas $tarea)
    {
        $this->dispatch('open-modal-inform', $tarea);
    }

    public function refreshComponent()
    {
        $this->render();
    }

    #[On(['render-cancel', 'update-unread', 'update-table-save-task'])]
    public function updateTo()
    {
        $this->refreshComponent();
    }
}
