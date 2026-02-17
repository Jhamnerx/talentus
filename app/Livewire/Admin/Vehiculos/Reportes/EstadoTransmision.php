<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Vehiculos;
use App\Models\Reportes;
use App\Services\GpsWoxService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class EstadoTransmision extends Component
{
    use WireUiActions;

    public $openModalEstadoTransmision = false;
    public $loading = false;
    public $estadoData = null;
    public $selectedCategory = 'all'; // all, ok, warning, critical, emergency, never_connected
    public $searchPlaca = '';

    // Para crear reporte
    public $creandoReporte = false;
    public $dispositivoSeleccionado = null;
    public $detalle = '';
    public $fecha_t = '';
    public $hora_t = '';

    public function mount()
    {
        $now = Carbon::now();
        $this->hora_t = $now->format('H:i');
        $this->fecha_t = $now->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.reportes.estado-transmision');
    }

    #[On('abrirEstadoTransmision')]
    public function openModal()
    {
        $this->openModalEstadoTransmision = true;
        $this->loading = true;
        $this->consultarEstado();
    }

    public function closeModal()
    {
        $this->openModalEstadoTransmision = false;
        $this->reset('estadoData', 'selectedCategory', 'searchPlaca', 'creandoReporte', 'dispositivoSeleccionado', 'detalle');
        $this->resetErrorBag();
    }

    public function consultarEstado()
    {
        $this->loading = true;

        try {
            $service = new GpsWoxService();
            $response = $service->getDevicesTransmissionStatus(false);

            if ($response['status'] === 1) {
                $this->estadoData = $response;
                $this->notification()->success('Estado actualizado correctamente');
            } else {
                $this->notification()->error($response['message'] ?? 'Error al consultar estado');
            }
        } catch (\Exception $e) {
            dd($e);
            $this->notification()->error('Error: ' . $e->getMessage());
        } finally {
            $this->loading = false;
        }
    }

    public function getCategoriasFiltradas()
    {
        if (!$this->estadoData) {
            return collect([]);
        }

        $categorias = collect($this->estadoData['categories']);

        // Filtrar por categoría seleccionada
        if ($this->selectedCategory !== 'all') {
            $categorias = $categorias->filter(function ($categoria) {
                return $categoria['key'] === $this->selectedCategory;
            });
        }

        // Filtrar por búsqueda de placa
        if (!empty($this->searchPlaca)) {
            $categorias = $categorias->map(function ($categoria) {
                $categoria['items'] = collect($categoria['items'])->filter(function ($item) {
                    return str_contains(
                        strtoupper($item['plate_number']),
                        strtoupper($this->searchPlaca)
                    );
                })->values()->toArray();
                $categoria['count'] = count($categoria['items']);
                return $categoria;
            });
        }

        return $categorias;
    }

    public function prepararReporte($deviceData)
    {
        $this->creandoReporte = true;
        $this->dispositivoSeleccionado = $deviceData;

        // Buscar vehículo por placa
        $vehiculo = Vehiculos::where('placa', $deviceData['plate_number'])->first();

        if (!$vehiculo) {
            // Si no existe, pre-rellenar con información del dispositivo
            $this->detalle = sprintf(
                "Dispositivo sin transmisión desde: %s\nPlaca: %s\nIMEI: %s\nSIM: %s\nÚltima conexión: %s\nTiempo offline: %s días",
                $deviceData['last_connection'],
                $deviceData['plate_number'],
                $deviceData['imei'],
                $deviceData['sim_number'],
                $deviceData['last_connection'],
                number_format($deviceData['days_offline'], 1)
            );
        } else {
            // Si existe, agregar información del vehículo
            $this->detalle = sprintf(
                "Vehículo %s sin transmisión\nCliente: %s\nÚltima conexión: %s\nTiempo offline: %s días (%s horas)\nIMEI: %s\nSIM: %s",
                $vehiculo->placa,
                $vehiculo->cliente->razon_social ?? 'Sin cliente',
                $deviceData['last_connection'],
                number_format($deviceData['days_offline'], 1),
                number_format($deviceData['hours_offline'], 1),
                $deviceData['imei'],
                $deviceData['sim_number']
            );
        }
    }

    public function cancelarReporte()
    {
        $this->creandoReporte = false;
        $this->dispositivoSeleccionado = null;
        $this->detalle = '';
        $this->resetErrorBag();
    }

    public function guardarReporte()
    {
        $this->validate([
            'detalle' => 'required|string|min:10',
            'fecha_t' => 'required|date',
            'hora_t' => 'required',
        ], [
            'detalle.required' => 'El detalle es obligatorio',
            'detalle.min' => 'El detalle debe tener al menos 10 caracteres',
            'fecha_t.required' => 'La fecha de transmisión es obligatoria',
            'hora_t.required' => 'La hora de transmisión es obligatoria',
        ]);

        try {
            // Buscar o crear vehículo
            $vehiculo = Vehiculos::where('placa', $this->dispositivoSeleccionado['plate_number'])->first();

            if (!$vehiculo) {
                $this->notification()->error(
                    'No se encontró el vehículo con placa: ' . $this->dispositivoSeleccionado['plate_number'] .
                        '. Debe registrarlo primero en el sistema.'
                );
                return;
            }

            // Crear reporte
            $reporte = new Reportes();
            $reporte->vehiculos_id = $vehiculo->id;
            $reporte->hora_t = $this->hora_t;
            $reporte->fecha_t = $this->fecha_t;
            $reporte->fecha = today();
            $reporte->detalle = $this->detalle;
            $reporte->user_id = Auth::user()->id;
            $reporte->empresa_id = session('empresa');
            $reporte->save();

            $this->notification()->success(
                'Reporte creado',
                'Se registró el reporte de la unidad: ' . $vehiculo->placa
            );

            $this->dispatch('update-table');
            $this->cancelarReporte();
        } catch (\Exception $e) {
            $this->notification()->error('Error al guardar: ' . $e->getMessage());
        }
    }

    public function getBadgeColor($key)
    {
        return match ($key) {
            'ok' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-400',
            'warning' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-800 dark:text-amber-400',
            'critical' => 'bg-orange-100 dark:bg-orange-500/20 text-orange-800 dark:text-orange-400',
            'emergency' => 'bg-red-100 dark:bg-red-500/20 text-red-800 dark:text-red-400',
            'never_connected' => 'bg-slate-100 dark:bg-slate-500/20 text-slate-800 dark:text-slate-400',
            default => 'bg-gray-100 dark:bg-gray-500/20 text-gray-800 dark:text-gray-400',
        };
    }

    public function getIconByCategory($key)
    {
        return match ($key) {
            'ok' => '✓',
            'warning' => '⚠',
            'critical' => '⚡',
            'emergency' => '🚨',
            'never_connected' => '⊘',
            default => '•',
        };
    }
}
