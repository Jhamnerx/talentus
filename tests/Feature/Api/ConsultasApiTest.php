<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Actas;
use App\Models\Clientes;
use App\Models\Vehiculos;
use App\Models\Certificados;
use App\Models\CertificadosVelocimetros;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConsultasApiTest extends TestCase
{
    use DatabaseTransactions;

    public function test_retorna_404_cuando_acta_no_existe(): void
    {
        $response = $this->getJson('/api/consultas/acta/CODIGO-INEXISTENTE-' . uniqid());

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Acta no encontrada'
            ]);
    }

    public function test_retorna_404_cuando_certificado_gps_no_existe(): void
    {
        $response = $this->getJson('/api/consultas/certificado-gps/CODIGO-INEXISTENTE-' . uniqid());

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Certificado GPS no encontrado'
            ]);
    }

    public function test_retorna_404_cuando_certificado_velocimetro_no_existe(): void
    {
        $response = $this->getJson('/api/consultas/certificado-velocimetro/CODIGO-INEXISTENTE-' . uniqid());

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Certificado de velocímetro no encontrado'
            ]);
    }

    public function test_estructura_correcta_de_respuesta_acta(): void
    {
        // Verificar que existe al menos un acta
        $acta = Actas::with('vehiculo.cliente')->first();

        if (!$acta) {
            $this->markTestSkipped('No hay actas en la base de datos para probar');
        }

        $response = $this->getJson('/api/consultas/acta/' . $acta->codigo);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'acta' => ['id', 'codigo', 'estado'],
                    'vehiculo',
                    'cliente',
                ]
            ])
            ->assertJson([
                'success' => true,
            ]);
    }
}
