<?php

namespace App\Observers;

use App\Models\Plan;

class PlanObserver
{
    public function creating(Plan $plan): void
    {
        if (!\App::runningInConsole()) {
            $plan->empresa_id = session('empresa');
        }
    }
}
