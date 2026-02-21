<?php

namespace App\Livewire\Admin\Dispositivos;

use App\Http\Controllers\Admin\FotaWebApiController;
use App\Models\Dispositivos;
use App\Models\ModelosDispositivo;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class DispositivosIndex extends Component
{
    use WithPagination, WireUiActions;
    #[Url(except: '')]
    public $search = '';

    // Propiedades para dispositivos no registrados
    public $showModalNoRegistrados = false;
    public $dispositivosNoRegistrados = [];
    public $totalFotaWeb = 0;
    public $totalLocal = 0;
    public $cargandoFotaWeb = false;

    // Propiedades para selección y guardado masivo
    public $modeloSeleccionado = null;
    public $dispositivosSeleccionados = [];
    public $seleccionarTodos = false;

    protected $listeners = ['render' => 'render'];

    public function render()
    {

        $dispositivos = Dispositivos::whereHas('modelo', function ($query) {
            $query->where('marca', 'like', '%' . $this->search . '%')
                ->orWhere('modelo', 'like', '%' . $this->search . '%');
        })->orwhereHas('vehiculos', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%');
        })->orwhereHas('user', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->orWhere('imei', 'like', '%' . $this->search . '%')
            ->orWhere('estado', 'like', $this->search === "Equipo Disponible" ? '%STOCK%' : '%' . $this->search . '%')
            ->orWhere('in_fota', 'like', $this->search === "no fota" ? false : '%' . $this->search . '%')
            ->orwhereDate('created_at', $this->validateDate($this->search) ? Carbon::createFromFormat('d-m-Y', $this->search)->format('Y-m-d') : '')
            ->with('vehiculos', 'modelo')
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('livewire.admin.dispositivos.dispositivos-index', compact('dispositivos'));
    }

    #[On('update-table')]
    public function updateTable()
    {
        $this->render();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


    public function verInfoDispositivo(Dispositivos $dispositivo)
    {

        $this->dispatch('show-info-dispositivo', $dispositivo);
    }


    /**
     * Consultar y sincronizar dispositivos con Fota Web
     * Consulta dispositivos TELTONIKA no consultados previamente
     */
    public function consultaFota()
    {
        try {
            // Obtener dispositivos TELTONIKA no consultados
            $dispositivos = Dispositivos::where('consultado', false)
                ->whereHas('modelo', function ($query) {
                    $query->where('marca', 'TELTONIKA');
                })
                ->limit(100) // Limitar a 100 por consulta para no saturar
                ->get();

            if ($dispositivos->isEmpty()) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'info',
                    title: 'Sin dispositivos por consultar',
                    mensaje: 'No hay dispositivos TELTONIKA pendientes de consultar en Fota Web'
                );
                return;
            }

            $api = new FotaWebApiController();

            // Obtener todos los IMEIs para consulta en lote
            $imeis = $dispositivos->pluck('imei')->toArray();

            // Sincronizar con Fota Web
            $result = $api->syncDevices($imeis);

            // Actualizar dispositivos encontrados
            if (!empty($result['devices'])) {
                $fotaImeis = collect($result['devices'])->pluck('imei')->toArray();

                // Actualizar dispositivos encontrados en Fota
                Dispositivos::whereIn('imei', $fotaImeis)
                    ->update([
                        'in_fota' => true,
                        'consultado' => true
                    ]);

                // Marcar como consultado los no encontrados también
                $notFoundImeis = array_diff($imeis, $fotaImeis);
                if (!empty($notFoundImeis)) {
                    Dispositivos::whereIn('imei', $notFoundImeis)
                        ->update(['consultado' => true]);
                }
            } else {
                // Si no se encontró ninguno, marcar todos como consultados
                Dispositivos::whereIn('imei', $imeis)
                    ->update(['consultado' => true]);
            }

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'Consulta a Fota Web completada',
                mensaje: "Total: {$result['total']} | Encontrados: {$result['found']} | No encontrados: {$result['not_found']}"
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'Error en consulta Fota Web',
                mensaje: 'Ocurrió un error: ' . $e->getMessage()
            );
        }

        $this->render();
    }

    /**
     * Consultar dispositivos en Fota Web que no están registrados localmente
     */
    public function consultarDispositivosNoRegistrados()
    {
        try {
            $this->cargandoFotaWeb = true;
            $this->dispositivosNoRegistrados = [];

            $api = new FotaWebApiController();

            // Obtener todos los IMEIs locales de TELTONIKA
            $imeisLocales = Dispositivos::whereHas('modelo', function ($query) {
                $query->where('marca', 'TELTONIKA');
            })->pluck('imei')->toArray();

            $this->totalLocal = count($imeisLocales);

            // Consultar Fota Web con paginación
            $dispositivosNoRegistrados = [];
            $page = 1;
            $perPage = 100;
            $hasMorePages = true;

            while ($hasMorePages) {
                $response = $api->getDevices([
                    'page' => $page,
                    'per_page' => $perPage,
                    'sort' => 'imei',
                    'order' => 'asc'
                ]);

                if ($response && isset($response->data)) {
                    $this->totalFotaWeb = $response->total ?? 0;

                    foreach ($response->data as $device) {
                        // Si el IMEI no está en nuestro sistema, agregarlo a la lista
                        if (!in_array($device->imei, $imeisLocales)) {
                            $dispositivosNoRegistrados[] = [
                                'imei' => $device->imei,
                                'serial' => $device->serial ?? 'N/A',
                                'modelo' => $device->model ?? 'N/A',
                                'descripcion' => $device->description ?? '',
                                'company_name' => $device->company_name ?? 'N/A',
                                'seen_at' => $device->seen_at ?? null,
                                'created_at' => $device->created_at ?? null,
                                'current_firmware' => $device->current_firmware ?? 'N/A',
                                'activity_status' => $device->activity_status ?? 'N/A'
                            ];
                        }
                    }

                    // Verificar si hay más páginas
                    $hasMorePages = $page < ($response->last_page ?? 1);
                    $page++;

                    // Limitar a 500 dispositivos para no saturar la memoria
                    if (count($dispositivosNoRegistrados) >= 500) {
                        break;
                    }
                } else {
                    $hasMorePages = false;
                }
            }

            $this->dispositivosNoRegistrados = $dispositivosNoRegistrados;
            $this->cargandoFotaWeb = false;
            $this->showModalNoRegistrados = true;

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'Consulta completada',
                mensaje: 'Se encontraron ' . count($dispositivosNoRegistrados) . ' dispositivos no registrados en Fota Web'
            );
        } catch (\Exception $e) {
            $this->cargandoFotaWeb = false;
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'Error al consultar Fota Web',
                mensaje: 'Error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Cerrar modal de dispositivos no registrados
     */
    public function cerrarModalNoRegistrados()
    {
        $this->showModalNoRegistrados = false;
        $this->dispositivosNoRegistrados = [];
        $this->dispositivosSeleccionados = [];
        $this->modeloSeleccionado = null;
        $this->seleccionarTodos = false;
    }

    /**
     * Obtener modelos TELTONIKA disponibles
     */
    public function getModelosTeltonikaProperty()
    {
        return ModelosDispositivo::where('marca', 'TELTONIKA')
            ->orderBy('modelo')
            ->get();
    }

    /**
     * Toggle selección de todos los dispositivos
     */
    public function toggleSeleccionarTodos()
    {
        if ($this->seleccionarTodos) {
            $this->dispositivosSeleccionados = collect($this->dispositivosNoRegistrados)
                ->pluck('imei')
                ->toArray();
        } else {
            $this->dispositivosSeleccionados = [];
        }
    }

    /**
     * Seleccionar todos los dispositivos de un modelo específico
     */
    public function seleccionarPorModelo($modeloFota)
    {
        $imeisDelModelo = collect($this->dispositivosNoRegistrados)
            ->where('modelo', $modeloFota)
            ->pluck('imei')
            ->toArray();

        // Toggle: si todos están seleccionados, deseleccionar; si no, seleccionar
        $todosSeleccionados = !array_diff($imeisDelModelo, $this->dispositivosSeleccionados);

        if ($todosSeleccionados) {
            // Deseleccionar todos de este modelo
            $this->dispositivosSeleccionados = array_diff($this->dispositivosSeleccionados, $imeisDelModelo);
        } else {
            // Seleccionar todos de este modelo
            $this->dispositivosSeleccionados = array_unique(
                array_merge($this->dispositivosSeleccionados, $imeisDelModelo)
            );
        }

        // Actualizar checkbox "seleccionar todos"
        $this->seleccionarTodos = count($this->dispositivosSeleccionados) === count($this->dispositivosNoRegistrados);
    }

    /**
     * Obtener modelos únicos con contadores
     */
    public function getModelosFotaProperty()
    {
        return collect($this->dispositivosNoRegistrados)
            ->groupBy('modelo')
            ->map(fn($items) => [
                'modelo' => $items->first()['modelo'],
                'count' => $items->count(),
                'imeis' => $items->pluck('imei')->toArray(),
            ])
            ->sortByDesc('count')
            ->values();
    }

    /**
     * Guardar dispositivos seleccionados en el sistema
     */
    public function guardarDispositivosSeleccionados()
    {
        // Validar que se haya seleccionado un modelo
        if (!$this->modeloSeleccionado) {
            $this->notification()->error(
                'Modelo requerido',
                'Debes seleccionar un modelo de dispositivo'
            );
            return;
        }

        // Validar que haya dispositivos seleccionados
        if (empty($this->dispositivosSeleccionados)) {
            $this->notification()->error(
                'Sin dispositivos',
                'Debes seleccionar al menos un dispositivo para guardar'
            );
            return;
        }

        try {
            // Verificar cuáles ya existen
            $imeisExistentes = Dispositivos::whereIn('imei', $this->dispositivosSeleccionados)
                ->pluck('imei')
                ->toArray();

            // Filtrar solo los nuevos
            $imeisNuevos = array_diff($this->dispositivosSeleccionados, $imeisExistentes);

            if (empty($imeisNuevos)) {
                $this->notification()->warning(
                    'Sin cambios',
                    'Todos los dispositivos seleccionados ya están registrados'
                );
                return;
            }

            $guardados = 0;

            // Usar transacción para velocidad + observers activos
            DB::transaction(function () use ($imeisNuevos, &$guardados) {
                foreach ($imeisNuevos as $imei) {
                    $dispositivoData = collect($this->dispositivosNoRegistrados)
                        ->firstWhere('imei', $imei);

                    if ($dispositivoData) {
                        // create() dispara el observer que asigna empresa_id y user_id
                        Dispositivos::create([
                            'imei' => $imei,
                            'modelo_id' => $this->modeloSeleccionado,
                            'estado' => Dispositivos::STOCK,
                            'in_fota' => true,
                            'consultado' => true,
                            'of_client' => Dispositivos::IS_EMPRESA,
                            'observaciones' => 'Importado desde Fota Web: ' . ($dispositivoData['descripcion'] ?? 'Sin descripción'),
                        ]);
                        $guardados++;
                    }
                }
            });
            $errores = count($imeisExistentes);

            // Remover dispositivos guardados del array sin reconsultar API
            $this->dispositivosNoRegistrados = collect($this->dispositivosNoRegistrados)
                ->reject(fn($d) => in_array($d['imei'], $imeisNuevos))
                ->values()
                ->toArray();

            $this->notification()->success(
                'Dispositivos guardados',
                "Se guardaron {$guardados} dispositivo(s) exitosamente" . ($errores > 0 ? ". {$errores} ya existían." : "")
            );

            // Limpiar selección
            $this->dispositivosSeleccionados = [];
            $this->seleccionarTodos = false;
            $this->modeloSeleccionado = null;

            // Actualizar tabla principal
            $this->dispatch('update-table');
        } catch (\Exception $e) {
            $this->notification()->error(
                'Error al guardar',
                'Ocurrió un error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Exportar dispositivos no registrados a CSV
     */
    public function exportarNoRegistrados()
    {
        if (empty($this->dispositivosNoRegistrados)) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'Sin datos',
                mensaje: 'No hay dispositivos para exportar'
            );
            return;
        }

        $filename = 'dispositivos_no_registrados_' . date('Y-m-d_His') . '.csv';
        $filepath = storage_path('app/public/' . $filename);

        $file = fopen($filepath, 'w');

        // Encabezados con BOM para Excel
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Encabezados
        fputcsv($file, ['IMEI', 'Serial', 'Modelo', 'Descripción', 'Compañía', 'Última Conexión', 'Firmware', 'Estado']);

        // Datos
        foreach ($this->dispositivosNoRegistrados as $dispositivo) {
            fputcsv($file, [
                $dispositivo['imei'],
                $dispositivo['serial'],
                $dispositivo['modelo'],
                $dispositivo['descripcion'],
                $dispositivo['company_name'],
                $dispositivo['seen_at'],
                $dispositivo['current_firmware'],
                $dispositivo['activity_status']
            ]);
        }

        fclose($file);

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'Exportado',
            mensaje: 'Archivo CSV generado exitosamente'
        );

        // Descargar archivo
        return redirect()->to(asset('storage/' . $filename));
    }

    public function openModalCreate()
    {

        $this->dispatch('open-modal-create');
    }

    public function openModalEdit(Dispositivos $dispositivo)
    {

        $this->dispatch('open-modal-edit', dispositivo: $dispositivo);
    }
    public function OpenModalImport()
    {
        $this->dispatch('open-modal-import');
    }
}
