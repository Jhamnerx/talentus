<?php

namespace App\Observers;

use App\Models\Driver;

class DriverObserver
{
    public function creating(Driver $driver): void
    {
        if (!\App::runningInConsole()) {
            $driver->empresa_id = session('empresa');
        }
    }
}
