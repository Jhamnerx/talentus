<?php

namespace App\Livewire\Admin\GuiasRemision;

use App\Models\Guias;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\GuiaRemision;
use App\Models\MotivoTraslado;
use Livewire\WithPagination;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $filterModalidad      = '';
    public $filterEstado         = '';
    public $filterFechaDesde     = '';
    public $filterFechaHasta     = '';
    public $filterMotivoTraslado = '';
    public $filterConductor      = '';
    public $filterVehiculo       = '';
    public bool $showFilters = false;

    protected $listeners = [
        'updateTable' => 'render',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingFilterModalidad(): void
    {
        $this->resetPage();
    }
    public function updatingFilterEstado(): void
    {
        $this->resetPage();
    }
    public function updatingFilterFechaDesde(): void
    {
        $this->resetPage();
    }
    public function updatingFilterFechaHasta(): void
    {
        $this->resetPage();
    }
    public function updatingFilterMotivoTraslado(): void
    {
        $this->resetPage();
    }
    public function updatingFilterConductor(): void
    {
        $this->resetPage();
    }
    public function updatingFilterVehiculo(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'filterModalidad', 'filterEstado', 'filterFechaDesde', 'filterFechaHasta', 'filterMotivoTraslado', 'filterConductor', 'filterVehiculo']);
        $this->resetPage();
    }

    public function render()
    {
        $query = GuiaRemision::query()
            ->where(function ($q) {
                $q->whereHas('motivoTraslado', fn($s) => $s->where('descripcion', 'like', '%' . $this->search . '%'))
                    ->orWhereHas('cliente', fn($s) => $s->where('razon_social', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_documento', 'like', '%' . $this->search . '%'))
                    ->orWhere('serie_correlativo', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
                    ->orWhere('transp_placa', 'like', '%' . $this->search . '%')
                    ->orWhere('chofer_nombre', 'like', '%' . $this->search . '%');
            });

        if ($this->filterModalidad !== '') {
            $query->where('modalidad_transporte_id', $this->filterModalidad);
        }
        if ($this->filterEstado !== '') {
            $query->where('fe_estado', $this->filterEstado);
        }
        if ($this->filterFechaDesde !== '') {
            $query->whereDate('fecha_emision', '>=', $this->filterFechaDesde);
        }
        if ($this->filterFechaHasta !== '') {
            $query->whereDate('fecha_emision', '<=', $this->filterFechaHasta);
        }
        if ($this->filterMotivoTraslado !== '') {
            $query->where('motivo_traslado_id', $this->filterMotivoTraslado);
        }
        if ($this->filterConductor !== '') {
            $query->where(function ($q) {
                $q->where('chofer_nombre', 'like', '%' . $this->filterConductor . '%')
                    ->orWhere('chofer_apellidos', 'like', '%' . $this->filterConductor . '%');
            });
        }
        if ($this->filterVehiculo !== '') {
            $query->where('transp_placa', 'like', '%' . $this->filterVehiculo . '%');
        }

        $guias = $query->orderBy('id', 'DESC')->paginate(15);
        $motivosTraslado = MotivoTraslado::orderBy('descripcion')->get();

        return view('livewire.admin.guias-remision.index', compact('guias', 'motivosTraslado'));
    }


    public function openDetallePanel(GuiaRemision $guia)
    {
        $this->dispatch('open-detalle-panel', $guia);
    }


    public function openModalDelete(GuiaRemision $guia)
    {
        $this->dispatch('EliminarGuia', $guia);
    }

    public function getCdr(GuiaRemision $guia)
    {
        try {
            $api = new ApiFacturacion();
            $mensaje =  $api->sendInvoiceOnlyGuia($guia);

            if ($mensaje['fe_codigo_error']) {

                $this->afterGetCdr($mensaje['fe_mensaje_error'], 'ERROR AL ENVIAR GUIA', 'error');
            } else {

                $this->afterGetCdr($mensaje['fe_mensaje_sunat'], 'GUIA ENVIADO A SUNAT', 'success');
            }
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }


    public function createXml(GuiaRemision $guia)
    {
        try {
            $api = new ApiFacturacion();
            $mensaje =  $api->updateClaseGuia($guia);

            if ($mensaje['fe_codigo_error']) {

                $this->afterGetCdr($mensaje['fe_mensaje_error'], 'ERROR AL ENVIAR COMPROBANTE', 'error');
            } else {

                $this->afterGetCdr($mensaje['fe_mensaje_sunat'], 'COMPROBANTE ENVIADO A SUNAT', 'success');
            }
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function consultaTicket(GuiaRemision $guia)
    {

        try {
            $api = new ApiFacturacion();
            $mensaje =  $api->consultaTicket($guia);

            if ($mensaje['fe_codigo_error']) {

                $this->afterGetCdr($mensaje['fe_mensaje_error'], 'ERROR AL ENVIAR GUIA', 'error');
            } else {

                $this->afterGetCdr($mensaje['fe_mensaje_sunat'], 'GUIA ENVIADO A SUNAT', 'success');
            }
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function afterGetCdr($mensaje, $titulo, $icono)
    {
        $this->dispatch(
            'notify',
            icon: $icono,
            title: $titulo,
            mensaje: $mensaje,
        );
        $this->render();
    }
}
