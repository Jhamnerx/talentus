<?php

namespace App\Observers;

use App\Models\Transport;

class TransportObserver
{
    public function creating(Transport $transport): void
    {
        if (!\App::runningInConsole()) {
            $transport->empresa_id = session('empresa');
        }
    }
}
