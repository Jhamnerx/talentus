<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Api\Portal\Concerns\ResolvesPortalCliente;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\ContactoPortalRequest;
use App\Http\Resources\Portal\ContactoResource;
use App\Models\Contactos;
use App\Scopes\EmpresaScope;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortalContactoController extends Controller
{
    use ResolvesPortalCliente;

    public function index(): AnonymousResourceCollection
    {
        $contactos = Contactos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $this->clienteId())
            ->orderByDesc('id')
            ->paginate($this->perPage());

        return ContactoResource::collection($contactos);
    }

    public function store(ContactoPortalRequest $request): JsonResponse
    {
        $contacto = Contactos::create(array_merge($request->validated(), [
            'clientes_id' => $this->clienteId(),
            'empresa_id' => $this->cliente()->empresa_id,
            'is_active' => true,
        ]));

        return response()->json([
            'success' => true,
            'data' => new ContactoResource($contacto),
        ], 201);
    }

    public function update(ContactoPortalRequest $request, int $id): JsonResponse
    {
        $contacto = $this->resolverContacto($id);
        $contacto->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => new ContactoResource($contacto->fresh()),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->resolverContacto($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contacto eliminado.',
        ]);
    }

    protected function resolverContacto(int $id): Contactos
    {
        return Contactos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $this->clienteId())
            ->findOrFail($id);
    }
}
