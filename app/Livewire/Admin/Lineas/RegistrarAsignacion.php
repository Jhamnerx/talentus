<?php

namespace App\Livewire\Admin\Lineas;

use App\Models\CambiosLineas;
use App\Models\Lineas;
use App\Models\Operador;
use App\Models\SimCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class RegistrarAsignacion extends Component
{
    use WireUiActions;

    public bool $openModal = false;
    public ?int $operadorId = null;
    public string $textoRespuesta = '';
    public ?string $numeroParsed = null;
    public ?string $simCardParsed = null;
    public bool $parsed = false;
    public bool $simCardYaExiste = false;

    protected array $rules = [
        'operadorId'     => 'required|exists:operadores,id',
        'textoRespuesta' => 'required|string',
    ];

    protected array $messages = [
        'operadorId.required'     => 'Selecciona un operador.',
        'operadorId.exists'       => 'Operador inválido.',
        'textoRespuesta.required' => 'Pega el texto de respuesta del proveedor.',
    ];

    #[On('open-modal-registrar-asignacion')]
    public function openModal(): void
    {
        $this->reset(['operadorId', 'textoRespuesta', 'numeroParsed', 'simCardParsed', 'parsed', 'simCardYaExiste']);
        $this->resetValidation();
        $this->openModal = true;
    }

    public function closeModal(): void
    {
        $this->openModal = false;
    }

    public function parsear(): void
    {
        $this->validateOnly('textoRespuesta');

        $texto = trim($this->textoRespuesta);

        $numero  = null;
        $simCard = null;

        if (preg_match('/N[uú]mero:\s*(\d+)/iu', $texto, $m)) {
            $numero = $m[1];
            // Strip Peru country code prefix "51" when number is longer than 9 digits
            if (str_starts_with($numero, '51') && strlen($numero) > 9) {
                $numero = substr($numero, 2);
            }
        }

        if (preg_match('/cardPackageID:\s*(\S+)/iu', $texto, $m)) {
            $simCard = rtrim($m[1], '|, ');
        }

        $this->numeroParsed  = $numero;
        $this->simCardParsed = $simCard;
        $this->parsed        = $numero !== null && $simCard !== null;

        if ($this->parsed) {
            $this->simCardYaExiste = SimCard::withoutGlobalScopes()
                ->where('sim_card', $simCard)
                ->exists();
        } else {
            $this->addError('textoRespuesta', 'No se pudo extraer el número o el cardPackageID del texto.');
        }
    }

    public function save(): void
    {
        $this->validate();

        if (! $this->parsed) {
            $this->parsear();
            if (! $this->parsed) {
                return;
            }
        }

        try {
            $simCardExistente = SimCard::withoutGlobalScopes()
                ->where('sim_card', $this->simCardParsed)
                ->first();

            if ($simCardExistente) {
                $this->asignarSimCardExistente($simCardExistente);
            } else {
                $this->crearNuevo();
            }

            $this->closeModal();
            $this->dispatch('update-table');
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: $th->getMessage(),
            );
        }
    }

    private function asignarSimCardExistente(SimCard $simCard): void
    {
        // El SIM ya está asignado a otra línea — bloquear igual que AsignLinea
        if ($simCard->lineas_id) {
            $this->notification()->warning(
                title: 'SIM CARD YA TIENE LÍNEA',
                description: 'El chip ' . $simCard->sim_card . ' ya está asignado al número ' . optional($simCard->linea)->numero . '. Usa "Cambiar chip" si deseas reasignarlo.'
            );
            return;
        }

        DB::transaction(function () use ($simCard) {
            $linea = Lineas::create([
                'numero'      => $this->numeroParsed,
                'operador_id' => $this->operadorId,
            ]);

            $simCard->lineas_id   = $linea->id;
            if (! $simCard->operador_id) {
                $simCard->operador_id = $this->operadorId;
            }
            $simCard->save();

            CambiosLineas::create([
                'tipo_cambio' => 'Nueva asignación',
                'sim_card_id' => $simCard->id,
                'old_numero'  => null,
                'new_numero'  => $linea->id,
                'user_id'     => Auth::id(),
            ]);
        });

        $this->notification()->success(
            'Asignación registrada',
            "SIM existente {$this->simCardParsed} asignado al número {$this->numeroParsed}."
        );
    }

    private function crearNuevo(): void
    {
        DB::transaction(function () {
            $linea = Lineas::create([
                'numero'      => $this->numeroParsed,
                'operador_id' => $this->operadorId,
            ]);

            SimCard::create([
                'sim_card'    => $this->simCardParsed,
                'lineas_id'   => $linea->id,
                'operador_id' => $this->operadorId,
            ]);
        });

        $this->notification()->success(
            'Asignación registrada',
            "Número {$this->numeroParsed} con SIM {$this->simCardParsed} creado y registrado."
        );
    }

    public function render(): \Illuminate\View\View
    {
        $operadores = Operador::whereRaw('UPPER(name) LIKE ?', ['%CUY%'])
            ->orderBy('name')
            ->get();

        return view('livewire.admin.lineas.registrar-asignacion', compact('operadores'));
    }
}
