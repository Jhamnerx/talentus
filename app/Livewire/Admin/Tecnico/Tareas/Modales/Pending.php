<?php

namespace App\Livewire\Admin\Tecnico\Tareas\Modales;

use App\Models\Tareas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\UtilesController;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class Pending extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $openModal = false;
    public $search = '';
    public $imagen = [];

    protected $listeners = [
        'openModalPending' => 'openModal',
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
            ->orWhere('numero', 'LIKE', '%' . $this->search . '%')
            ->with('vehiculo', 'cliente', 'user', 'tipo_tarea', 'image')
            ->estado('PENDIENT')->with('vehiculo', 'cliente', 'user', 'tipo_tarea')
            ->paginate(5, ['*'], 'PendientPage');
        return view('livewire.admin.tecnico.tareas.modales.pending', compact('tareas'));
    }

    public function updatingSearch()
    {
        $this->resetPage('PendientPage');
    }
    public function openModal()
    {
        $this->openModal = true;
    }

    public function closeModal()
    {
        $this->openModal = false;
    }

    public function cancelTask(Tareas $task)
    {
        $task->estado = "CANCELED";
        $task->fecha_termino = Carbon::now();
        $task->save();
        $this->dispatch('update-task', ['titulo' => 'TAREA CANCELADA', 'message' => 'Se cancelo la tarea',  'token' => $task->token, 'color' => '#f87171', 'progressBarColor' => 'rgb(255,255,255)']);
        $this->render();
        $this->dispatch('update-unread');
    }
    public function markComplete(Tareas $task)
    {
        $task->estado = "COMPLETE";
        $task->fecha_termino = Carbon::now();
        $task->save();
        $this->dispatch('update-task', ['titulo' => 'TAREA COMPLETADA', 'message' => 'Se marco como completada la tarea',  'token' => $task->token, 'color' => '#34d399', 'progressBarColor' => 'rgb(255,255,255)']);
        $this->render();
        $this->dispatch('update-unread');
    }
    public function updatedImagen($value, $key)
    {

        $this->validate([
            'imagen.*' => 'image',
        ]);

        $tarea = Tareas::find($key);

        $this->saveImagen($tarea, $value);
    }

    public function saveImagen(Tareas $tarea, $image)
    {
        $img = Image::make($image->getRealPath())->encode('jpg', 65)->fit(760, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });

        Storage::disk('local')->put('public/tareas' . '/' . $tarea->token . '.png', $img, 'public');

        $tarea->image()->create([
            'url' => 'tareas/' . $tarea->token . '.png',
        ]);

        $this->dispatch('save-imagen', ['tarea' => $tarea->token]);
    }

    public function refreshComponent()
    {
        $this->render();
    }
    public function sendWhatsApp(Tareas $task)
    {
        $util = new UtilesController();
        $respuesta = $util->whatsAppSendMessageInstalation($task);
        $task->sent_message = true;
        $task->save();
    }
    public function openModalNotificationClient(Tareas $tarea)
    {
        $this->dispatch('send-notificacion-client', $tarea);
    }
}
