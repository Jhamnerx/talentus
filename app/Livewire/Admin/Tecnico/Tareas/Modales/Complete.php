<?php

namespace App\Livewire\Admin\Tecnico\Tareas\Modales;

use App\Models\Tareas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\WhatsAppApi;
use App\Http\Controllers\Admin\UtilesController;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\ImageManager;

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
            ->with('vehiculo', 'cliente', 'user', 'tipo_tarea', 'image')
            ->estado('COMPLETE')
            ->orderBy('id', 'desc')
            ->paginate(10, ['*'], 'completePage');

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
    public function closeModal()
    {
        $this->openModal = false;
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
        try {
            $img = $this->resizeImagen($image);
            Storage::disk('local')->put('public/tareas' . '/' . $tarea->token . '.png', $img, 'public');

            $tarea->image()->create([
                'url' => 'tareas/' . $tarea->token . '.png',
            ]);

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'IMAGEN GUARDADA',
                mensaje: 'Se guardo la imagen para la tarea: #' . $tarea->token,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL GUARDAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
    }

    public static function resizeImagen($img)
    {
        // create new image manager with gd driver
        $manager = ImageManager::gd();

        $image = $manager->read($img->getRealPath());

        $image->scale(height: 600);
        // $image->resize(400, 400);

        return $image->encode();
    }
    public function refreshComponent()
    {
        $this->render();
    }
    public function openModalNotificationClient(Tareas $tarea)
    {
        $this->dispatch('send-notificacion-client', $tarea);
    }
    public function verModalImagen(Tareas $tarea)
    {
        $this->dispatch('open-modal-imagen', tarea: $tarea);
    }
}
