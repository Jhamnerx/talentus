<?php

namespace App\Events;

use App\Models\Actas;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class nuevaActaCreada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $acta;

    public function __construct(Actas $acta)
    {
        $this->acta = $acta;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
