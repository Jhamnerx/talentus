<?php

namespace App\Http\Livewire\Admin\Gerencia\Reportes;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class HistorialModels extends Component
{
    public $search = "";

    public function render()
    {
        $activities = Activity::whereHas('causer', function ($query) {

            $query->where('name', 'like', '%' . $this->search . '%');
        })->orwhere('description', 'LIKE', '%' . $this->search . '%')->orderBy('id', 'desc')->paginate(10);
        return view('livewire.admin.gerencia.reportes.historial-models', compact('activities'));
    }

    public function restart($model, $id)
    {
        $class = "App\\Models\\" . $model;
        $result = $class::withTrashed()->findOrFail($id);

        $result->disableLogging();
        $result->restore();
        $this->dispatchBrowserEvent('restore-model');
    }

    public function delete($model, $id)
    {
        $class = "App\\Models\\" . $model;
        $result = $class::withTrashed()->findOrFail($id);

        $this->dispatchBrowserEvent('delete-model');
        $result->forceDelete();
    }
}
