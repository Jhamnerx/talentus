<?php

namespace Tests\Feature\Services;

use App\Models\Dispositivos;
use App\Models\Empresa;
use App\Models\Lineas;
use App\Models\SimCard;
use App\Models\Vehiculos;
use App\Models\VehiculoDispositivos;
use App\Services\PlataformaVehiculoSyncService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * NOTA: usa RefreshDatabase. NO ejecutar contra la BD de desarrollo (la borraría).
 * Requiere la conexión de pruebas sqlite :memory: habilitada en phpunit.xml.
 */
class PlataformaVehiculoSyncServiceTest extends TestCase
{
    use RefreshDatabase;

    private function seedEmpresa(): Empresa
    {
        $empresa = Empresa::create(['nombre' => 'Test']);
        session(['empresa' => $empresa->id]);
        return $empresa;
    }

    private function svc(): PlataformaVehiculoSyncService
    {
        return app(PlataformaVehiculoSyncService::class);
    }

    public function test_transfiere_numero_de_un_vehiculo_a_otro(): void
    {
        $empresa = $this->seedEmpresa();
        $linea   = Lineas::create(['numero' => '999111', 'empresa_id' => $empresa->id]);
        $sim     = SimCard::create(['sim_card' => 'SIM-A', 'operador' => 'OP', 'lineas_id' => $linea->id, 'empresa_id' => $empresa->id]);

        $a = Vehiculos::create(['placa' => 'AAA-111', 'empresa_id' => $empresa->id, 'numero' => '999111', 'sim_card_id' => $sim->id]);
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id]);

        $this->svc()->aplicarNumero($b, '999111');
        $b->save();

        $a->refresh();
        $b->refresh();

        $this->assertNull($a->numero);
        $this->assertNull($a->sim_card_id);
        $this->assertSame('999111', $a->old_numero);
        $this->assertSame('SIM-A', $a->old_sim_card);

        $this->assertSame('999111', $b->numero);
        $this->assertSame($sim->id, $b->sim_card_id);
    }

    public function test_transfiere_numero_aunque_el_destino_ya_tenga_otro(): void
    {
        // Escenario clave: el destino ya tiene un número distinto y el número
        // entrante pertenece a otro vehículo. Liberar-primero debe evitar la
        // colisión del índice unique de 'numero'.
        $empresa = $this->seedEmpresa();
        $a = Vehiculos::create(['placa' => 'AAA-111', 'empresa_id' => $empresa->id, 'numero' => '999111']);
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id, 'numero' => '888000']);

        $this->svc()->aplicarNumero($b, '999111');
        $b->save();

        $a->refresh();
        $b->refresh();

        $this->assertNull($a->numero);
        $this->assertSame('999111', $a->old_numero);
        $this->assertSame('999111', $b->numero);
    }

    public function test_aplicar_numero_es_idempotente_si_ya_lo_tiene(): void
    {
        $empresa = $this->seedEmpresa();
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id, 'numero' => '999111']);

        $this->svc()->aplicarNumero($b, '999111');
        $b->save();
        $b->refresh();

        $this->assertSame('999111', $b->numero);
        $this->assertNull($b->old_numero);
    }

    public function test_aplicar_numero_libre_no_libera_a_nadie(): void
    {
        $empresa = $this->seedEmpresa();
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id]);

        $this->svc()->aplicarNumero($b, '777000');
        $b->save();
        $b->refresh();

        $this->assertSame('777000', $b->numero);
    }

    public function test_transfiere_imei_desde_otro_vehiculo(): void
    {
        $empresa = $this->seedEmpresa();
        $disp = Dispositivos::create(['imei' => 'IMEI-1', 'empresa_id' => $empresa->id, 'estado' => 'VENDIDO']);

        $a = Vehiculos::create(['placa' => 'AAA-111', 'empresa_id' => $empresa->id, 'dispositivos_id' => $disp->id]);
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id]);

        $pivotA = VehiculoDispositivos::create([
            'vehiculo_id' => $a->id, 'dispositivo_id' => $disp->id, 'imei' => 'IMEI-1',
            'is_principal' => true, 'fecha_instalacion' => now(),
        ]);

        $resultado = $this->svc()->aplicarImei($b, 'IMEI-1');

        $this->assertTrue($resultado);

        $pivotA->refresh();
        $a->refresh();
        $b->refresh();

        $this->assertNotNull($pivotA->fecha_desinstalacion);
        $this->assertFalse((bool) $pivotA->is_principal);
        $this->assertNull($a->dispositivos_id);

        $this->assertSame($disp->id, $b->dispositivos_id);
        $this->assertDatabaseHas('vehiculos_dispositivos', [
            'vehiculo_id' => $b->id, 'dispositivo_id' => $disp->id,
            'is_principal' => true, 'fecha_desinstalacion' => null,
        ]);
    }

    public function test_aplicar_imei_ya_en_destino_solo_asegura_principal(): void
    {
        $empresa = $this->seedEmpresa();
        $disp = Dispositivos::create(['imei' => 'IMEI-1', 'empresa_id' => $empresa->id, 'estado' => 'VENDIDO']);
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id]);

        VehiculoDispositivos::create([
            'vehiculo_id' => $b->id, 'dispositivo_id' => $disp->id, 'imei' => 'IMEI-1',
            'is_principal' => false, 'fecha_instalacion' => now(),
        ]);

        $resultado = $this->svc()->aplicarImei($b, 'IMEI-1');
        $b->refresh();

        $this->assertTrue($resultado);
        $this->assertSame($disp->id, $b->dispositivos_id);
        $this->assertDatabaseHas('vehiculos_dispositivos', [
            'vehiculo_id' => $b->id, 'dispositivo_id' => $disp->id, 'is_principal' => true,
        ]);
    }

    public function test_aplicar_imei_inexistente_retorna_false(): void
    {
        $empresa = $this->seedEmpresa();
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id]);

        $this->assertFalse($this->svc()->aplicarImei($b, 'NO-EXISTE'));
    }
}
