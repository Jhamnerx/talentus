<?php

namespace App\Http\Controllers\Api\Portal\Concerns;

use App\Models\Clientes;
use App\Models\ClienteUser;
use App\Models\Recibos;
use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;

/**
 * Resuelve el cliente del usuario autenticado y centraliza el aislamiento
 * de datos del portal. Toda consulta debe acotarse al cliente del token.
 */
trait ResolvesPortalCliente
{
    protected function clienteUser(): ClienteUser
    {
        return request()->user();
    }

    protected function cliente(): Clientes
    {
        return $this->clienteUser()->cliente;
    }

    protected function clienteId(): int
    {
        return $this->clienteUser()->cliente_id;
    }

    /**
     * IDs de los vehículos (no eliminados) del cliente autenticado.
     *
     * @return array<int, int>
     */
    protected function vehiculoIds(): array
    {
        return Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $this->clienteId())
            ->pluck('id')
            ->all();
    }

    protected function clienteTieneReciboPendiente(): bool
    {
        return Recibos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $this->clienteId())
            ->where('pago_estado', Recibos::UNPAID)
            ->exists();
    }

    protected function perPage(): int
    {
        return min((int) request()->integer('per_page', 15), 50);
    }
}
