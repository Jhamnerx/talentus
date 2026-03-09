<?php

namespace App\Livewire\Admin\WorkOrders;

use Livewire\Component;
use App\Models\WorkOrder;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use App\Enums\ChecklistResultado;
use App\Models\ChecklistTemplate;
use App\Models\WorkOrderChecklist;
use Illuminate\Support\Facades\Auth;

class Checklist extends Component
{
    use WithFileUploads, WireUiActions;

    public WorkOrder $workOrder;
    public string $fase = 'before'; // before o after
    public array $checklist = [];
    public array $observaciones = [];
    public array $resultados = [];
    public array $fotos = [];

    public int $totalItems = 0;
    public int $completados = 0;
    public ?int $fotoTemplateId = null;

    public function mount(WorkOrder $workOrder, string $fase = 'before'): void
    {
        $this->workOrder = $workOrder;
        $this->fase = $fase;
        $this->loadChecklist();
    }

    public function loadChecklist(): void
    {
        $templates = ChecklistTemplate::where('empresa_id', $this->workOrder->empresa_id)
            ->where('is_active', true)
            ->orderBy('orden')
            ->get();

        $this->totalItems = $templates->count();

        foreach ($templates as $template) {
            // Buscar si ya existe un registro de checklist
            $existing = WorkOrderChecklist::where('work_order_id', $this->workOrder->id)
                ->where('checklist_template_id', $template->id)
                ->where('fase', $this->fase)
                ->first();

            $this->checklist[$template->id] = [
                'id' => $template->id,
                'nombre' => $template->nombre,
                'descripcion' => $template->descripcion,
                'categoria' => $template->categoria->value,
            ];

            if ($existing) {
                $this->resultados[$template->id] = $existing->resultado->value;
                $this->observaciones[$template->id] = $existing->observaciones;
                $this->completados++;
            }
        }
    }

    public function seleccionarResultado(int $templateId, string $valor): void
    {
        $this->resultados[$templateId] = $valor;
        $this->guardarItem($templateId);
    }

    public function updatedResultados($value, $templateId): void
    {
        // Mantenido como fallback; la acción principal se ejecuta vía seleccionarResultado
    }

    public function guardarItem(int $templateId): void
    {
        if (!isset($this->resultados[$templateId])) {
            return;
        }

        WorkOrderChecklist::updateOrCreate(
            [
                'work_order_id' => $this->workOrder->id,
                'checklist_template_id' => $templateId,
                'fase' => $this->fase,
            ],
            [
                'resultado' => ChecklistResultado::from($this->resultados[$templateId]),
                'observaciones' => $this->observaciones[$templateId] ?? null,
                'empresa_id' => $this->workOrder->empresa_id,
            ]
        );

        $this->calcularProgreso();

        $this->notification([
            'title' => 'Guardado',
            'description' => 'Ítem actualizado automáticamente',
            'icon' => 'success',
        ]);

        $this->dispatch('checklist-updated', workOrderId: $this->workOrder->id);
    }

    public function abrirModalFoto(int $templateId): void
    {
        $this->fotoTemplateId = $templateId;
    }

    public function cerrarModalFoto(): void
    {
        $this->fotoTemplateId = null;
    }

    public function subirFoto(): void
    {
        if (!$this->fotoTemplateId) {
            return;
        }

        $this->validate([
            "fotos.{$this->fotoTemplateId}" => 'required|image|max:5120',
        ], [
            "fotos.{$this->fotoTemplateId}.required" => 'Selecciona una imagen',
            "fotos.{$this->fotoTemplateId}.image" => 'El archivo debe ser una imagen',
            "fotos.{$this->fotoTemplateId}.max" => 'La imagen no debe superar 5MB',
        ]);

        $foto = $this->fotos[$this->fotoTemplateId];
        $extension = $foto->getClientOriginalExtension();
        $nombreItem = Str::slug($this->checklist[$this->fotoTemplateId]['nombre']);
        $nuevoNombre = "{$this->workOrder->codigo}_{$this->fase}_{$nombreItem}_" . time() . ".{$extension}";

        $path = $foto->storeAs(
            'work-orders/' . $this->workOrder->id . '/checklist',
            $nuevoNombre,
            'private'
        );

        $this->workOrder->photos()->create([
            'filename' => $nuevoNombre,
            'path' => $path,
            'disk' => 'private',
            'mime_type' => $foto->getMimeType(),
            'size' => $foto->getSize(),
            'tipo' => 'checklist',
            'fase' => $this->fase,
            'descripcion' => $this->checklist[$this->fotoTemplateId]['nombre'] . ' - Fase: ' . strtoupper($this->fase),
            'latitude' => null,
            'longitude' => null,
            'uploaded_by' => Auth::user()->id,
        ]);

        $this->notification([
            'title' => 'Foto Guardada',
            'description' => 'Evidencia fotográfica guardada correctamente',
            'icon' => 'success',
        ]);

        unset($this->fotos[$this->fotoTemplateId]);
        $this->cerrarModalFoto();
    }

    public function calcularProgreso(): void
    {
        $this->completados = WorkOrderChecklist::where('work_order_id', $this->workOrder->id)
            ->where('fase', $this->fase)
            ->count();
    }

    public function finalizarChecklist(): void
    {

        if ($this->completados < $this->totalItems) {
            $this->notification([
                'title' => 'Checklist Incompleto',
                'description' => "Completado {$this->completados} de {$this->totalItems} ítems. Debes completar todos los ítems.",
                'icon' => 'error',
            ]);
            return;
        }

        $this->notification([
            'title' => 'Checklist Finalizado',
            'description' => "Checklist fase {$this->fase} completado exitosamente",
            'icon' => 'success',
        ]);

        $this->dispatch('checklist-finalizado', fase: $this->fase);
        $this->redirect(route('admin.work-orders.show', $this->workOrder));
    }

    public function render()
    {
        // Agrupar checklist por categoría
        $checklistPorCategoria = collect($this->checklist)->groupBy('categoria');

        return view('livewire.admin.work-orders.checklist', [
            'checklistPorCategoria' => $checklistPorCategoria,
            'progreso' => $this->totalItems > 0 ? round(($this->completados / $this->totalItems) * 100) : 0,
        ]);
    }
}
