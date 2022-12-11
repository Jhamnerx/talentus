<?php

namespace App\Http\Livewire\Admin\GuiasRemision;

use App\Http\Controllers\Admin\Almacen\GuiaRemisionController;
use App\Http\Requests\GuiaRemisionRequest;
use App\Models\Clientes;
use App\Models\Dispositivos;
use App\Models\GuiaRemision;
use App\Models\ModelosDispositivo;
use App\Models\MotivosTraslado;
use App\Models\Productos;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Livewire\Component;
use PhpParser\Node\Stmt\TryCatch;

class Create extends Component
{
    public $imei_list = [];
    public $lista_imei2 = [];
    public $imeis_add = [];
    public $events = [];

    public $error_msg;

    public $serie_numero, $fecha_emision;
    public $tipo_documento = "RUC", $numero_documento, $razon_social;
    public $motivo_traslado = "01", $modalidad_traslado = "02", $fecha_inicio_traslado, $peso, $cantidad_items, $numero_contenedor, $code_puerto;
    public $direccion_partida, $ubigeo_partida, $direccion_llegada, $ubigeo_llegada;
    public $factura_id, $asignarTecnico = false;
    public $user;
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
        $this->lista_imei2 = Dispositivos::stock()->pluck('imei')->toArray();

        $this->items = collect();
        $this->detalle_cuotas = collect();
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
        //$this->imei_list = Dispositivos::where('razon_social', 'like', '%' . $this->search . '%')->stock()->pluck('imei')->toArray();
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

            //$this->calcularTotalSoles();
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
        // unset($this->lista_imei2[$this->$name]);

        if (($key = array_search($this->$name, $this->lista_imei2)) !== false) {
            unset($arr[$key]);
        }

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
        $error = $this->validateOnly($name, $request->rules(), $request->messages());
    }
    public function updatedUser($value)
    {
        $this->user = User::find($value);
    }

    public function save()
    {

        $request = new GuiaRemisionRequest();
        $data = $this->validate($request->rules(), $request->messages());

        $guia = GuiaRemision::create($data);

        GuiaRemision::createItems($guia, $data["items"]);

        if ($this->asignarTecnico) {

            $respuesta = Dispositivos::asignarDispositivos($this->user, $data["imeis_add"], $guia);
        }

        //return redirect()->route('admin.almacen.guias.index')->with('store', 'La guia se registro con exito');
    }
}
