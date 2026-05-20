<?php

namespace App\Livewire\Admin\SimCard;

use App\Services\M2MDataglobalService;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class M2MPanel extends Component
{
    use WireUiActions;

    // ── Estado general ───────────────────────────────────────────────────────
    public string $icc = '';

    // ── Modales ──────────────────────────────────────────────────────────────
    public bool $modalHub        = false;
    public bool $modalDetalles   = false;
    public bool $modalDiagnostico = false;
    public bool $modalEditar     = false;
    public bool $modalSms        = false;

    // ── Ver detalles ─────────────────────────────────────────────────────────
    public array  $detalles    = [];
    public string $tab         = 'identificacion';
    public bool   $cargandoDet = false;
    public string $errorDet    = '';

    // ── Diagnóstico ──────────────────────────────────────────────────────────
    public array $testGsm        = [];
    public array $testGprs       = [];
    public bool  $cargandoGsm    = false;
    public bool  $cargandoGprs   = false;

    // ── Editar campos personalizados ─────────────────────────────────────────
    public string $customField1   = '';
    public string $customField2   = '';
    public bool   $guardandoEditar = false;

    // ── Enviar SMS ───────────────────────────────────────────────────────────
    public string $smsTexto     = '';
    public bool   $enviandoSms  = false;

    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Abre el hub de opciones para una SIM card.
     * Llamado desde el index con doble click en la fila.
     * El evento Alpine dispatcha un string con el ICC directamente.
     */
    #[On('m2m-abrir-panel')]
    public function abrirPanel(string $icc): void
    {
        $this->reset([
            'tab',
            'detalles',
            'errorDet',
            'cargandoDet',
            'testGsm',
            'testGprs',
            'cargandoGsm',
            'cargandoGprs',
            'customField1',
            'customField2',
            'guardandoEditar',
            'smsTexto',
            'enviandoSms',
            'modalDetalles',
            'modalDiagnostico',
            'modalEditar',
            'modalSms',
        ]);
        $this->icc      = $icc;
        $this->modalHub = true;
    }

    // ── Hub → acciones ───────────────────────────────────────────────────────

    public function irDetalles(): void
    {
        $this->modalHub      = false;
        $this->tab           = 'identificacion';
        $this->detalles      = [];
        $this->errorDet      = '';
        $this->modalDetalles = true;
        $this->cargarDetalles();
    }

    public function irDiagnostico(): void
    {
        $this->modalHub       = false;
        $this->testGsm        = [];
        $this->testGprs       = [];
        $this->modalDiagnostico = true;
    }

    public function irEditar(): void
    {
        $this->modalHub    = false;
        $this->customField1 = $this->detalles['customField1'] ?? '';
        $this->customField2 = $this->detalles['customField2'] ?? '';
        $this->modalEditar = true;
        // Si aún no tenemos detalles los cargamos en background para pre-poblar
        if (empty($this->detalles)) {
            $this->cargarDetalles(silencioso: true);
        }
    }

    public function irSms(): void
    {
        $this->modalHub  = false;
        $this->smsTexto  = '';
        $this->modalSms  = true;
    }

    // ── Ver detalles ─────────────────────────────────────────────────────────

    public function cargarDetalles(bool $silencioso = false): void
    {
        if (! $silencioso) {
            $this->cargandoDet = true;
        }
        $this->errorDet = '';

        $servicio = app(M2MDataglobalService::class);
        $resp     = $servicio->simDetailsByIcc($this->icc);

        $this->cargandoDet = false;

        if (! $resp['status'] || empty($resp['data'])) {
            $this->errorDet = $resp['error'] ?? 'No se pudieron obtener los detalles.';
            $this->detalles = [];
            return;
        }

        $this->detalles = $resp['data'];

        // Pre-poblar campos de edición si el modal editar está abierto
        if ($this->modalEditar) {
            $this->customField1 = $this->detalles['customField1'] ?? '';
            $this->customField2 = $this->detalles['customField2'] ?? '';
        }
    }

    // ── Diagnóstico ──────────────────────────────────────────────────────────

    public function ejecutarTestGsm(): void
    {
        $this->cargandoGsm = true;
        $this->testGsm     = [];

        $servicio      = app(M2MDataglobalService::class);
        $this->testGsm = $servicio->testGsm(M2MDataglobalService::TIPO_ICC, $this->icc);

        $this->cargandoGsm = false;
    }

    public function ejecutarTestGprs(): void
    {
        $this->cargandoGprs = true;
        $this->testGprs     = [];

        $servicio       = app(M2MDataglobalService::class);
        $this->testGprs = $servicio->testGprs(M2MDataglobalService::TIPO_ICC, $this->icc);

        $this->cargandoGprs = false;
    }

    // ── Editar campos personalizados ─────────────────────────────────────────

    public function guardarEditar(): void
    {
        $this->validate([
            'customField1' => 'nullable|string|max:100',
            'customField2' => 'nullable|string|max:100',
        ]);

        $this->guardandoEditar = true;

        $servicio = app(M2MDataglobalService::class);
        $resp     = $servicio->updateCustomFields(
            M2MDataglobalService::TIPO_ICC,
            $this->icc,
            [
                'customField1' => $this->customField1,
                'customField2' => $this->customField2,
            ]
        );

        $this->guardandoEditar = false;

        if ($resp['status']) {
            $this->notification()->success('Guardado', 'Campos personalizados actualizados correctamente.');
            $this->modalEditar = false;
            $this->detalles    = []; // limpiar caché
        } else {
            $this->notification()->error('Error', $resp['error'] ?? 'No se pudo guardar.');
        }
    }

    // ── Enviar SMS ───────────────────────────────────────────────────────────

    public function enviarSms(): void
    {
        $this->validate([
            'smsTexto' => 'required|string|max:160',
        ], [
            'smsTexto.required' => 'El mensaje no puede estar vacío.',
            'smsTexto.max'      => 'El mensaje no puede superar 160 caracteres.',
        ]);

        $this->enviandoSms = true;

        $servicio = app(M2MDataglobalService::class);
        $resp     = $servicio->sendSms(M2MDataglobalService::TIPO_ICC, $this->icc, $this->smsTexto);

        $this->enviandoSms = false;

        if ($resp['status']) {
            $this->notification()->success('SMS enviado', 'El mensaje fue enviado correctamente.');
            $this->modalSms  = false;
            $this->smsTexto  = '';
        } else {
            $this->notification()->error('Error', $resp['error'] ?? 'No se pudo enviar el SMS.');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.admin.sim-card.m2m-panel');
    }
}
