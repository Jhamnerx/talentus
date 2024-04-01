<?php

namespace App\Livewire\Admin\Facturacion\Ventas;

use Carbon\Carbon;
use App\Models\Series;
use App\Models\Ventas;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\EnvioResumen;
use App\Models\TipoComprobantes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;

class AnularComprobante extends Component
{

    public Model $invoice;
    public $openModal = false;

    public $serie_ref, $correlativo_ref, $serie, $correlativo, $tipo_comprobante, $motivo = 'ERROR EN COMPROBANTE';
    //DE LA ANULACION
    public $tipo_comprobante_id = null;

    public $fecha_generacion = null;
    protected function rules()
    {
        return [
            'tipo_comprobante_id' => 'required',
            'serie_ref' => 'required',
            'correlativo_ref' => 'required',
            'tipo_comprobante' => 'required',
            'motivo' => 'required|min:3',
            'fecha_generacion' => 'date',

            'serie' => 'required',
            'correlativo' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'serie_ref.required' => 'El campo serie es obligatorio',
            'correlativo_ref.required' => 'El campo correlativo es obligatorio',
            'motivo.required' => 'El campo motivo es obligatorio',
            'motivo.min' => 'El campo motivo debe tener al menos 3 caracteres',
            'tipo_comprobante.required' => 'El campo tipo de comprobante es obligatorio',
        ];
    }
    public function mount()
    {
        $this->tipo_comprobante_id = TipoComprobantes::where('slug', 'resumen-anulaciones')->first()->codigo;
        $this->setSerieMount();
        $this->fecha_generacion = Carbon::now();
    }

    public function setSerieMount()
    {
        $serie = Series::where('tipo_comprobante_id', $this->tipo_comprobante_id)->first();
        $this->serie = $serie->serie;
        $this->correlativo = $serie->correlativo + 1;
    }

    public function render()
    {
        return view('livewire.admin.facturacion.ventas.anular-comprobante');
    }

    #[On('open-modal-anular')]
    public function openModalInvoice(Ventas $invoice)
    {
        $this->invoice = $invoice;
        $this->openModal = true;
        $this->serie_ref = $invoice->serie;
        $this->correlativo_ref = $invoice->correlativo;
        $this->tipo_comprobante = $invoice->tipo_comprobante_id;
    }

    public function anularComprobante()
    {

        $datos = $this->validate();

        try {
            //CREAR EL RESUMEN DE ANULACION
            $resumen = EnvioResumen::create([
                'resumen' => 0,
                'baja' => 3,
                'correlativo' => $datos['correlativo'],
                'fecha_generacion' => $datos['fecha_generacion'],

            ]);

            $api = new ApiFacturacion();
            $mensaje =  $api->anularComprobante($datos, $resumen);

            if ($mensaje['fe_codigo_error']) {

                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'ERROR: ',
                    mensaje: $mensaje["fe_mensaje_error"] . ', Intenta enviar luego',
                );

                $this->resetProps();
            } else {

                $this->invoice->update([
                    'anulado' => 'si',
                    'id_baja' => $resumen->id
                ]);

                $this->dispatch(
                    'notify-toast',
                    icon: 'success',
                    title: 'RESUMEN DE ANULACION ENVIADO A SUNAT',
                    mensaje: $mensaje['fe_mensaje_sunat'],
                );

                $this->resetProps();
            }
        } catch (\Throwable $th) {
            $this->dispatch(
                'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }



        $resumen->ventas;
    }

    public function closeModal()
    {
        $this->openModal = false;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetProps()
    {
        $this->reset();
        $this->mount();
    }
}
