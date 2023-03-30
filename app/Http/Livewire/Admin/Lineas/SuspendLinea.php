<?php

namespace App\Http\Livewire\Admin\Lineas;

use Carbon\Carbon;
use App\Models\Lineas;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx\Theme;

class SuspendLinea extends Component
{

    protected $listeners = [
        'open-modal-suspend' => 'openModal',
    ];


    public $fecha_suspencion, $date_to_suspend;


    public Collection $lineas;
    public $items = [];

    public $openModal = false;

    public function mount()
    {
        $this->fecha_suspencion = Carbon::now()->format('Y-m-d');
        $this->date_to_suspend = Carbon::now()->addDays(60)->format('Y-m-d');
    }


    public function render()
    {
        return view('livewire.admin.lineas.suspend-linea');
    }


    public function openModal($items)
    {
        $this->items =  $items;

        $lineas = Lineas::whereIn('numero', $items)->get();

        $this->lineas =  $lineas;

        $this->openModal = true;
    }

    public function closeModal()
    {
        $this->openModal = false;
    }


    public function save()
    {

        $this->lineas->toQuery()->update([
            'fecha_suspencion' => $this->fecha_suspencion,
            'date_to_suspend' => $this->date_to_suspend,
            'estado' => 2,
        ]);


        $lista = '<ul class="list-disc">';

        foreach ($this->items as $item) {

            $lista .= '<li>' . $item . '</li>';
        }

        $lista .= '</ul>';


        $this->dispatchBrowserEvent('suspend-save', ['lista' => $lista]);

        $this->closeModal();
    }
}
