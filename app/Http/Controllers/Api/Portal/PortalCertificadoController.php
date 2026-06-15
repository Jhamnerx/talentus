<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Api\Portal\Concerns\ResolvesPortalCliente;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portal\ActaResource;
use App\Http\Resources\Portal\CertificadoAntifatigaResource;
use App\Http\Resources\Portal\CertificadoGpsResource;
use App\Http\Resources\Portal\CertificadoVelocimetroResource;
use App\Models\Actas;
use App\Models\Certificados;
use App\Models\CertificadosAntifatiga;
use App\Models\CertificadosVelocimetros;
use App\Scopes\EmpresaScope;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortalCertificadoController extends Controller
{
    use ResolvesPortalCliente;

    public function actas(): AnonymousResourceCollection
    {
        $actas = Actas::withoutGlobalScope(EmpresaScope::class)
            ->whereIn('vehiculos_id', $this->vehiculoIds())
            ->with('vehiculo')
            ->orderByDesc('id')
            ->paginate($this->perPage());

        return ActaResource::collection($actas);
    }

    public function gps(): AnonymousResourceCollection
    {
        $certificados = Certificados::withoutGlobalScope(EmpresaScope::class)
            ->whereIn('vehiculos_id', $this->vehiculoIds())
            ->with('vehiculo')
            ->orderByDesc('id')
            ->paginate($this->perPage());

        return CertificadoGpsResource::collection($certificados);
    }

    public function velocimetro(): AnonymousResourceCollection
    {
        $certificados = CertificadosVelocimetros::withoutGlobalScope(EmpresaScope::class)
            ->whereIn('vehiculos_id', $this->vehiculoIds())
            ->with('vehiculo')
            ->orderByDesc('id')
            ->paginate($this->perPage());

        return CertificadoVelocimetroResource::collection($certificados);
    }

    public function antifatiga(): AnonymousResourceCollection
    {
        $vehiculoIds = $this->vehiculoIds();

        $certificados = CertificadosAntifatiga::withoutGlobalScope(EmpresaScope::class)
            ->where(function ($query) use ($vehiculoIds) {
                $query->where('cliente_id', $this->clienteId())
                    ->orWhereIn('vehiculo_id', $vehiculoIds);
            })
            ->with('vehiculo')
            ->orderByDesc('id')
            ->paginate($this->perPage());

        return CertificadoAntifatigaResource::collection($certificados);
    }
}
