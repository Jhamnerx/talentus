<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Api\Portal\Concerns\ResolvesPortalCliente;
use App\Http\Controllers\Controller;
use App\Models\Cobros;
use App\Models\Recibos;
use App\Models\Ticket;
use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;
use Illuminate\Http\JsonResponse;

class PortalDashboardController extends Controller
{
    use ResolvesPortalCliente;

    public function index(): JsonResponse
    {
        $clienteId = $this->clienteId();

        $vehiculosTotal = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $clienteId)
            ->count();

        $recibosPendientes = Recibos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $clienteId)
            ->where('pago_estado', Recibos::UNPAID);

        $ticketsAbiertos = Ticket::withoutGlobalScope(EmpresaScope::class)
            ->forCustomer($clienteId)
            ->open()
            ->count();

        $proximosVencer = Cobros::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $clienteId)
            ->proximosAVencer(15)
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'vehiculos_total' => $vehiculosTotal,
                'recibos_pendientes' => [
                    'cantidad' => (clone $recibosPendientes)->count(),
                    'monto' => (float) (clone $recibosPendientes)->sum('total'),
                ],
                'tickets_abiertos' => $ticketsAbiertos,
                'cobros_proximos_a_vencer' => $proximosVencer,
            ],
        ]);
    }
}
