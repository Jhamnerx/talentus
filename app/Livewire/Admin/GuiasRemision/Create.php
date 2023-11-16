<?php

namespace App\Livewire\Admin\GuiasRemision;

use App\Http\Controllers\Admin\Almacen\GuiaRemisionController;
use App\Http\Requests\GuiaRemisionRequest;
use App\Models\Clientes;
use App\Models\Dispositivos;
use App\Models\GuiaRemision;
use App\Models\ModelosDispositivo;
use App\Models\MotivosTraslado;
use App\Models\Productos;
use App\Models\SimCard;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Livewire\Component;
use PhpParser\Node\Stmt\TryCatch;

class Create extends Component
{
    public $imei_list = [];
    public $imeis_add = [];

    public $sim_list = [];
    public $sim_add = [];

    public $events = [];

    public $error_msg;

    public $serie_numero, $fecha_emision;
    public $tipo_documento = "RUC", $numero_documento, $razon_social;
    public $motivo_traslado = "01", $modalidad_traslado = "02", $fecha_inicio_traslado, $peso, $cantidad_items, $numero_contenedor, $code_puerto;
    public $direccion_partida, $ubigeo_partida, $direccion_llegada, $ubigeo_llegada;
    public $factura_id, $asignarTecnico = false;
    public $users_id;
    public Collection $items;

    public Collection $selected;


    public $search;

    public function mount()
    {
        $controller = new GuiaRemisionController();
        $this->serie_numero = $controller->setNextSequenceNumber();
        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        $this->fecha_inicio_traslado = Carbon::now()->format('Y-m-d');
        $this->imei_list = Dispositivos::stock()->pluck('imei')->toArray();
        $this->sim_list = SimCard::pluck('sim_card')->toArray();

        $this->items = collect();
        $this->selected = collect([
            'producto_id' => "",
            'codigo' => "",
            'cantidad' => 1,
            'unidad_medida' => "",
            'descripcion' => "",
        ]);
    }

    public function updatedSearch($value)
    {
        // $this->imei_list = $this->lista_imei2;
        // $result = array_filter($this->imei_list, function ($item) use ($value) {
        //     if (stripos($item, $value) !== false) {
        //         return true;
        //     }
        //     return false;
        // });

        // $this->render();

        // $this->imei_list = $result;

        //dd($this->imei_list, $result);

        // dd(array_search($value, $this->imei_list));
    }

    public function render()
    {
        $motivos = MotivosTraslado::pluck('descripcion', 'codigo');
        return view('livewire.admin.guias-remision.create', compact('motivos'));
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
            $this->dispatch('add-producto');
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

        // if (($key = array_search($this->$name, $this->lista_imei2)) !== false) {
        //     unset($arr[$key]);
        // }

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
            $this->dispatch('asignar-tecnico');
        }
    }
    public function updated($name, $value)
    {
        $request = new GuiaRemisionRequest();
        $error = $this->validateOnly($name, $request->rules(), $request->messages());
    }
    public function updatedUsersId($value)
    {
    }

    public function save()
    {

        $request = new GuiaRemisionRequest();
        $data = $this->validate($request->rules(), $request->messages());

        $guia = GuiaRemision::create($data);

        //dd($data["sim_add"], $data["imeis_add"]);

        GuiaRemision::createItems($guia, $data["items"]);

        if ($this->asignarTecnico) {

            if (count($data["imeis_add"]) > 0) {

                $respuesta = Dispositivos::asignarDispositivos(User::find($this->users_id), $data["imeis_add"], $guia);
            }

            if (count($data["sim_add"]) > 0) {

                $respuesta = SimCard::asignarSimCard(User::find($this->users_id), $data["sim_add"], $guia);
            }
        }

        return redirect()->route('admin.almacen.guias.index')->with('store', 'La guia se registro con exito');
    }
}