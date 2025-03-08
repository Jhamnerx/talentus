<?php

namespace App\Livewire\Admin\Lineas;

use Carbon\Carbon;
use App\Models\Lineas;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx\Theme;

class SuspendLinea extends Component
{

    public $fecha_suspencion, $date_to_suspend, $baja = false;

    protected $rules = [

        'fecha_suspencion' => 'required|date',
        "date_to_suspend"  => "required|date",
        "baja"  => "required",

    ];
    protected $messages = [

        'fecha_suspencion.required' => 'La fecha es requerida',
        'fecha_suspencion.date' => 'Usa un formato de fecha',
        "date_to_suspend.required"  => "La fecha es requerida",
        "date_to_suspend.date"  => "Usa un formato de fecha",
        "baja.required"  => "required",

    ];


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

    #[On('open-modal-suspend')]
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

        $this->validate();
        $this->lineas->toQuery()->update([
            'fecha_suspencion' => $this->fecha_suspencion,
            'date_to_suspend' => $this->date_to_suspend,
            'baja' => $this->baja,
            'estado' => 2,
        ]);


        $lista = '<ul class="list-disc">';

        foreach ($this->items as $item) {

            $lista .= '<li>' . $item . '</li>';
        }

        $lista .= '</ul>';

        $this->dispatch('suspend-save', lista: $lista);

        $this->closeModal();
    }
    public function updated($attr)
    {
        $this->validateOnly($attr);
    }
}
