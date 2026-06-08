<?php

namespace Tests\Unit\Imports;

use App\Imports\LineasImport;
use App\Models\CambiosLineas;
use App\Models\Lineas;
use App\Models\Operador;
use App\Models\SimCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class LineasImportTest extends TestCase
{
    use RefreshDatabase;

    private User $importedBy;
    private Operador $operador;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->importedBy = User::factory()->create();
        $this->operador = Operador::create(['name' => 'CUY']);
    }

    private function import(bool $sobrescribir = false): LineasImport
    {
        return new LineasImport($this->importedBy, $this->operador->id, $sobrescribir);
    }

    public function test_crea_linea_y_sim_card_cuando_ninguno_existe(): void
    {
        $import = $this->import();

        $import->model(['numero' => '919081951', 'sim_card' => '895120100300171576']);

        $linea = Lineas::where('numero', '919081951')->first();
        $simCard = SimCard::where('sim_card', '895120100300171576')->first();

        $this->assertNotNull($linea);
        $this->assertNotNull($simCard);
        $this->assertSame($linea->id, $simCard->lineas_id);
        $this->assertSame(['creados' => 1, 'asignados' => 0, 'omitidos' => 0], $import->resumen());
    }

    public function test_asigna_sim_card_nuevo_a_linea_existente_sin_chip(): void
    {
        $linea = Lineas::create(['numero' => '919081951', 'operador_id' => $this->operador->id, 'empresa_id' => 1]);

        $import = $this->import();
        $import->model(['numero' => '919081951', 'sim_card' => '895120100300171576']);

        $simCard = SimCard::where('sim_card', '895120100300171576')->first();

        $this->assertNotNull($simCard);
        $this->assertSame($linea->id, $simCard->lineas_id);
        $this->assertSame(['creados' => 0, 'asignados' => 1, 'omitidos' => 0], $import->resumen());

        $this->assertDatabaseHas('cambios_lineas', [
            'sim_card_id' => $simCard->id,
            'new_numero' => $linea->id,
            'old_numero' => null,
        ]);
    }

    public function test_crea_linea_y_la_asocia_a_sim_card_existente_sin_linea(): void
    {
        $simCard = SimCard::create(['sim_card' => '895120100300171576', 'operador_id' => $this->operador->id, 'empresa_id' => 1]);

        $import = $this->import();
        $import->model(['numero' => '919081951', 'sim_card' => '895120100300171576']);

        $linea = Lineas::where('numero', '919081951')->first();
        $simCard->refresh();

        $this->assertNotNull($linea);
        $this->assertSame($linea->id, $simCard->lineas_id);
        $this->assertSame(['creados' => 0, 'asignados' => 1, 'omitidos' => 0], $import->resumen());
    }

    public function test_omite_fila_cuando_linea_y_sim_card_ya_estan_asociados(): void
    {
        $linea = Lineas::create(['numero' => '919081951', 'operador_id' => $this->operador->id, 'empresa_id' => 1]);
        SimCard::create(['sim_card' => '895120100300171576', 'lineas_id' => $linea->id, 'operador_id' => $this->operador->id, 'empresa_id' => 1]);

        $import = $this->import();
        $import->model(['numero' => '919081951', 'sim_card' => '895120100300171576']);

        $this->assertSame(1, Lineas::count());
        $this->assertSame(1, SimCard::count());
        $this->assertSame(['creados' => 0, 'asignados' => 0, 'omitidos' => 1], $import->resumen());
    }

    public function test_omite_fila_cuando_linea_y_sim_card_existen_en_conflicto(): void
    {
        $linea = Lineas::create(['numero' => '919081951', 'operador_id' => $this->operador->id, 'empresa_id' => 1]);
        $otraLinea = Lineas::create(['numero' => '900000000', 'operador_id' => $this->operador->id, 'empresa_id' => 1]);
        SimCard::create(['sim_card' => '895120100300171576', 'lineas_id' => $otraLinea->id, 'operador_id' => $this->operador->id, 'empresa_id' => 1]);

        $import = $this->import();
        $import->model(['numero' => '919081951', 'sim_card' => '895120100300171576']);

        $this->assertNull($linea->fresh()->sim_card);
        $this->assertSame(['creados' => 0, 'asignados' => 0, 'omitidos' => 1], $import->resumen());
    }

    public function test_crea_solo_sim_card_cuando_numero_es_no(): void
    {
        $import = $this->import();
        $import->model(['numero' => 'no', 'sim_card' => '895120100300171576']);

        $simCard = SimCard::where('sim_card', '895120100300171576')->first();

        $this->assertNotNull($simCard);
        $this->assertNull($simCard->lineas_id);
        $this->assertSame(['creados' => 1, 'asignados' => 0, 'omitidos' => 0], $import->resumen());
    }

    public function test_omite_sim_card_duplicado_cuando_numero_es_no(): void
    {
        SimCard::create(['sim_card' => '895120100300171576', 'operador_id' => $this->operador->id, 'empresa_id' => 1]);

        $import = $this->import();
        $import->model(['numero' => 'no', 'sim_card' => '895120100300171576']);

        $this->assertSame(1, SimCard::count());
        $this->assertSame(['creados' => 0, 'asignados' => 0, 'omitidos' => 1], $import->resumen());
    }

    public function test_sobrescribe_sim_card_de_linea_cuando_la_linea_ya_tiene_otro_chip(): void
    {
        $linea = Lineas::create(['numero' => '919081951', 'operador_id' => $this->operador->id, 'empresa_id' => 1]);
        $chipAnterior = SimCard::create(['sim_card' => '895120100300000001', 'lineas_id' => $linea->id, 'operador_id' => $this->operador->id, 'empresa_id' => 1]);

        $import = $this->import(sobrescribir: true);
        $import->model(['numero' => '919081951', 'sim_card' => '895120100300171576']);

        $nuevoChip = SimCard::where('sim_card', '895120100300171576')->first();

        $this->assertNull($chipAnterior->fresh()->lineas_id);
        $this->assertSame($linea->id, $nuevoChip->lineas_id);
        $this->assertSame(['creados' => 0, 'asignados' => 1, 'omitidos' => 0], $import->resumen());

        $this->assertDatabaseHas('cambios_lineas', [
            'tipo_cambio' => 'Importación - SIM anterior liberado',
            'sim_card_id' => $chipAnterior->id,
            'old_numero' => $linea->id,
            'new_numero' => null,
        ]);
    }

    public function test_sobrescribe_linea_de_sim_card_cuando_el_chip_ya_tiene_otro_numero(): void
    {
        $lineaAnterior = Lineas::create(['numero' => '900000000', 'operador_id' => $this->operador->id, 'empresa_id' => 1]);
        $simCard = SimCard::create(['sim_card' => '895120100300171576', 'lineas_id' => $lineaAnterior->id, 'operador_id' => $this->operador->id, 'empresa_id' => 1]);

        $import = $this->import(sobrescribir: true);
        $import->model(['numero' => '919081951', 'sim_card' => '895120100300171576']);

        $nuevaLinea = Lineas::where('numero', '919081951')->first();
        $simCard->refresh();

        $this->assertNull($lineaAnterior->fresh()->sim_card);
        $this->assertSame($nuevaLinea->id, $simCard->lineas_id);
        $this->assertSame(['creados' => 0, 'asignados' => 1, 'omitidos' => 0], $import->resumen());

        $this->assertDatabaseHas('cambios_lineas', [
            'tipo_cambio' => 'Importación - SIM anterior liberado',
            'sim_card_id' => $simCard->id,
            'old_numero' => $lineaAnterior->id,
            'new_numero' => null,
        ]);
    }

    public function test_sobrescribe_asociacion_cuando_linea_y_sim_card_existen_en_conflicto(): void
    {
        $linea = Lineas::create(['numero' => '919081951', 'operador_id' => $this->operador->id, 'empresa_id' => 1]);
        $chipAnterior = SimCard::create(['sim_card' => '895120100300000001', 'lineas_id' => $linea->id, 'operador_id' => $this->operador->id, 'empresa_id' => 1]);

        $otraLinea = Lineas::create(['numero' => '900000000', 'operador_id' => $this->operador->id, 'empresa_id' => 1]);
        $simCard = SimCard::create(['sim_card' => '895120100300171576', 'lineas_id' => $otraLinea->id, 'operador_id' => $this->operador->id, 'empresa_id' => 1]);

        $import = $this->import(sobrescribir: true);
        $import->model(['numero' => '919081951', 'sim_card' => '895120100300171576']);

        $simCard->refresh();

        $this->assertNull($chipAnterior->fresh()->lineas_id);
        $this->assertNull($otraLinea->fresh()->sim_card);
        $this->assertSame($linea->id, $simCard->lineas_id);
        $this->assertSame(['creados' => 0, 'asignados' => 1, 'omitidos' => 0], $import->resumen());
    }
}
