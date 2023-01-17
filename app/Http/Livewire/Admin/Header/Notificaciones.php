<?php

namespace App\Http\Livewire\Admin\Header;

use Livewire\Component;

class Notificaciones extends Component
{
    public $notificaciones, $count;

    protected $listeners = [
        'notificaciones-update' => 'update',
    ];


    public function mount()
    {

        $this->update();
    }

    public function update()
    {

        $this->notificaciones = auth()->user()->notifications()->take(10)->get();
        $this->count = auth()->user()->unreadNotifications->count();
    }

    public function render()
    {
        return view('livewire.admin.header.notificaciones');
    }

    public function resetNotificacion()
    {
    }
    public function markRead($notification)
    {
        $notify = auth()->user()->notifications()->findOrFail($notification);
        $notify->markAsRead();
        $this->update();
    }
}
