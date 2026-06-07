<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Lineas;
use App\Models\SimCard;
use App\Models\CambiosLineas;
use App\Events\SimCardImportUpdated;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use App\Notifications\Imports\ImportHasFailedNotification;

class LineasImport implements ToModel, WithChunkReading, SkipsOnError, SkipsOnFailure, WithEvents, WithValidation, WithHeadingRow, WithGroupedHeadingRow, SkipsEmptyRows
{
    use RegistersEventListeners, Importable;

    protected $importedBy;
    protected $operadorId;
    protected $sobrescribirAsignaciones;

    public int $creados = 0;
    public int $asignados = 0;
    public int $omitidos = 0;

    public function __construct(User $importedBy, int $operadorId, bool $sobrescribirAsignaciones = false)
    {
        $this->importedBy = $importedBy;
        $this->operadorId = $operadorId;
        $this->sobrescribirAsignaciones = $sobrescribirAsignaciones;
    }

    public function model(array $fila)
    {
        $numero = trim((string) $fila['numero']);
        $iccid  = isset($fila['sim_card']) ? trim((string) $fila['sim_card']) : null;

        if ($numero === 'no') {
            $this->registrarSoloSimCard($iccid);

            return null;
        }

        $this->registrarLineaConSimCard($numero, $iccid);

        return null;
    }

    private function registrarLineaConSimCard(string $numero, ?string $iccid): void
    {
        $linea   = Lineas::withoutGlobalScopes()->where('numero', $numero)->first();
        $simCard = $iccid ? SimCard::withoutGlobalScopes()->where('sim_card', $iccid)->first() : null;

        if ($linea && ! $linea->operador_id) {
            $linea->operador_id = $this->operadorId;
            $linea->save();
        }

        // Ninguno existe: crear línea y chip ya asociados entre sí
        if (! $linea && ! $simCard) {
            $linea = Lineas::create([
                'numero'      => $numero,
                'operador_id' => $this->operadorId,
                'empresa_id'  => 1,
            ]);

            SimCard::create([
                'sim_card'    => $iccid,
                'operador_id' => $this->operadorId,
                'lineas_id'   => $linea->id,
                'empresa_id'  => 1,
            ]);

            $this->creados++;

            return;
        }

        // La línea existe pero el chip no: crear el chip y asignarlo a la línea
        if ($linea && ! $simCard) {
            if ($linea->sim_card) {
                if (! $this->sobrescribirAsignaciones) {
                    $this->omitidos++;

                    return;
                }

                $this->liberarSimCard($linea->sim_card);
            }

            $simCard = SimCard::create([
                'sim_card'    => $iccid,
                'operador_id' => $this->operadorId,
                'lineas_id'   => $linea->id,
                'empresa_id'  => 1,
            ]);

            $this->registrarCambio($simCard, null, $linea->id);
            $this->asignados++;

            return;
        }

        // El chip existe pero la línea no: crear la línea y asignar el chip existente
        if (! $linea && $simCard) {
            if ($simCard->lineas_id) {
                if (! $this->sobrescribirAsignaciones) {
                    $this->omitidos++;

                    return;
                }

                $this->liberarSimCard($simCard);
            }

            $linea = Lineas::create([
                'numero'      => $numero,
                'operador_id' => $this->operadorId,
                'empresa_id'  => 1,
            ]);

            $simCard->lineas_id = $linea->id;
            $simCard->save();

            $this->registrarCambio($simCard, null, $linea->id);
            $this->asignados++;

            return;
        }

        // Ambos existen y ya están asociados entre sí: nada que hacer
        if ($linea->sim_card && $simCard->lineas_id === $linea->id) {
            $this->omitidos++;

            return;
        }

        // Ambos existen pero asociados a otros registros
        if (! $this->sobrescribirAsignaciones) {
            $this->omitidos++;

            return;
        }

        if ($linea->sim_card) {
            $this->liberarSimCard($linea->sim_card);
        }

        if ($simCard->lineas_id) {
            $this->liberarSimCard($simCard);
        }

        $simCard->lineas_id = $linea->id;
        $simCard->save();

        $this->registrarCambio($simCard, null, $linea->id);
        $this->asignados++;
    }

    private function liberarSimCard(SimCard $simCard): void
    {
        $oldLineaId = $simCard->lineas_id;

        $simCard->lineas_id = null;
        $simCard->save();

        CambiosLineas::create([
            'tipo_cambio' => 'Importación - SIM anterior liberado',
            'sim_card_id' => $simCard->id,
            'old_numero'  => $oldLineaId,
            'new_numero'  => null,
            'user_id'     => $this->importedBy->id,
        ]);
    }

    private function registrarSoloSimCard(?string $iccid): void
    {
        if (! $iccid) {
            $this->omitidos++;

            return;
        }

        if (SimCard::withoutGlobalScopes()->where('sim_card', $iccid)->exists()) {
            $this->omitidos++;

            return;
        }

        SimCard::create([
            'sim_card'    => $iccid,
            'operador_id' => $this->operadorId,
            'empresa_id'  => 1,
        ]);

        $this->creados++;
    }

    private function registrarCambio(SimCard $simCard, ?int $oldLineaId, int $newLineaId): void
    {
        CambiosLineas::create([
            'tipo_cambio' => 'Importación - asignación',
            'sim_card_id' => $simCard->id,
            'old_numero'  => $oldLineaId,
            'new_numero'  => $newLineaId,
            'user_id'     => $this->importedBy->id,
        ]);
    }

    public function resumen(): array
    {
        return [
            'creados'   => $this->creados,
            'asignados' => $this->asignados,
            'omitidos'  => $this->omitidos,
        ];
    }

    public function rules(): array
    {
        return [
            'numero'   => 'required',
            'sim_card' => 'required',
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function onFailure(Failure ...$failures)
    {
        $errores = [];

        foreach ($failures as $failure) {
            $errores = [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'value' => $failure->values()[$failure->attribute()],
                'error' => $failure->errors()[0],
            ];
        }

        $this->importedBy->notify(new ImportHasFailedNotification($errores));
    }

    public function afterImport(AfterImport $event): void
    {
        SimCardImportUpdated::dispatch();
    }

    public static function importFailed(ImportFailed $event) {}

    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }
}
