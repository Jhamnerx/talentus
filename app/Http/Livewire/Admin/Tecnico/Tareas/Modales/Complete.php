<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas\Modales;

use App\Http\Controllers\Admin\UtilesController;
use App\Models\Tareas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class Complete extends Component
{
    use WithPagination, WithFileUploads;


    public $openModal = false;
    public $search = '';
    public $imagen = [];
    protected $listeners = [
        'openModalComplete' => 'openModal',
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
            ->with('vehiculo', 'cliente', 'user', 'tipo_tarea')
            ->estado('COMPLETE')->with('vehiculo', 'cliente', 'user', 'tipo_tarea')
            ->paginate(5, ['*'], 'completePage');

        return view('livewire.admin.tecnico.tareas.modales.complete', compact('tareas'));
    }
    public function updatingSearch()
    {
        $this->resetPage('completePage');
    }
    public function openModal()
    {
        $this->openModal = true;
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

        $this->dispatchBrowserEvent('save-imagen', ['tarea' => $tarea->token]);
    }

    public function sendWhatsApp(Tareas $task)
    {
        $util = new UtilesController();
        $respuesta = $util->whatsAppSendMessageInstalation($task);
        $task->sent_message = true;
        $task->save();
    }
}
