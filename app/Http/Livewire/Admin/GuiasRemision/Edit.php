<?php

namespace App\Http\Livewire\Admin\GuiasRemision;

use Exception;
use App\Models\User;
use App\Models\SimCard;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Productos;
use App\Models\Dispositivos;
use App\Models\GuiaRemision;
use App\Models\MotivosTraslado;
use Illuminate\Support\Collection;
use App\Http\Requests\GuiaRemisionRequest;

class Edit extends Component
{
    public GuiaRemision $guia;
    public $imei_list = [];
    public $imeis_add = [];

    public $sim_list = [];
    public $sim_add = [];

    public $events = [];

    public $error_msg;

    public $serie_numero, $fecha_emision;
    public $tipo_documento, $numero_documento, $razon_social;
    public $motivo_traslado, $modalidad_traslado, $fecha_inicio_traslado, $peso, $cantidad_items, $numero_contenedor, $code_puerto;
    public $direccion_partida, $ubigeo_partida, $direccion_llegada, $ubigeo_llegada;
    public $factura_id, $asignarTecnico = false;
    public $users_id;
    public Collection $items;

    public Collection $selected;


    public function mount()
    {

        $this->serie_numero = $this->guia->serie_numero;
        $this->fecha_emision = $this->guia->fecha_emision->format('Y-m-d');
        $this->tipo_documento = $this->guia->tipo_documento;
        $this->numero_documento = $this->guia->numero_documento;
        $this->razon_social = $this->guia->razon_social;
        $this->motivo_traslado = $this->guia->motivo_traslado;
        $this->modalidad_traslado = $this->guia->modalidad_traslado;
        $this->fecha_inicio_traslado = $this->guia->fecha_inicio_traslado->format('Y-m-d');
        $this->peso = $this->guia->peso;
        $this->cantidad_items = $this->guia->cantidad_items;
        $this->numero_contenedor = $this->guia->numero_contenedor;
        $this->code_puerto = $this->guia->code_puerto;
        $this->direccion_partida = $this->guia->direccion_partida;
        $this->ubigeo_partida = $this->guia->ubigeo_partida;
        $this->direccion_llegada = $this->guia->direccion_llegada;
        $this->ubigeo_llegada = $this->guia->ubigeo_llegada;
        $this->factura_id = $this->guia->factura_id;
        $this->users_id = $this->guia->users_id;

        if ($this->guia->dispositivos->count() > 0) {
            $this->asignarTecnico = true;
            $this->dispatchBrowserEvent('asignar-tecnico');
        }

        $this->items = collect($this->guia->detalles);
        $this->selected = collect([
            'producto_id' => "",
            'codigo' => "",
            'cantidad' => 1,
            'unidad_medida' => "",
            'descripcion' => "",
        ]);

        $this->imeis_add = $this->guia->dispositivos->pluck('imei')->toArray();
        $this->imei_list = Dispositivos::stock()->pluck('imei')->toArray();


        $this->sim_add = $this->guia->sim_cards->pluck('sim_card')->toArray();
        $this->sim_list = SimCard::pluck('sim_card')->toArray();
    }


    public function render()
    {
        $motivos = MotivosTraslado::pluck('descripcion', 'codigo');
        return view('livewire.admin.guias-remision.edit', compact('motivos'));
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

            $this->selected = collect();
            $this->dispatchBrowserEvent('add-producto');
        } catch (\Exception $e) {
            throw $e;
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
    public function handleOnSortOrderChanged($sortOrder, $previousSortOrder, $name, $from, $to)
    {

        $this->$name = $sortOrder;

        $this->events = collect($this->events)
            ->push("{$name}. Dragged from $from to $to. Previous:" . collect($previousSortOrder)->join(','))
            ->toArray();
    }

    public function handleOnSortOrderChangedSim($sortOrder, $previousSortOrder, $name, $from, $to)
    {

        // dd($from, $to);
        // if (($key = array_search($this->$name, $this->lista_imei2)) !== false) {
        //     unset($arr[$key]);
        // }

        $this->$name = $sortOrder;

        $this->events = collect($this->events)
            ->push("{$name}. Dragged from $from to $to. Previous:" . collect($previousSortOrder)->join(','))
            ->toArray();
    }
    public function searchCliente()
    {
        try {
            $cliente = Clientes::where('numero_documento', '=', $this->numero_documento)->firstOrFail();
            $this->razon_social = $cliente->razon_social;
            $this->numero_documento = $cliente->numero_documento;
            //  $this->error_msg->reset();
        } catch (Exception $e) {

            $this->error_msg = $e->getMessage();
            report($e);
            return false;
        }
    }

    public function updatedNumeroDocumento()
    {
        if ($this->error_msg) {
            $this->reset('error_msg');
        }
    }

    public function updatedAsignarTecnico($value)
    {

        if ($value) {
            $this->dispatchBrowserEvent('asignar-tecnico');
        }
    }
    public function updated($name, $value)
    {
        $request = new GuiaRemisionRequest();
        $error = $this->validateOnly($name, $request->rules($this->guia), $request->messages());
    }
    public function updatedUsersId($value)
    {
    }

    public function update()
    {

        $request = new GuiaRemisionRequest();
        $data = $this->validate($request->rules($this->guia), $request->messages());

        $guia = $this->guia->update($data);

        $this->guia->detalles()->delete();

        GuiaRemision::createItems($this->guia, $data["items"]);

        //$this->guia->dispositivos()->delete();

        if ($this->asignarTecnico) {



            if (count($data["imeis_add"]) > 0) {

                $respuesta = Dispositivos::updateAsignarDispositivos(User::find($this->users_id), $data["imeis_add"], $this->guia);
            }

            if (count($data["sim_add"]) > 0) {

                $respuesta = SimCard::updateAsignarSimCard(User::find($this->users_id), $data["sim_add"], $this->guia);
            }
        }

        return redirect()->route('admin.almacen.guias.index')->with('update', 'La guia se registro con exito');
    }
}
