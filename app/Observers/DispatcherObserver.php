<?php

namespace App\Observers;

use App\Models\Dispatcher;

class DispatcherObserver
{
    public function creating(Dispatcher $dispatcher): void
    {
        if (!\App::runningInConsole()) {
            $dispatcher->empresa_id = session('empresa');
        }
    }
}
