<?php

namespace Tests\Unit\Models;

use App\Models\Vehiculos;
use Tests\TestCase;

/**
 * Test estructural del scope (sin BD ni factory): verifica que el OR quede
 * agrupado y combine con otras condiciones como AND (… OR …).
 * toSql() no abre conexión, por lo que es seguro de ejecutar.
 */
class VehiculosSinSincronizarGpswoxTest extends TestCase
{
    public function test_scope_genera_el_or_de_ambas_columnas(): void
    {
        $sql = (new Vehiculos())->newQuery()->sinSincronizarGpswox()->toSql();

        $this->assertStringContainsString('gpswox_id', $sql);
        $this->assertStringContainsString('gpswox_sincronizado_at', $sql);
        $this->assertMatchesRegularExpression('/gpswox_id.*is null\s+or\s+.*gpswox_sincronizado_at.*is null/i', $sql);
    }

    public function test_scope_agrupa_el_or_al_combinar_con_cursor(): void
    {
        $sql = (new Vehiculos())->newQuery()
            ->sinSincronizarGpswox()
            ->where('id', '>', 0)
            ->toSql();

        $this->assertMatchesRegularExpression('/\([^()]*gpswox_id[^()]*is null\s+or\s+[^()]*gpswox_sincronizado_at[^()]*is null[^()]*\)/i', $sql);
        $this->assertMatchesRegularExpression('/\)\s+and\s+.*id.*>/i', $sql);
    }
}
