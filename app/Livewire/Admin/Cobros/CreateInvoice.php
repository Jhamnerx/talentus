<?php

namespace App\Livewire\Admin\Cobros;

use Carbon\Carbon;
use App\Models\Cobros;
use Livewire\Component;
use App\Models\Productos;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;
use App\Http\Controllers\Admin\UtilesController;

class CreateInvoice extends Component
{
    public $modalInvoice = false;
    public $cobro;

    //PROPIEDADES DE VENTA
    public $tipo_comprobante_id,  $cliente_id, $fecha_emision, $fecha_vencimiento,
        $divisa = "PEN", $tipo_cambio, $metodo_pago_id = "009",
        $igv_op = 0.00, $adelanto = 0.00,  $numero_cuotas = 0,
        $vence_cuotas = 30, $forma_pago = "CONTADO";

    public $sub_total = 0.00, $op_gravadas = 0.00, $total;

    public Collection $items;
    public Collection $detalle_cuotas;

    public $showCredit = false;
    public $total_cuotas = 0.00;

    public $simbolo = "S/. ";

    public $metodo_type = "02";


    public function mount()
    {
        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        $this->fecha_vencimiento = Carbon::now()->format('Y-m-d');

        $this->items = collect();
        $this->detalle_cuotas = collect();

        //  CONSULTAR TIPO CAMBIO
        $util = new UtilesController;
        $this->tipo_cambio = $util->tipoCambio();
    }

    public function render()
    {
        return view('livewire.admin.cobros.create-invoice');
    }

    #[On('open-modal-create-invoice')]
    public function openModal(Cobros $cobro)
    {

        $this->modalInvoice = true;
        $this->cobro = $cobro;
        $this->cliente_id = $cobro->cliente_id;
        $this->tipo_comprobante_id = $cobro->tipo_pago == 'FACTURA' ? "01" : "10";
    }

    public function updatedDivisa($value)
    {
        if ($value == "USD") {
            $this->simbolo = "$";
        } else {
            $this->simbolo = "S/. ";
        }
    }

    public function updatedFormaPago()
    {
        $this->toggleShowCredit();
    }


    public function toggleShowCredit()
    {

        if ($this->forma_pago == "CREDITO") {

            $this->showCredit = true;
            $this->resetCrediFields();
        } else {
            $this->showCredit = false;
        }
    }

    public function resetCrediFields()
    {
        $this->numero_cuotas = 0;
        $this->detalle_cuotas = collect();
    }

    public function updatedNumeroCuotas($value)
    {

        $this->calcularCuotas($value);
    }

    public function updatedVenceCuotas($value)
    {
        $this->calcularCuotas($this->numero_cuotas);
    }

    public function calcularCuotas($nCuotas)
    {
        $this->detalle_cuotas = collect();
        $fecha = Carbon::now();
        //$this->total_cuotas = 0.00;
        for ($i = 0; $i < (int)$nCuotas; $i++) {

            $this->detalle_cuotas->push([
                'n_cuota' => $i + 1,
                'dias' => $this->vence_cuotas,
                'fecha' => $fecha->addDays($this->vence_cuotas)->format('Y-m-d'),
                'dia_semana' => ucfirst($fecha->dayName),
                'importe' => $this->total > 0 ? round(floatval(($this->detraccion ? ($this->total - ($this->datosDetraccion['monto'] / $this->tipo_cambio)) : $this->total) / $nCuotas), 2)  : 0.00,
            ]);
        }
        $this->total_cuotas = round($this->detalle_cuotas->sum('importe'), 4);
    }

    public function updatedDetalleCuotas($attr, $valor)
    {

        $this->detalle_cuotas = $this->detalle_cuotas->map(function ($item, $key) use ($attr, $valor) {

            // $item['fecha'] = $valor['fecha'];
            $item['dia_semana'] = ucfirst(Carbon::parse($item['fecha'])->dayName);
            $item['dias'] = Carbon::parse($item['fecha'])->diffInDays(Carbon::now());
            return $item;
        });

        $this->validate(['detalle_cuotas.*.fecha' => 'required|date|after_or_equal:fecha_emision'], [
            'detalle_cuotas.*.fecha.after_or_equal' => 'La fecha de vencimiento de la cuota debe ser mayor o igual a la fecha de emisión',
        ]);
        $this->total_cuotas = round($this->detalle_cuotas->sum('importe'), 4);
    }

    public function calcularIgvProducto(Productos $producto): float
    {
        switch ($producto->tipoAfectacion->codigo_afectacion) {
            case "1000":

                $igv = round(floatval($producto->valor_unitario), 4) *  $this->plantilla->igv;

                return floatval($igv);
            default:
                $igv = 0;

                return floatval($igv);
        }
    }
}
