<?php

namespace App\Livewire\Admin\Notificaciones;

use Illuminate\Notifications\Notification;
use Livewire\Component;

class Importes extends Component
{
    public function render()
    {
        $notificaciones = auth()->user()->notifications()->where('type', 'App\Notifications\Imports\ImportHasFailedNotification')->paginate(20);
        return view('livewire.admin.notificaciones.importes', compact('notificaciones'));
    }

    public function delete($notificacion)
    {

        $notificacion = auth()->user()->notifications()->findOrFail($notificacion);

        $notificacion->delete();
        //$this->render();
    }

    public function deleteAll()
    {

        $notificaciones = auth()->user()->notifications()->where('type', 'App\Notifications\Imports\ImportHasFailedNotification')->get();

        foreach ($notificaciones as $key => $notificacion) {
            $notificacion->delete();
        }
        $this->render();
    }
}
