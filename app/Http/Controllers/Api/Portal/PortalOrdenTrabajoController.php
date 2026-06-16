<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Api\Portal\Concerns\ResolvesPortalCliente;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portal\OrdenTrabajoResource;
use App\Models\WorkOrder;
use App\Scopes\EmpresaScope;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortalOrdenTrabajoController extends Controller
{
    use ResolvesPortalCliente;

    public function index(): AnonymousResourceCollection
    {
        $ordenes = WorkOrder::withoutGlobalScope(EmpresaScope::class)
            ->where('cliente_id', $this->clienteId())
            ->with(['tipo', 'vehiculo'])
            ->orderByDesc('id')
            ->paginate($this->perPage());

        return OrdenTrabajoResource::collection($ordenes);
    }

    public function show(int $id): OrdenTrabajoResource
    {
        $orden = WorkOrder::withoutGlobalScope(EmpresaScope::class)
            ->where('cliente_id', $this->clienteId())
            ->with(['tipo', 'vehiculo'])
            ->findOrFail($id);

        return new OrdenTrabajoResource($orden);
    }
}
