<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Api\Portal\Concerns\ResolvesPortalCliente;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portal\VehiculoResource;
use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;
use App\Services\Portal\VehiculoAccesoService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortalVehiculoController extends Controller
{
    use ResolvesPortalCliente;

    public function __construct(protected VehiculoAccesoService $acceso)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $reciboPendiente = $this->clienteTieneReciboPendiente();

        $vehiculos = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $this->clienteId())
            ->with(['cobros.plan', 'dispositivoPrincipal'])
            ->orderByDesc('id')
            ->paginate($this->perPage());

        $vehiculos->getCollection()->transform(function (Vehiculos $vehiculo) use ($reciboPendiente): Vehiculos {
            $vehiculo->setAttribute('acceso_portal', $this->acceso->evaluar($vehiculo, $reciboPendiente));

            return $vehiculo;
        });

        return VehiculoResource::collection($vehiculos);
    }

    public function show(int $id): VehiculoResource
    {
        $vehiculo = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $this->clienteId())
            ->with(['cobros.plan', 'dispositivoPrincipal'])
            ->findOrFail($id);

        $vehiculo->setAttribute(
            'acceso_portal',
            $this->acceso->evaluar($vehiculo, $this->clienteTieneReciboPendiente())
        );

        return new VehiculoResource($vehiculo);
    }
}
