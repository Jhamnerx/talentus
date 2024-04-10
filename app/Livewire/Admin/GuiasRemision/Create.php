<?php

namespace App\Livewire\Admin\GuiasRemision;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Series;
use App\Models\SimCard;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Productos;
use App\Models\Dispositivos;
use App\Models\GuiaRemision;
use App\Models\MotivosTraslado;
use PhpParser\Builder\Function_;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\ModelosDispositivo;
use Illuminate\Support\Collection;
use App\Http\Requests\GuiaRemisionRequest;
use App\Http\Controllers\Admin\Almacen\GuiaRemisionController;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;
use App\Models\plantilla;

class Create extends Component
{
    public Collection $items_dispositivos;
    public Collection $items_sim_card;

    public $tipo_documento = '6';
    public $serie, $correlativo, $serie_correlativo, $fecha_emision, $venta_id, $cliente_id,
        $numero_documento = null, $razon_social = '', $codigo_traslado,
        $motivo_traslado_id = '01', $descripcion_motivo_traslado = '',  $modalidad_transporte_id =  '02',
        $fecha_inicio_traslado, $peso = '1.00', $cantidad_items = 1, $numero_contenedor,
        $code_puerto, $data_puerto = [];

    public $direccion_partida, $ubigeo_partida, $direccion_llegada, $ubigeo_llegada;
    public $codigo_establecimiento_partida = '0000', $codigo_establecimiento_llegada = '0000';
    public $observacion = '';

    public $terceros_tipo_documento, $terceros_num_doc, $terceros_razon_social;

    public $transp_tipo_doc, $transp_numero_doc, $transp_razon_social, $transp_placa, $tipo_doc_chofer, $numero_doc_chofer;
    public $asignarTecnico = false;

    public $docu_rel_tipo = '50', $docu_rel_numero =  '000-0000-10-000000';

    public $tecnico_id;

    public Collection $items;
    public Collection $selected;
    public $selected_id;

    public plantilla $plantilla;

    public function mount()
    {
        $this->plantilla = plantilla::first();
        $this->setSerieMount();
        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        $this->fecha_inicio_traslado = Carbon::now()->format('Y-m-d');

        $this->items = collect();
        $this->items_dispositivos = collect();
        $this->items_sim_card = collect();
        $this->selected = collect([
            'producto_id' => "",
            'codigo' => "",
            'cantidad' => 1,
            'unidad_medida' => "",
            'descripcion' => "",
        ]);
    }


    public function render()
    {

        return view('livewire.admin.guias-remision.create');
    }

    public function setSerieMount()
    {
        $serie = Series::where('tipo_comprobante_id', '09')->first();
        $this->serie = $serie->serie;
        $this->correlativo = $serie->correlativo + 1;
        $this->serie_correlativo = $this->serie . "-" . $this->correlativo;
    }

    public function changeSerieUpdate($serie)
    {

        if ($serie) {

            $serie = Series::where('serie', $serie)->first();
            $this->serie = $serie->serie;
            $this->correlativo = $serie->correlativo + 1;
            $this->serie_correlativo = $this->serie . "-" . $this->correlativo;
        } else {

            $this->reset('correlativo');
        }
    }

    public function updatedSerie($value)
    {
        $this->changeSerieUpdate($value);
    }

    function addProducto()
    {

        $this->validate([
            'selected.producto_id' => 'required',
            'selected.codigo' => 'required',
            'selected.cantidad' => 'required',
            'selected.unidad_medida' => 'required',
            'selected.descripcion' => 'required',

        ], [
            'selected.producto_id.required' => 'Seleccion una producto',
            'selected.codigo.required' => 'Este producto no tiene codigo',
            'selected.cantidad.required' => 'Por favor ingresa una cantidad',
            'selected.unidad_medida.required' => 'Producto sin unidad de medida',
            'selected.descripcion.required' => 'Ingrese una descripción',
        ]);

        try {

            $this->items->push([
                'producto_id' => $this->selected["producto_id"],
                'codigo' => $this->selected->get('codigo'),
                'cantidad' => $this->selected["cantidad"],
                'unidad_medida' => $this->selected["unidad_medida"],
                'descripcion' => $this->selected["descripcion"],
            ]);

            $this->addedProducto();
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL AÑADIR',
                mensaje: 'ERROR: ' . $e->getMessage(),
            );
        }
    }

    public function addedProducto()
    {

        $this->selected = collect();
        $this->reset('selected_id');

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'PRODUCTO AÑADIDO',
            mensaje: 'se añadio correctamente',
        );
    }

    function updatedSelectedId(Productos $producto)
    {

        $this->selected = collect([
            'producto_id' => $producto->id,
            'codigo' => $producto->codigo,
            'cantidad' => "1",
            'unidad_medida' => $producto->unit->codigo,
            'descripcion' => $producto->descripcion
        ]);
    }


    public function searchCliente()
    {
        try {

            $cliente = Clientes::where('numero_documento', '=', $this->numero_documento)->firstOrFail();
            $this->razon_social = $cliente->razon_social;
            $this->cliente_id = $cliente->id;
        } catch (Exception $e) {

            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL BUSCAR',
                mensaje: 'No se encontro resultados: ' . $e->getMessage(),
            );

            report($e);
        }
    }


    public function save()
    {
        $request = new GuiaRemisionRequest();
        $data = $this->validate($request->rules(null, $this->motivo_traslado_id, $this->docu_rel_tipo, $this->plantilla->ruc), $request->messages());

        try {
            $guia = GuiaRemision::create($data);

            GuiaRemision::createItems($guia, $data["items"]);

            $guia->getSerie->increment('correlativo');

            if ($this->asignarTecnico) {

                if (count($data["items_dispositivos"]) > 0) {

                    Dispositivos::asignarDispositivos(User::find($this->tecnico_id), $data["items_dispositivos"], $guia);
                }

                if (count($data["items_sim_card"]) > 0) {

                    SimCard::asignarSimCard(User::find($this->tecnico_id), $data["items_sim_card"], $guia);
                }
            }

            $api = new ApiFacturacion();
            $mensaje = $api->emitirGuia($guia);

            if (array_key_exists('success', $mensaje) && $mensaje['success'] == true) {

                if ($mensaje['fe_codigo_error']) {

                    session()->flash('store', $mensaje["fe_mensaje_error"] . ': Intenta enviar en un rato');
                    $this->redirectRoute('admin.almacen.guias.index');
                } else {

                    session()->flash('store', $mensaje['fe_mensaje_sunat']);
                    $this->redirectRoute('admin.almacen.guias.index');
                }
            } else {
                $guia->getSerie->decrement('correlativo');
                $guia->forceDelete();

                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'ERROR AL ENVIAR A SUNAT, VUELVE A REGISTRAR',
                    mensaje: $mensaje['error_session'],
                );
            }
        } catch (\Throwable $th) {


            $this->dispatch(
                'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }
    public function updatedMotivoTrasladoId($value)
    {

        if ($value == '04' || '02' || '07') {

            $cliente = Clientes::where('numero_documento', $this->plantilla->ruc)->first();
            $this->cliente_id = $cliente->id;
            $this->tipo_documento = $cliente->tipo_documento_id;
            $this->numero_documento = $cliente->numero_documento;
            $this->razon_social = $cliente->razon_social;
        }
    }

    public function registarImei($imei)
    {
        $this->dispatch('add-imei-modal', imei: $imei);
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
    }

    public function updatedCodePuerto($value)
    {
        list($code_puerto, $nombre_puerto, $ubigeo_puerto) = explode('-', $value);
        $this->data_puerto = [
            'code_puerto' => $code_puerto,
            'nombre_puerto' => $nombre_puerto,
            'ubigeo_puerto' => $ubigeo_puerto,
        ];
    }

    public function addSimCard($sim_card)
    {
        $this->dispatch('add-sim-card-modal', sim_card: $sim_card);
    }

    public function addProductoModal($producto)
    {
        $this->dispatch('add-producto-modal', producto: $producto);
    }
}
