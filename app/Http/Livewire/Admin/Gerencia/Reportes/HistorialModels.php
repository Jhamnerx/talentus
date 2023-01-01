<?php

namespace App\Http\Livewire\Admin\Gerencia\Reportes;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class HistorialModels extends Component
{
    public function render()
    {
        $activities = Activity::paginate(10);
        return view('livewire.admin.gerencia.reportes.historial-models', compact('activities'));
    }
}
