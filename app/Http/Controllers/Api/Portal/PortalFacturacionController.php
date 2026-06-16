<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Api\Portal\Concerns\ResolvesPortalCliente;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portal\ContratoResource;
use App\Http\Resources\Portal\NotaResource;
use App\Http\Resources\Portal\PresupuestoResource;
use App\Http\Resources\Portal\ReciboResource;
use App\Http\Resources\Portal\VentaResource;
use App\Models\Comprobantes;
use App\Models\Contratos;
use App\Models\Presupuestos;
use App\Models\Recibos;
use App\Models\Ventas;
use App\Scopes\EmpresaScope;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortalFacturacionController extends Controller
{
    use ResolvesPortalCliente;

    /**
     * Boletas, facturas y notas de venta emitidas al cliente (modelo Ventas).
     */
    public function comprobantes(): AnonymousResourceCollection
    {
        $ventas = Ventas::withoutGlobalScope(EmpresaScope::class)
            ->where('cliente_id', $this->clienteId())
            ->where('estado', 'COMPLETADO')
            ->with('envioResumen')
            ->orderByDesc('id')
            ->paginate($this->perPage());

        return VentaResource::collection($ventas);
    }

    /**
     * Notas de crédito del cliente (modelo Comprobantes, tipo 07).
     */
    public function notasCredito(): AnonymousResourceCollection
    {
        return NotaResource::collection($this->notas('07'));
    }

    /**
     * Notas de débito del cliente (modelo Comprobantes, tipo 08).
     */
    public function notasDebito(): AnonymousResourceCollection
    {
        return NotaResource::collection($this->notas('08'));
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function notas(string $tipoComprobanteId)
    {
        return Comprobantes::withoutGlobalScope(EmpresaScope::class)
            ->where('cliente_id', $this->clienteId())
            ->where('tipo_comprobante_id', $tipoComprobanteId)
            ->orderByDesc('id')
            ->paginate($this->perPage());
    }

    public function recibos(): AnonymousResourceCollection
    {
        $recibos = Recibos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $this->clienteId())
            ->orderByDesc('id')
            ->paginate($this->perPage());

        return ReciboResource::collection($recibos);
    }

    public function presupuestos(): AnonymousResourceCollection
    {
        $presupuestos = Presupuestos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $this->clienteId())
            ->orderByDesc('id')
            ->paginate($this->perPage());

        return PresupuestoResource::collection($presupuestos);
    }

    public function contratos(): AnonymousResourceCollection
    {
        $contratos = Contratos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $this->clienteId())
            ->orderByDesc('id')
            ->paginate($this->perPage());

        return ContratoResource::collection($contratos);
    }
}
