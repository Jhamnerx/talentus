<?php

namespace App\Livewire\Admin\GuiasRemision;

use Exception;
use App\Models\User;
use App\Models\Series;
use App\Models\SimCard;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\plantilla;
use App\Models\Productos;
use App\Models\Dispositivos;
use App\Models\GuiaRemision;
use App\Models\MotivosTraslado;
use Illuminate\Support\Collection;
use App\Http\Requests\GuiaRemisionRequest;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;

class Edit extends Component
{
    public GuiaRemision $guia;
    public Collection $items_dispositivos;
    public Collection $items_sim_card;

    public $tipo_documento = '6';
    public $serie, $correlativo, $serie_correlativo, $fecha_emision, $venta_id, $cliente_id, $numero_documento = '', $razon_social = '', $codigo_traslado,
        $motivo_traslado_id = '01', $descripcion_motivo_traslado = '',  $modalidad_transporte_id =  '02', $fecha_inicio_traslado, $peso = '1.00', $cantidad_items = 1, $numero_contenedor,
        $code_puerto, $data_puerto = [];

    public $direccion_partida, $ubigeo_partida, $direccion_llegada, $ubigeo_llegada;
    public $codigo_establecimiento_partida, $codigo_establecimiento_llegada;
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

        $this->serie = $this->guia->serie;
        $this->correlativo = $this->guia->correlativo;
        $this->serie_correlativo = $this->guia->serie_correlativo;
        $this->fecha_emision = $this->guia->fecha_emision;
        $this->venta_id = $this->guia->venta_id;
        $this->cliente_id = $this->guia->cliente_id;
        $this->numero_documento = $this->guia->cliente->numero_documento;
        $this->razon_social = $this->guia->cliente->razon_social;
        $this->codigo_traslado = $this->guia->codigo_traslado;
        $this->motivo_traslado_id = $this->guia->motivo_traslado_id;
        $this->descripcion_motivo_traslado = $this->guia->descripcion_motivo_traslado;
        $this->modalidad_transporte_id = $this->guia->modalidad_transporte_id;
        $this->fecha_inicio_traslado = $this->guia->fecha_inicio_traslado;
        $this->peso = $this->guia->peso;
        $this->cantidad_items = $this->guia->cantidad_items;
        $this->numero_contenedor = $this->guia->numero_contenedor;
        $this->code_puerto = $this->guia->code_puerto;
        $this->data_puerto = $this->guia->data_puerto;

        $this->direccion_partida = $this->guia->direccion_partida;
        $this->ubigeo_partida = $this->guia->ubigeo_partida;
        $this->direccion_llegada = $this->guia->direccion_llegada;
        $this->ubigeo_llegada = $this->guia->ubigeo_llegada;
        $this->codigo_establecimiento_partida = $this->guia->codigo_establecimiento_partida;
        $this->codigo_establecimiento_llegada = $this->guia->codigo_establecimiento_llegada;
        $this->observacion = $this->guia->observacion;

        $this->docu_rel_tipo = $this->guia->docu_rel_tipo;
        $this->docu_rel_numero = $this->guia->docu_rel_numero;

        if ($this->guia->tecnico_id) {

            $this->asignarTecnico = true;
            $this->tecnico_id = $this->guia->tecnico_id;

            $this->items_dispositivos = collect($this->guia->dispositivos->pluck('imei')->toArray());
            $this->items_sim_card = collect($this->guia->sim_cards->pluck('sim_card')->toArray());
        }
        $this->items = collect($this->guia->detalle->toArray());

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

        return view('livewire.admin.guias-remision.edit');
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


    function selectProduct(Productos $producto)
    {
        $this->selected = collect([
            'producto_id' => $producto->id,
            'codigo' => $producto->codigo,
            'cantidad' => "1",
            'unidad_medida' => $producto->unit->codigo,
            'descripcion' => $producto->nombre
        ]);
    }

    public function registarImei($imei)
    {
        $this->dispatch('add-imei-modal', imei: $imei);
    }



    public function updated($name, $value)
    {
        $request = new GuiaRemisionRequest();
        $this->validateOnly($name, $request->rules($this->guia), $request->messages());
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
    }

    public function save()
    {

        $request = new GuiaRemisionRequest();
        $data = $this->validate($request->rules($this->guia), $request->messages());

        try {

            $this->guia->update($data);

            $this->guia->detalle()->delete();

            GuiaRemision::createItems($this->guia, $data["items"]);

            //$this->guia->dispositivos()->delete();

            if ($this->asignarTecnico) {



                if (count($data["items_dispositivos"]) > 0) {

                    Dispositivos::updateAsignarDispositivos(User::find($this->tecnico_id), $data["items_dispositivos"], $this->guia);
                }

                if (count($data["items_sim_card"]) > 0) {

                    SimCard::updateAsignarSimCard(User::find($this->tecnico_id), $data["items_sim_card"], $this->guia);
                }
            }

            $api = new ApiFacturacion();

            $mensaje = $api->createXmlGuia($this->guia);

            if ($mensaje['fe_codigo_error']) {

                session()->flash('store', $mensaje["fe_mensaje_error"] . ': Intenta enviar en un rato');
                $this->redirectRoute('admin.almacen.guias.index');
            } else {

                session()->flash('store', $mensaje['fe_mensaje_sunat']);
                $this->redirectRoute('admin.almacen.guias.index');
            }

            //return redirect()->route('admin.almacen.guias.index')->with('update', 'La guia se registro con exito');
        } catch (\Throwable $th) {
            $this->dispatch(
                'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }
}
