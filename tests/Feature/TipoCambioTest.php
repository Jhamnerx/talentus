<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\FactilizaService;
use App\Models\TipoCambio;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TipoCambioTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que el tipo de cambio se guarda en DB después de consultar la API
     */
    public function test_tipo_cambio_se_guarda_en_db_desde_api(): void
    {
        $factiliza = new FactilizaService();

        // Primera consulta: debe ir a la API
        $resultado = $factiliza->consultarTipoCambio('2024-01-15');

        // Verificar que existe en la DB
        $this->assertDatabaseHas('tipo_cambios', [
            'fecha' => '2024-01-15',
        ]);

        // Verificar que viene desde API
        $this->assertFalse($resultado['desde_cache'] ?? true);
    }

    /**
     * Test que la segunda consulta usa el caché de DB
     */
    public function test_tipo_cambio_usa_cache_en_segunda_consulta(): void
    {
        $factiliza = new FactilizaService();

        // Primera consulta
        $resultado1 = $factiliza->consultarTipoCambio('2024-01-15');
        $this->assertFalse($resultado1['desde_cache'] ?? true);

        // Segunda consulta: debe usar caché
        $resultado2 = $factiliza->consultarTipoCambio('2024-01-15');
        $this->assertTrue($resultado2['desde_cache'] ?? false);

        // Los valores deben ser iguales
        $this->assertEquals($resultado1['data']['compra'], $resultado2['data']['compra']);
        $this->assertEquals($resultado1['data']['venta'], $resultado2['data']['venta']);
    }

    /**
     * Test que se puede forzar consulta a la API
     */
    public function test_puede_forzar_consulta_api(): void
    {
        $factiliza = new FactilizaService();

        // Primera consulta
        $factiliza->consultarTipoCambio('2024-01-15');

        // Forzar nueva consulta a API
        $resultado = $factiliza->consultarTipoCambio('2024-01-15', true);

        // Debe venir desde API
        $this->assertFalse($resultado['desde_cache'] ?? true);
    }

    /**
     * Test del modelo TipoCambio
     */
    public function test_modelo_tipo_cambio_metodos(): void
    {
        // Crear registro
        $tipo = TipoCambio::guardar([
            'fecha' => '2024-01-15',
            'compra' => 3.773,
            'venta' => 3.781,
        ]);

        $this->assertNotNull($tipo);
        $this->assertEquals('2024-01-15', $tipo->fecha->format('Y-m-d'));

        // Buscar por fecha
        $encontrado = TipoCambio::porFecha('2024-01-15');
        $this->assertNotNull($encontrado);
        $this->assertEquals(3.773, (float) $encontrado->compra);
    }
}
