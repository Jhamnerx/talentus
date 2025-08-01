<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Certificados;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Obtener todos los certificados existentes
        $certificados = Certificados::all();

        foreach ($certificados as $certificado) {
            if ($certificado->accesorios && is_array($certificado->accesorios)) {
                $accesoriosActualizados = [];

                foreach ($certificado->accesorios as $accesorio) {
                    if ($accesorio === 'BUZZER') {
                        // Convertir BUZZER a formato con detalle vacío
                        $accesoriosActualizados[] = [
                            'nombre' => 'BUZZER',
                            'detalle' => ''
                        ];
                    } else {
                        // Mantener otros accesorios como están
                        $accesoriosActualizados[] = $accesorio;
                    }
                }

                // Actualizar solo si hay cambios
                if ($accesoriosActualizados !== $certificado->accesorios) {
                    $certificado->update(['accesorios' => $accesoriosActualizados]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir el formato anterior
        $certificados = Certificados::all();

        foreach ($certificados as $certificado) {
            if ($certificado->accesorios && is_array($certificado->accesorios)) {
                $accesoriosRevertidos = [];

                foreach ($certificado->accesorios as $accesorio) {
                    if (is_array($accesorio) && isset($accesorio['nombre']) && $accesorio['nombre'] === 'BUZZER') {
                        // Revertir BUZZER a formato simple
                        $accesoriosRevertidos[] = 'BUZZER';
                    } else {
                        // Mantener otros accesorios como están
                        $accesoriosRevertidos[] = is_array($accesorio) ? $accesorio['nombre'] : $accesorio;
                    }
                }

                // Actualizar solo si hay cambios
                if ($accesoriosRevertidos !== $certificado->accesorios) {
                    $certificado->update(['accesorios' => $accesoriosRevertidos]);
                }
            }
        }
    }
};
