<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use App\Models\Lineas;
use App\Models\SimCard;
use App\Models\Clientes;
use App\Models\Categoria;
use App\Models\Productos;
use App\Models\Vehiculos;
use App\Models\Dispositivos;
use Illuminate\Http\Request;
use App\Models\TipoDocumento;
use App\Models\TipoComprobantes;
use App\Models\ModelosDispositivo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SelectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function categorias(Request $request): Collection
    {

        return Categoria::query()
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('nombre', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(12)
            )
            ->get();
    }

    public function tipoAfectacion(Request $request): Collection
    {
        return TipoAfectacion::query()
            ->select('codigo', 'descripcion')
            ->orderBy('descripcion')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('descripcion', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('codigo', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get();
    }


    public function unit(Request $request): Collection
    {
        return Unit::query()
            ->select('codigo', 'name')
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
                    ->orwhere('codigo', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('codigo', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(15)
            )
            ->get();
    }

    public function clientes(Request $request): Collection
    {

        dd(session('empresa'));
        return Clientes::query()
            ->select('id', 'razon_so54cial', 'numero_documento', 'tipo_documento_id')
            ->orderBy('id')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('razon_social', 'like', "%{$request->search}%")
                    ->orWhere('numero_documento', 'like', "%{$request->search}%")
            )->when(
                $request->tipo_comprobante == "01" ? true : false,
                fn (Builder $query) => $query
                    ->where('tipo_documento_id', 6)

            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(15)
            )
            ->get();
    }

    public function series(Request $request): Collection
    {

        return Series::query()
            ->select('id', 'serie', 'correlativo', 'tipo_comprobante_id')
            ->orderBy('id')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('serie', 'like', "%{$request->search}%")

            )
            ->where('tipo_comprobante_id', $request->tipo_comprobante)
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('serie', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get();
    }

    public function productos(Request $request): Collection
    {

        return Productos::query()
            ->select('id', 'codigo', 'serie', 'descripcion', 'valor_unitario', 'unit_id', 'stock')
            ->orderBy('id')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('serie', 'like', "%{$request->search}%")
                    ->orwhere('descripcion', 'like', "%{$request->search}%")
                    ->orwhere('codigo', 'like', "%{$request->search}%")

            )
            ->where('stock', '>', 0)
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get()->map(function (Productos $producto) {

                $producto->imagen = $producto->image ? Storage::url($producto->image->url) : Storage::url('public/productos/default.jpg');
                $producto->option_description = $producto->codigo . " - Stock: " . $producto->stock . " " . $producto->unit->descripcion . " - Precio: $" . $producto->valor_unitario;

                return $producto;
            });;
    }

    public function documentos(Request $request): Collection
    {

        return TipoDocumento::query()
            ->select('codigo', 'descripcion')
            ->orderBy('codigo')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('descripcion', 'like', "%{$request->search}%")

            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('codigo', $request->input('selected', []))

            )
            ->get();
    }
    public function comprobantes(Request $request): Collection
    {

        return TipoComprobantes::query()
            ->select('codigo', 'descripcion')
            ->orderBy('codigo')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('descripcion', 'like', "%{$request->search}%")

            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('codigo', $request->input('selected', []))

            )
            ->get();
    }
    public function sim(Request $request): Collection
    {
        return SimCard::query()
            ->select('id', 'sim_card')
            ->orderBy('id')
            ->withoutGlobalScopes()
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('sim_card', 'like', "%{$request->search}%")

            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(20)
            )
            ->get();
    }
    public function lineas(Request $request): Collection
    {
        return Lineas::query()
            ->select('id', 'numero')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('numero', 'like', "%{$request->search}%")

            )
            ->withoutGlobalScopes()
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(20)

            )
            ->get();
    }
    public function vehiculos(Request $request): Collection
    {
        return Vehiculos::query()
            ->select('id', 'placa')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('placa', 'like', "%{$request->search}%")

            )
            ->withoutGlobalScopes()
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(20)

            )
            ->get();
    }
    public function modelosDispositivos(Request $request): Collection
    {
        return ModelosDispositivo::query()
            ->select('id', 'modelo', 'marca')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('modelo', 'like', "%{$request->search}%")

            )
            ->withoutGlobalScopes()
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)

            )
            ->get();
    }
}
