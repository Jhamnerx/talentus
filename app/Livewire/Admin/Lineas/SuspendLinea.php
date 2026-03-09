<?php

namespace App\Livewire\Admin\Lineas;

use Carbon\Carbon;
use App\Models\Lineas;
use App\Models\CambiosLineas;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\WireUiActions;

class SuspendLinea extends Component
{
    use WireUiActions;

    public $fecha_suspencion, $date_to_suspend, $baja = false;

    protected $rules = [
        'fecha_suspencion' => 'required|date',
        "date_to_suspend"  => "required|date",
        "baja"  => "required",
    ];

    protected $messages = [
        'fecha_suspencion.required' => 'La fecha de suspensión es requerida',
        'fecha_suspencion.date' => 'Formato de fecha inválido',
        "date_to_suspend.required"  => "La fecha de reactivación es requerida",
        "date_to_suspend.date"  => "Formato de fecha inválido",
        "baja.required"  => "Debe indicar si es baja definitiva",
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

        // Combinar fecha seleccionada con hora actual del sistema
        $fechaSuspencion = Carbon::parse($this->fecha_suspencion)
            ->setTimeFrom(Carbon::now());

        // Actualizar líneas y registrar cambios
        foreach ($this->lineas as $linea) {
            $linea->update([
                'fecha_suspencion' => $fechaSuspencion,
                'date_to_suspend' => $this->date_to_suspend,
                'baja' => $this->baja,
                'estado' => 2,
            ]);

            // Registrar en historial de cambios
            CambiosLineas::create([
                'tipo_cambio' => $this->baja
                    ? 'Suspensión - Baja definitiva'
                    : 'Suspensión - Reactivable',
                'sim_card_id' => $linea->sim_card_id,
                'old_numero' => $linea->id,
                'new_numero' => $linea->id,
                'fecha_suspencion' => $fechaSuspencion,
                'fecha_suspencion_fin' => $this->date_to_suspend,
                'user_id' => Auth::id(),
            ]);
        }

        $cantidad = count($this->items);
        $mensaje = $cantidad === 1
            ? "Línea {$this->items[0]} suspendida correctamente"
            : "{$cantidad} líneas suspendidas correctamente";

        $this->notification()->success(
            'Suspensión aplicada',
            $mensaje
        );

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
