<?php

namespace App\Observers;

use App\Models\DeviceHistory;

class DeviceHistoryObserver
{
    public function creating(DeviceHistory $deviceHistory): void
    {
        if (!app()->runningInConsole()) {
            $deviceHistory->empresa_id = session('empresa');
        }
    }
}
