<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Admin\PDF\WorkOrderPdfController;
use App\Http\Controllers\Api\Portal\Concerns\ResolvesPortalCliente;
use App\Http\Controllers\Controller;
use App\Models\Actas;
use App\Models\Certificados;
use App\Models\CertificadosAntifatiga;
use App\Models\CertificadosVelocimetros;
use App\Models\Comprobantes;
use App\Models\Contratos;
use App\Models\EnvioResumen;
use App\Models\Presupuestos;
use App\Models\Recibos;
use App\Models\Vehiculos;
use App\Models\Ventas;
use App\Models\WorkOrder;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PortalPdfController extends Controller
{
    use ResolvesPortalCliente;

    /**
     * Tipos de documento con PDF disponible en el portal.
     *
     * @var array<int, string>
     */
    protected const TIPOS = [
        'acta',
        'certificado-gps',
        'certificado-velocimetro',
        'certificado-antifatiga',
        'contrato',
        'presupuesto',
        'recibo',
        'orden-trabajo',
        'comprobante',
        'nota-credito',
        'nota-debito',
        'comunicacion-baja',
    ];

    /**
     * Devuelve una URL temporal firmada para previsualizar/descargar el PDF.
     */
    public function link(string $tipo, int $id): JsonResponse
    {
        abort_unless(in_array($tipo, self::TIPOS, true), 404);

        // Verifica pertenencia al cliente autenticado antes de firmar.
        $this->resolver($tipo, $id, $this->clienteId());

        $url = URL::temporarySignedRoute(
            'api.portal.files.stream',
            now()->addMinutes((int) config('portal.pdf_link_minutes', 10)),
            ['tipo' => $tipo, 'id' => $id, 'cliente' => $this->clienteId()]
        );

        return response()->json(['url' => $url]);
    }

    /**
     * Hace stream del PDF. Ruta firmada (sin token); la firma es la autorización.
     */
    public function stream(Request $request, string $tipo, int $id)
    {
        abort_unless(in_array($tipo, self::TIPOS, true), 404);

        $clienteId = (int) $request->query('cliente');
        $modelo = $this->resolver($tipo, $id, $clienteId);

        // Contexto de empresa para que las plantillas de PDF resuelvan correctamente.
        if (isset($modelo->empresa_id)) {
            session(['empresa' => $modelo->empresa_id]);
        }

        return $this->generar($tipo, $modelo);
    }

    /**
     * Resuelve el modelo asegurando que pertenece al cliente. Lanza 404 si no.
     */
    protected function resolver(string $tipo, int $id, int $clienteId): Model
    {
        $vehiculoIds = $this->vehiculoIdsDe($clienteId);

        return match ($tipo) {
            'acta' => Actas::withoutGlobalScope(EmpresaScope::class)
                ->whereIn('vehiculos_id', $vehiculoIds)->findOrFail($id),

            'certificado-gps' => Certificados::withoutGlobalScope(EmpresaScope::class)
                ->whereIn('vehiculos_id', $vehiculoIds)->findOrFail($id),

            'certificado-velocimetro' => CertificadosVelocimetros::withoutGlobalScope(EmpresaScope::class)
                ->whereIn('vehiculos_id', $vehiculoIds)->findOrFail($id),

            'certificado-antifatiga' => CertificadosAntifatiga::withoutGlobalScope(EmpresaScope::class)
                ->where(fn ($q) => $q->where('cliente_id', $clienteId)->orWhereIn('vehiculo_id', $vehiculoIds))
                ->findOrFail($id),

            'contrato' => Contratos::withoutGlobalScope(EmpresaScope::class)
                ->where('clientes_id', $clienteId)->findOrFail($id),

            'presupuesto' => Presupuestos::withoutGlobalScope(EmpresaScope::class)
                ->where('clientes_id', $clienteId)->findOrFail($id),

            'recibo' => Recibos::withoutGlobalScope(EmpresaScope::class)
                ->where('clientes_id', $clienteId)->findOrFail($id),

            'orden-trabajo' => WorkOrder::withoutGlobalScope(EmpresaScope::class)
                ->where('cliente_id', $clienteId)->findOrFail($id),

            'comprobante' => Ventas::withoutGlobalScope(EmpresaScope::class)
                ->where('cliente_id', $clienteId)->where('estado', 'COMPLETADO')->findOrFail($id),

            'nota-credito' => Comprobantes::withoutGlobalScope(EmpresaScope::class)
                ->where('cliente_id', $clienteId)->where('tipo_comprobante_id', '07')->findOrFail($id),

            'nota-debito' => Comprobantes::withoutGlobalScope(EmpresaScope::class)
                ->where('cliente_id', $clienteId)->where('tipo_comprobante_id', '08')->findOrFail($id),

            'comunicacion-baja' => EnvioResumen::whereHas(
                'ventas',
                fn ($q) => $q->withoutGlobalScope(EmpresaScope::class)->where('cliente_id', $clienteId)
            )->findOrFail($id),

            default => abort(404),
        };
    }

    /**
     * Genera el PDF reutilizando los generadores existentes.
     */
    protected function generar(string $tipo, Model $modelo)
    {
        return match ($tipo) {
            'presupuesto', 'recibo' => $modelo->getPDFData(0),
            'orden-trabajo' => app(WorkOrderPdfController::class)->generate($modelo),
            'comprobante', 'nota-credito', 'nota-debito', 'comunicacion-baja' => $modelo->getPdf(),
            default => $modelo->getPDFData(),
        };
    }

    /**
     * @return array<int, int>
     */
    protected function vehiculoIdsDe(int $clienteId): array
    {
        return Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $clienteId)
            ->pluck('id')
            ->all();
    }
}
