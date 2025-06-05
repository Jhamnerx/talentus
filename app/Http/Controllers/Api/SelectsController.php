<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use App\Models\User;
use App\Models\Lineas;
use App\Models\Series;
use App\Models\Ventas;
use App\Models\SimCard;
use App\Models\Ubigeos;
use App\Models\Ciudades;
use App\Models\Clientes;
use App\Models\Categoria;
use App\Models\Productos;
use App\Models\Sustentos;
use App\Models\Vehiculos;
use App\Models\Proveedores;
use App\Models\Dispositivos;
use Illuminate\Http\Request;
use App\Models\TipoDocumento;
use App\Models\MotivoTraslado;
use App\Models\PaymentMethods;
use App\Models\TipoAfectacion;
use App\Models\MotivosTraslado;
use App\Models\TipoComprobantes;
use App\Models\ModelosDispositivo;
use App\Models\CodigosDetracciones;
use App\Models\ModalidadTransporte;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

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
                fn(Builder $query) => $query
                    ->where('nombre', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(30)
            )
            ->active(1)
            ->get();
    }

    public function ciudades(Request $request): Collection
    {

        return Ciudades::query()
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('nombre', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(30)
            )
            ->active(1)
            ->get();
    }
    public function tipoAfectacion(Request $request): Collection
    {
        return TipoAfectacion::query()
            ->select('codigo', 'descripcion')
            ->orderBy('descripcion')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('descripcion', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('codigo', $request->input('selected', [])),
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
                fn(Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
                    ->orwhere('codigo', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('codigo', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(15)
            )
            ->get();
    }

    public function clientes(Request $request): Collection
    {
        return Clientes::query()
            ->select('id', 'razon_social', 'numero_documento', 'tipo_documento_id')
            ->orderBy('id')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('razon_social', 'like', "%{$request->search}%")
                    ->orWhere('numero_documento', 'like', "%{$request->search}%")
            )->when(
                $request->tipo_comprobante == "01" ? true : false,
                fn(Builder $query) => $query
                    ->tipoDoc(6)

            )->when(
                $request->tipo_comprobante == "03" ? true : false,
                fn(Builder $query) => $query


            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),

            )
            ->active(1)
            ->get();
    }
    public function proveedores(Request $request): Collection
    {
        return Proveedores::query() // Elimina todos los scopes globales
            ->select('id', 'razon_social', 'numero_documento')
            ->orderBy('id')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('razon_social', 'like', "%{$request->search}%")
                    ->orWhere('numero_documento', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),

            )
            ->active(1)
            ->get();
    }

    public function invoices(Request $request): Collection
    {

        return Ventas::query()
            ->select('id', 'serie_correlativo', 'fecha_emision', 'divisa', 'total', 'cliente_id')
            ->where('fe_estado', 1)
            ->orderBy('serie_correlativo')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('serie_correlativo', 'like', "%{$request->search}%")
            )->when(
                $request->tipo_comprobante_ref,
                fn(Builder $query) => $query
                    ->where('tipo_comprobante_id', $request->tipo_comprobante_ref)

            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(50)
            )
            ->when(
                $request->exists('code_sunat'),
                fn(Builder $query) => $query->where('code_sunat', $request->input('code_sunat'))
            )
            ->get()
            ->map(function (Ventas $invoice) {

                if ($invoice->tipo_comprobante_id == '01') {
                    $invoice->imagen = Storage::url('facturacion/images/factura.png');
                } else {
                    $invoice->imagen = Storage::url('facturacion/images/boleta.png');
                }

                $invoice->option_description = $invoice->cliente->razon_social . ' | ' . $invoice->fecha_emision->format('d-m-Y') . " | " . $invoice->divisa . " " . $invoice->total;
                return $invoice;
            });
    }

    public function series(Request $request): Collection
    {

        return Series::query()
            ->select('id', 'serie', 'correlativo', 'tipo_comprobante_id')
            ->orderBy('id')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('serie', 'like', "%{$request->search}%")

            )
            ->where('tipo_comprobante_id', $request->tipo_comprobante)
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('serie', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)
            )
            ->get();
    }

    public function productos(Request $request): Collection
    {

        return Productos::query()
            ->select('id', 'codigo', 'serie', 'descripcion', 'valor_unitario', 'unit_code', 'stock')
            ->orderBy('id')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('serie', 'like', "%{$request->search}%")
                    ->orwhere('descripcion', 'like', "%{$request->search}%")
                    ->orwhere('codigo', 'like', "%{$request->search}%")

            )
            ->where('stock', '>', 0)
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)
            )->active(1)
            ->get()->map(function (Productos $producto) {

                $producto->imagen = $producto->image ? Storage::url($producto->image->url) : Storage::url('productos/default.jpg');
                $producto->option_description = $producto->codigo . " - Stock: " . $producto->stock . " " . $producto->unit->descripcion . " - Precio: $" . $producto->valor_unitario;

                return $producto;
            });
    }

    public function documentos(Request $request): Collection
    {

        return TipoDocumento::query()
            ->select('codigo', 'descripcion')
            ->orderBy('codigo')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('descripcion', 'like', "%{$request->search}%")

            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('codigo', $request->input('selected', []))

            )
            ->get();
    }

    public function tipoComprobantes(Request $request): Collection
    {

        return TipoComprobantes::query()
            ->select('codigo', 'descripcion')
            ->orderBy('codigo')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('descripcion', 'like', "%{$request->search}%")

            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('codigo', $request->input('selected', []))

            )
            ->get();
    }

    public function sim(Request $request): Collection
    {
        $sim = SimCard::query()
            ->select('id', 'sim_card')
            ->orderBy('id')
            ->withoutGlobalScopes()
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('sim_card', 'like', "%{$request->search}%")

            );

        if ($request->input('of') == '01') {
            $sim->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('sim_card', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)
            );
        } else {
            $sim->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)
            );
        }


        return $sim->get();
    }
    public function lineas(Request $request): Collection
    {
        return Lineas::query()
            ->with(['vehiculo' => function ($query) {
                $query->select('numero', 'id', 'placa');
            }])
            ->select('id', 'numero', 'operador')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('numero', 'like', "%{$request->search}%")

            )
            ->withoutGlobalScopes()
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('numero', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(60)

            )
            ->get()->map(function (Lineas $linea) {


                if ($linea->vehiculo) {

                    $linea->option_description = $linea->operador . " - " . "<b>" . $linea->vehiculo->placa . "</b>";
                } else {

                    $linea->option_description = $linea->operador . " - " . 'LIBRE';
                }
                //

                return $linea;
            });
    }

    public function dispositivos(Request $request): Collection
    {
        return Dispositivos::query()
            ->with(['modelo' => function ($query) {
                $query->select('modelo', 'id');
            }])
            ->select('id', 'imei', 'modelo_id')
            ->when(
                $request->search,
                function (Builder $query) use ($request) {
                    $query->where('imei', 'like', "%{$request->search}%")
                        ->orWhereHas('modelo', function ($q) use ($request) {
                            $q->where('modelo', 'like', "%{$request->search}%");
                        });
                }
            )
            ->withoutGlobalScopes()
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('imei', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(50)
            )
            ->get()->map(function (Dispositivos $dispositivo) {
                $vehiculo_actual = $dispositivo->vehiculoActual();

                if ($vehiculo_actual && $dispositivo->modelo) {
                    $dispositivo->option_description = $dispositivo->modelo->modelo . " - " . "<b>" . $vehiculo_actual->placa . "</b>";
                } elseif ($dispositivo->modelo) {
                    $dispositivo->option_description = $dispositivo->modelo->modelo . " - " . 'LIBRE';
                } else {
                    $dispositivo->option_description = '';
                }

                return $dispositivo;
            });
    }

    public function vehiculos(Request $request): Collection
    {
        return Vehiculos::query()
            ->with(['cliente' => function ($query) {
                $query->select('razon_social', 'numero_documento', 'id');
            }])
            ->select('id', 'placa', 'clientes_id')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('placa', 'like', "%{$request->search}%")

            )
            ->withoutGlobalScopes()
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)

            )
            ->get()->map(function (Vehiculos $vehiculo) {

                if ($vehiculo->cliente) {

                    $vehiculo->option_description = $vehiculo->cliente->razon_social . " | " . $vehiculo->cliente->numero_documento;
                } else {

                    $vehiculo->option_description = "";
                }


                //

                return $vehiculo;
            });
    }
    public function modelosDispositivos(Request $request): Collection
    {
        $modelos = ModelosDispositivo::query()
            ->select('id', 'modelo', 'marca')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('modelo', 'like', "%{$request->search}%")

            )
            ->withoutGlobalScopes();
        if ($request->input('modelo')) {

            $modelos->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('modelo', $request->input('selected', [])),

            );
        } else {
            $modelos->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),

            );
        }

        return $modelos->get();
    }

    public function sustentos(Request $request): Collection
    {

        return Sustentos::query()
            ->select('id', 'codigo', 'descripcion', 'tipo')
            ->orderBy('id')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('serie', 'like', "%{$request->search}%")

            )
            ->where('tipo', $request->tipo_comprobante == "07" ? "C" : "D")
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('serie', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)
            )
            ->get();
    }

    public function motivosTraslado(Request $request): Collection
    {

        return MotivoTraslado::query()
            ->select('codigo', 'descripcion')
            ->orderBy('codigo')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('descripcion', 'like', "%{$request->search}%")

            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('codigo', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)
            )
            ->get();
    }

    public function modalidadTraslado(Request $request): Collection
    {

        return ModalidadTransporte::query()
            ->select('codigo', 'descripcion')
            ->orderBy('codigo')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('descripcion', 'like', "%{$request->search}%")

            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('codigo', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)
            )
            ->get();
    }

    public function ubigeos(Request $request): Collection
    {

        return Ubigeos::query()
            ->select('id', 'ubigeo_inei', 'departamento', 'provincia', 'distrito')
            ->orderBy('departamento')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('ubigeo_inei', 'like', "%{$request->search}%")
                    ->orWhere('departamento', 'like', "%{$request->search}%")
                    ->orWhere('provincia', 'like', "%{$request->search}%")
                    ->orWhere('distrito', 'like', "%{$request->search}%")
                    ->orWhereRaw("CONCAT(departamento, ' ', provincia, ' ', distrito) LIKE '%{$request->search}%'")
                    ->orWhereRaw("CONCAT(provincia, ' ', distrito) LIKE '%{$request->search}%'")
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('ubigeo_inei', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)
            )
            ->get()->map(function (Ubigeos $ubigeo) {

                $ubigeo->option_description = '<b>' . $ubigeo->ubigeo_inei . '</b> - ' . $ubigeo->departamento . ' - ' . $ubigeo->provincia . ' - ' . $ubigeo->distrito;

                return $ubigeo;
            });
    }

    public function comprobantes(Request $request): Collection
    {

        return Ventas::query()


            ->with(['cliente' => function ($query) {
                $query->select('razon_social', 'id', 'numero_documento');
            }])
            ->select('id', 'serie_correlativo', 'cliente_id')
            ->orderBy('serie_correlativo')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('serie_correlativo', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)
            )
            ->get()->map(function (Ventas $venta) {

                $venta->option_description = '<b>' . $venta->serie_correlativo . '</b> - ' . $venta->cliente->razon_social . ' - ';

                return $venta;
            });
    }

    public function codigosDetracciones(Request $request): Collection
    {

        return CodigosDetracciones::query()
            ->select('codigo', 'descripcion', 'porcentaje')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('codigo', 'like', "%{$request->search}%")
                    ->Orwhere('descripcion', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('codigo', $request->input('selected', [])),
            )
            ->get()->map(function (CodigosDetracciones $detraccion) {

                $detraccion->option_description = '<b>' . $detraccion->codigo . '</b> - ' . $detraccion->descripcion;

                return $detraccion;
            });
    }

    public function metodosPago(Request $request): Collection
    {

        return PaymentMethods::query()
            ->select('codigo', 'descripcion')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('codigo', 'like', "%{$request->search}%")
                    ->Orwhere('descripcion', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('codigo', $request->input('selected', [])),
            )
            ->get();
    }

    public function user(Request $request): Collection
    {

        return User::query()

            ->select('id', 'name')
            ->orderBy('id')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(20)
            )
            ->role('tecnico')
            ->get();
    }

    public function prueba(Request $request)
    {
        $values = [
            [
                'id' => '50',
                'label' => 'Declaración Aduanera de Mercancías'
            ],
            [
                'id' => '52',
                'label' => 'Declaración Simplificada (DS)'
            ]
        ];

        return collect($values)
            ->when(
                $request->search,
                fn($collection) => $collection->filter(function ($value) use ($request) {
                    return str_contains(strtolower($value['label']), strtolower($request->search));
                })
            )
            ->when(
                $request->exists('selected'),
                fn($collection) => $collection->whereIn('id', $request->input('selected', [])),
                fn($collection) => $collection->take(20)
            )
            ->values();
    }
    public function puertosPeru(Request $request)
    {
        $values = [
            [
                "codigo" => "PUB",
                "nombre" => "Bayóvar",
                "Ubigeo" => "200801",
                "descripcion" => "PUB-Bayóvar-200801"
            ],
            [
                "codigo" => "CLL",
                "nombre" => "Callao",
                "Ubigeo" => "070101",
                "descripcion" => "CLL-Callao-070101"
            ],
            [
                "codigo" => "CON",
                "nombre" => "Conchán",
                "Ubigeo" => "150119",
                "descripcion" => "CON-Conchán-150119"
            ],
            [
                "codigo" => "CHY",
                "nombre" => "Chancay",
                "Ubigeo" => "150605",
                "descripcion" => "CHY-Chancay-150605"
            ],
            [
                "codigo" => "CHM",
                "nombre" => "Chimbote",
                "Ubigeo" => "021801",
                "descripcion" => "CHM-Chimbote-021801"
            ],
            [
                "codigo" => "EEN",
                "nombre" => "Eten",
                "Ubigeo" => "140113",
                "descripcion" => "EEN-Eten-140113"
            ],
            [
                "codigo" => "HCO",
                "nombre" => "Huacho",
                "Ubigeo" => "150801",
                "descripcion" => "HCO-Huacho-150801"
            ],
            [
                "codigo" => "HUY",
                "nombre" => "Huarmey",
                "Ubigeo" => "021101",
                "descripcion" => "HUY-Huarmey-021101"
            ],
            [
                "codigo" => "ILQ",
                "nombre" => "Ilo",
                "Ubigeo" => "180301",
                "descripcion" => "ILQ-Ilo-180301"
            ],
            [
                "codigo" => "IQT",
                "nombre" => "Iquitos",
                "Ubigeo" => "160101",
                "descripcion" => "IQT-Iquitos-160101"
            ],
            [
                "codigo" => "MRI",
                "nombre" => "Matarani",
                "Ubigeo" => "040701",
                "descripcion" => "MRI-Matarani-040701"
            ],
            [
                "codigo" => "PAI",
                "nombre" => "Paita",
                "Ubigeo" => "200501",
                "descripcion" => "PAI-Paita-200501"
            ],
            [
                "codigo" => "PIO",
                "nombre" => "Pisco",
                "Ubigeo" => "110505",
                "descripcion" => "PIO-Pisco-110505"
            ],
            [
                "codigo" => "PCL",
                "nombre" => "Pucallpa",
                "Ubigeo" => "250101",
                "descripcion" => "PCL-Pucallpa-250101"
            ],
            [
                "codigo" => "PUN",
                "nombre" => "Puno",
                "Ubigeo" => "210101",
                "descripcion" => "PUN-Puno-210101"
            ],
            [
                "codigo" => "SVY",
                "nombre" => "Salaverry",
                "Ubigeo" => "130109",
                "descripcion" => "SVY-Salaverry-130109"
            ],
            [
                "codigo" => "SNX",
                "nombre" => "San Nicolas",
                "Ubigeo" => "110304",
                "descripcion" => "SNX-San Nicolas-110304"
            ],
            [
                "codigo" => "SUP",
                "nombre" => "Supe",
                "Ubigeo" => "150204",
                "descripcion" => "SUP-Supe-150204"
            ],
            [
                "codigo" => "TYL",
                "nombre" => "Talara",
                "Ubigeo" => "200701",
                "descripcion" => "TYL-Talara-200701"
            ],
            [
                "codigo" => "YMS",
                "nombre" => "Yurimaguas",
                "Ubigeo" => "160201",
                "descripcion" => "YMS-Yurimaguas-160201"
            ],
            [
                "codigo" => "ZOR",
                "nombre" => "Zorritos",
                "Ubigeo" => "240103",
                "descripcion" => "ZOR-Zorritos-240103"
            ]
        ];

        return collect($values)
            ->when(
                $request->search,
                fn($collection) => $collection->filter(function ($value) use ($request) {
                    $searchTerm = strtolower($request->search);
                    return str_contains(strtolower($value['codigo']), $searchTerm)
                        || str_contains(strtolower($value['Ubigeo']), $searchTerm)
                        || str_contains(strtolower($value['nombre']), $searchTerm);
                })
            )
            ->when(
                $request->exists('selected'),
                fn($collection) => $collection->whereIn('codigo', $request->input('selected', [])),
                fn($collection) => $collection->take(20)
            )
            ->values();
    }

    public function codesProductosGre(Request $request)
    {

        $values = [
            [
                "codigo" => "126",
                "descripcion" => "DOCENA POR 10**6"
            ],
            [
                "codigo" => "12U",
                "descripcion" => "DOCENA"
            ],
            [
                "codigo" => "2U",
                "descripcion" => "PAR"
            ],
            [
                "codigo" => "2U6",
                "descripcion" => "PAR POR 10**6"
            ],
            [
                "codigo" => "AM",
                "descripcion" => "AMPOLLA"
            ],
            [
                "codigo" => "BAL",
                "descripcion" => "BALDE"
            ],
            [
                "codigo" => "BID",
                "descripcion" => "BIDONES"
            ],
            [
                "codigo" => "BLS",
                "descripcion" => "BOLSA"
            ],
            [
                "codigo" => "BOB",
                "descripcion" => "BOBINAS"
            ],
            [
                "codigo" => "BOT",
                "descripcion" => "BOTELLAS"
            ],
            [
                "codigo" => "BRR",
                "descripcion" => "BARRILES"
            ],
            [
                "codigo" => "CAJ",
                "descripcion" => "CAJA"
            ],
            [
                "codigo" => "CIL",
                "descripcion" => "CILINDRO"
            ],
            [
                "codigo" => "CM",
                "descripcion" => "CENTIMETRO LINEAL"
            ],
            [
                "codigo" => "CM2",
                "descripcion" => "CENTIMETRO CUADRADO"
            ],
            [
                "codigo" => "CM3",
                "descripcion" => "CENTIMETRO CUBICO"
            ],
            [
                "codigo" => "CON",
                "descripcion" => "CONOS"
            ],
            [
                "codigo" => "CRT",
                "descripcion" => "CARTONES"
            ],
            [
                "codigo" => "FDO",
                "descripcion" => "FARDO"
            ],
            [
                "codigo" => "FRC",
                "descripcion" => "FRASCOS"
            ],
            [
                "codigo" => "GAL",
                "descripcion" => "US GALON (3,7843 L)"
            ],
            [
                "codigo" => "GLE",
                "descripcion" => "GALON INGLES (4,545956L)"
            ],
            [
                "codigo" => "GR",
                "descripcion" => "GRAMO"
            ],
            [
                "codigo" => "GRU",
                "descripcion" => "GRUESA"
            ],
            [
                "codigo" => "HL",
                "descripcion" => "HECTOLITRO"
            ],
            [
                "codigo" => "HOJ",
                "descripcion" => "HOJA"
            ],
            [
                "codigo" => "JGS",
                "descripcion" => "JUEGO"
            ],
            [
                "codigo" => "KG",
                "descripcion" => "KILOGRAMO"
            ],
            [
                "codigo" => "KG3",
                "descripcion" => "KILOGRAMO POR 10**3 (TM)"
            ],
            [
                "codigo" => "KG6",
                "descripcion" => "KILOGRAMO POR 10**6"
            ],
            [
                "codigo" => "KGA",
                "descripcion" => "KILOGRAMO INGREDIENTE ACTIVO"
            ],
            [
                "codigo" => "KI",
                "descripcion" => "QUILATE"
            ],
            [
                "codigo" => "KI6",
                "descripcion" => "QUILATE 10**6"
            ],
            [
                "codigo" => "KIT",
                "descripcion" => "KIT"
            ],
            [
                "codigo" => "KL6",
                "descripcion" => "KILOS X 10 EXP - 6 (MG)"
            ],
            [
                "codigo" => "KL9",
                "descripcion" => "KILOS X 10 EXP -9"
            ],
            [
                "codigo" => "KM",
                "descripcion" => "KILOMETRO"
            ],
            [
                "codigo" => "KW3",
                "descripcion" => "KILOVATIO HORA POR 10**3 (1000KWH)"
            ],
            [
                "codigo" => "KW6",
                "descripcion" => "KILOVATIO HORA POR 10**6"
            ],
            [
                "codigo" => "KWH",
                "descripcion" => "KILOVATIO HORA"
            ],
            [
                "codigo" => "L",
                "descripcion" => "LITRO"
            ],
            [
                "codigo" => "L 6",
                "descripcion" => "LITRO POR 10**6"
            ],
            [
                "codigo" => "LAT",
                "descripcion" => "LATAS"
            ],
            [
                "codigo" => "LB",
                "descripcion" => "LIBRAS"
            ],
            [
                "codigo" => "M",
                "descripcion" => "METRO"
            ],
            [
                "codigo" => "M 6",
                "descripcion" => "METRO POR 10**6"
            ],
            [
                "codigo" => "M2",
                "descripcion" => "METRO CUADRADO"
            ],
            [
                "codigo" => "M26",
                "descripcion" => "METRO CUADRADO POR 10**6"
            ],
            [
                "codigo" => "M3",
                "descripcion" => "METRO CUBICO"
            ],
            [
                "codigo" => "M36",
                "descripcion" => "METRO CUBICO POR 10**6"
            ],
            [
                "codigo" => "MGA",
                "descripcion" => "MILIGRAMO ACTIVO"
            ],
            [
                "codigo" => "MGR",
                "descripcion" => "MILIGRAMOS"
            ],
            [
                "codigo" => "ML",
                "descripcion" => "MILILITRO"
            ],
            [
                "codigo" => "MLL",
                "descripcion" => "MILLARES"
            ],
            [
                "codigo" => "MM",
                "descripcion" => "MILIMETRO"
            ],
            [
                "codigo" => "MM2",
                "descripcion" => "MILIMETRO CUADRADO"
            ],
            [
                "codigo" => "MM3",
                "descripcion" => "MILIMETRO CUBICO"
            ],
            [
                "codigo" => "MU",
                "descripcion" => "MUESTRAS"
            ],
            [
                "codigo" => "MWH",
                "descripcion" => "MEGAWATT HORA"
            ],
            [
                "codigo" => "OZ",
                "descripcion" => "ONZAS"
            ],
            [
                "codigo" => "PAI",
                "descripcion" => "PAILAS"
            ],
            [
                "codigo" => "PAL",
                "descripcion" => "PALETAS"
            ],
            [
                "codigo" => "PAQ",
                "descripcion" => "PAQUETE"
            ],
            [
                "codigo" => "PL",
                "descripcion" => "PLACAS"
            ],
            [
                "codigo" => "PLC",
                "descripcion" => "PLANCHAS"
            ],
            [
                "codigo" => "PLG",
                "descripcion" => "PLIEGO"
            ],
            [
                "codigo" => "PS",
                "descripcion" => "PIES"
            ],
            [
                "codigo" => "PS2",
                "descripcion" => "PIES CUADRADOS"
            ],
            [
                "codigo" => "PS3",
                "descripcion" => "PIES CUBICOS"
            ],
            [
                "codigo" => "PST",
                "descripcion" => "PIES TABLARES(MADERA)"
            ],
            [
                "codigo" => "PUL",
                "descripcion" => "PULGADAS"
            ],
            [
                "codigo" => "PZA",
                "descripcion" => "PIEZAS"
            ],
            [
                "codigo" => "QQ",
                "descripcion" => "QUINTAL METRICO (100 KG)"
            ],
            [
                "codigo" => "QUT",
                "descripcion" => "QUINTAL USA (100 LB)"
            ],
            [
                "codigo" => "RAM",
                "descripcion" => "RAMOS"
            ],
            [
                "codigo" => "RES",
                "descripcion" => "RESMA"
            ],
            [
                "codigo" => "ROL",
                "descripcion" => "ROLLOS"
            ],
            [
                "codigo" => "SAC",
                "descripcion" => "SACO"
            ],
            [
                "codigo" => "SET",
                "descripcion" => "SET"
            ],
            [
                "codigo" => "TAM",
                "descripcion" => "TAMBOR"
            ],
            [
                "codigo" => "TC",
                "descripcion" => "TONELADA CORTA"
            ],
            [
                "codigo" => "TCS",
                "descripcion" => "TONELADA CORTA SECA"
            ],
            [
                "codigo" => "TIR",
                "descripcion" => "TIRAS"
            ],
            [
                "codigo" => "TL",
                "descripcion" => "TONELADA LARGA"
            ],
            [
                "codigo" => "TLS",
                "descripcion" => "TONELADA LARGA SECA"
            ],
            [
                "codigo" => "TM",
                "descripcion" => "TONELADAS"
            ],
            [
                "codigo" => "TM3",
                "descripcion" => "TONELADA CUBICA"
            ],
            [
                "codigo" => "TMS",
                "descripcion" => "TONELADA METRICA SECA"
            ],
            [
                "codigo" => "TUB",
                "descripcion" => "TUBOS"
            ],
            [
                "codigo" => "U",
                "descripcion" => "UNIDAD"
            ],
            [
                "codigo" => "U 3",
                "descripcion" => "UNIDAD POR 10**3"
            ],
            [
                "codigo" => "U 6",
                "descripcion" => "UNIDAD PO 10**6"
            ],
            [
                "codigo" => "U2",
                "descripcion" => "CIENTO DE UNIDADES"
            ],
            [
                "codigo" => "U3",
                "descripcion" => "MILES DE UNIDADES"
            ],
            [
                "codigo" => "U6",
                "descripcion" => "MILLON DE UNIDADES"
            ],
            [
                "codigo" => "YD",
                "descripcion" => "YARDA"
            ],
            [
                "codigo" => "YD2",
                "descripcion" => "YARDA CUADRADA"
            ]
        ];

        return collect($values)
            ->when(
                $request->search,
                fn($collection) => $collection->filter(function ($value) use ($request) {
                    $searchTerm = strtolower($request->search);
                    $codigo = strtolower($value['codigo']);
                    $descripcion = strtolower($value['descripcion']);
                    return str_contains($codigo, $searchTerm) || str_contains($descripcion, $searchTerm);
                })
            )
            ->when(
                $request->exists('selected'),
                fn($collection) => $collection->whereIn('codigo', $request->input('selected', [])),
                fn($collection) => $collection->take(3)
            )
            ->values();
    }
}
