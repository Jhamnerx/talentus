<?php

namespace App\Livewire\Admin\Ajustes\Notificaciones;

use Livewire\Component;
use Livewire\Attributes\On;

class Show extends Component
{
    public $notificaciones, $count;

    protected $listeners = [
        'notificaciones-update' => 'update',
    ];

    public function mount()
    {

        $this->update();
    }

    #[On('notificaciones-update')]
    public function update()
    {

        $this->notificaciones = auth()->user()->notifications()->take(20)->get();
        $this->count = auth()->user()->unreadNotifications->count();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.notificaciones.show');
    }

    public function markRead($notification)
    {
        $notify = auth()->user()->notifications()->findOrFail($notification);
        $notify->markAsRead();
        $this->update();
    }
}
