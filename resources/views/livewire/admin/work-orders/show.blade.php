<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto">
    {{-- Botón Regresar --}}
    <div class="mb-6">
        <a href="{{ route('admin.work-orders.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver al Listado
        </a>
    </div>

    {{-- Header con Información Principal --}}
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Orden: {{ $workOrder->codigo }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Creada: {{ $workOrder->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $workOrder->estado->statusColor() }}">
                        {{ $workOrder->estado->label() }}
                    </span>

                    @if ($workOrder->bloqueado)
                        <span
                            class="px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            🔒 Bloqueado
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Información del Servicio --}}
        <div class="px-6 py-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Tipo de
                    Orden</h3>
                <p class="text-sm text-gray-900 dark:text-white font-medium">
                    {{ $workOrder->tipo->nombre ?? 'N/A' }}
                </p>
            </div>

            <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                    Vehículo</h3>
                <p class="text-sm text-gray-900 dark:text-white font-medium">
                    {{ $workOrder->vehiculo->placa ?? 'N/A' }}
                </p>
                @if ($workOrder->vehiculo)
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                        {{ $workOrder->vehiculo->marca ?? '' }} {{ $workOrder->vehiculo->modelo ?? '' }}
                    </p>
                @endif
            </div>

            <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Cliente
                </h3>
                <p class="text-sm text-gray-900 dark:text-white font-medium">
                    {{ $workOrder->cliente->razon_social ?? ($workOrder->vehiculo->cliente->razon_social ?? 'N/A') }}
                </p>
            </div>

            <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Técnico
                    Asignado</h3>
                <p class="text-sm text-gray-900 dark:text-white font-medium">
                    {{ $workOrder->tecnico->name ?? 'Sin asignar' }}
                </p>
            </div>

            <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Fecha
                    Programada</h3>
                <p class="text-sm text-gray-900 dark:text-white font-medium">
                    {{ $workOrder->fecha_programada ? $workOrder->fecha_programada->format('d/m/Y H:i') : 'No programada' }}
                </p>
            </div>

            @if ($workOrder->imei || $workOrder->iccid)
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Dispositivo</h3>
                    <div class="text-sm text-gray-900 dark:text-white">
                        @if ($workOrder->imei)
                            <p class="font-mono">IMEI: {{ $workOrder->imei }}</p>
                        @endif
                        @if ($workOrder->iccid)
                            <p class="font-mono mt-1">ICCID: {{ $workOrder->iccid }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        @if ($workOrder->observaciones)
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                    Observaciones</h3>
                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                    {{ $workOrder->observaciones }}
                </p>
            </div>
        @endif
    </div>

    {{-- Acciones Rápidas --}}
    @if (!$workOrder->bloqueado)
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones</h2>

            <div class="flex flex-wrap gap-3">
                @if ($workOrder->estado->value === 'pendiente')
                    <x-form.button primary icon="play" wire:click="iniciar">
                        Iniciar Trabajo
                    </x-form.button>
                @endif

                @if ($workOrder->estado->value === 'en_proceso')
                    <x-form.button secondary icon="clipboard-document-list" wire:click="verChecklist('before')">
                        Checklist Inicial
                    </x-form.button>

                    <x-form.button secondary icon="clipboard-document-check" wire:click="verChecklist('after')">
                        Checklist Final
                    </x-form.button>

                    @if (!$workOrder->signatures()->where('tipo', 'conformidad')->exists())
                        <x-form.button warning icon="pencil-square" wire:click="abrirModalFirma">
                            Firma de Conformidad
                        </x-form.button>
                    @endif

                    <x-form.button positive icon="check" wire:click="finalizar">
                        Finalizar Trabajo
                    </x-form.button>
                @endif

                @if ($workOrder->estado->value === 'finalizado')
                    <x-form.button info icon="lock-closed" wire:click="cerrar">
                        Cerrar y Bloquear
                    </x-form.button>
                @endif

                @if (in_array($workOrder->estado->value, ['pendiente', 'en_proceso']))
                    <x-form.button negative icon="x-mark" wire:click="cancelar('Cancelado por usuario')">
                        Cancelar Orden
                    </x-form.button>
                @endif

                <x-form.button outline secondary icon="document-arrow-down" wire:click="descargarPDF">
                    Descargar PDF
                </x-form.button>
            </div>
        </div>
    @endif

    {{-- Timeline de Actividades --}}
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
            Timeline de Actividades
        </h2>

        <div class="relative">
            {{-- Línea vertical --}}
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-300 dark:bg-gray-600"></div>

            <div class="space-y-6">
                @forelse ($timeline as $event)
                    <div class="relative flex items-start gap-4 pl-12">
                        {{-- Icono --}}
                        <div
                            class="absolute left-0 flex items-center justify-center w-8 h-8 rounded-full 
                            bg-{{ $event['color'] }}-100 dark:bg-{{ $event['color'] }}-900
                            border-4 border-white dark:border-gray-800 z-10">
                            <svg class="w-4 h-4 text-{{ $event['color'] }}-600 dark:text-{{ $event['color'] }}-400"
                                fill="currentColor" viewBox="0 0 20 20">
                                @if ($event['icono'] === 'plus-circle')
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'play')
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'check-circle')
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'camera')
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'lock-closed')
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                @else
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                @endif
                            </svg>
                        </div>

                        {{-- Contenido --}}
                        <div class="flex-1 bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $event['titulo'] }}
                                    </h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $event['descripcion'] }}
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-4 whitespace-nowrap">
                                    {{ $event['fecha']->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            {{-- Data adicional si existe --}}
                            @if (isset($event['data']))
                                @if ($event['tipo'] === 'foto')
                                    <div class="mt-3">
                                        @php
                                            $photo = $event['data'];
                                            $filename = basename($photo->path);
                                        @endphp
                                        <img src="{{ route('admin.work-orders.file', ['workOrder' => $workOrder->id, 'type' => 'checklist', 'filename' => $filename]) }}"
                                            alt="Evidencia"
                                            class="h-32 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm">
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">No hay actividades registradas aún</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Accesorios Instalados --}}
    @if ($workOrder->accessories->isNotEmpty())
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Accesorios Instalados</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Producto</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Cantidad</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Precio Unit.</th>
                            <th
                                class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($workOrder->accessories as $accessory)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ $accessory->producto->nombre ?? $accessory->descripcion }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ $accessory->cantidad }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white font-mono">
                                    S/ {{ number_format($accessory->precio_unitario, 2) }}
                                </td>
                                <td
                                    class="px-4 py-3 text-sm text-gray-900 dark:text-white font-mono text-right font-semibold">
                                    S/ {{ number_format($accessory->precio_unitario * $accessory->cantidad, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50 dark:bg-gray-900 font-semibold">
                            <td colspan="3" class="px-4 py-3 text-sm text-gray-900 dark:text-white text-right">
                                Total:
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white font-mono text-right">
                                S/
                                {{ number_format($workOrder->accessories->sum(fn($a) => $a->precio_unitario * $a->cantidad), 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Modal de Firma --}}
    @if ($modalFirma)
        <x-form.modal.card wire:model="modalFirma" title="Firma de Conformidad del Cliente" max-width="2xl">
            <div class="space-y-4">
                <x-form.input wire:model="nombreFirmante" label="Nombre del Firmante *"
                    placeholder="Ej: Juan Pérez" />

                <x-form.select wire:model="tipoFirmante" label="Tipo de Firmante *" placeholder="Seleccione un tipo">
                    <x-select.option label="Cliente" value="cliente" />
                    <x-select.option label="Conductor" value="conductor" />
                    <x-select.option label="Encargado" value="encargado" />
                    <x-select.option label="Supervisor" value="supervisor" />
                </x-form.select>

                <x-form.input wire:model="documentoFirmante" label="Documento (Opcional)" placeholder="DNI o RUC" />

                <div wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Firma Digital *
                    </label>
                    <div class="border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                        <canvas id="signatureCanvas" width="600" height="200"
                            class="w-full touch-none cursor-crosshair"></canvas>
                    </div>
                    <div class="mt-2 flex justify-end">
                        <button type="button" onclick="clearSignature()"
                            class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                            Limpiar Firma
                        </button>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <p class="text-sm text-blue-800 dark:text-blue-300">
                        <strong>Nota:</strong> Al firmar, confirma que el trabajo ha sido realizado satisfactoriamente
                        y que está conforme con el servicio prestado.
                    </p>
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-3">
                    <x-form.button outline secondary wire:click="$set('modalFirma', false)">
                        Cancelar
                    </x-form.button>

                    <x-form.button primary onclick="guardarFirmaConDatos()">
                        Guardar Firma
                    </x-form.button>
                </div>
            </x-slot>
        </x-form.modal.card>
    @endif

    @push('scripts')
        <script>
            let signatureCanvas = null;
            let signatureCtx = null;
            let isDrawing = false;
            let lastX = 0;
            let lastY = 0;

            function initSignatureCanvas() {
                signatureCanvas = document.getElementById('signatureCanvas');
                if (!signatureCanvas) return;

                signatureCtx = signatureCanvas.getContext('2d');

                // Limpiar listeners previos
                signatureCanvas.replaceWith(signatureCanvas.cloneNode(true));
                signatureCanvas = document.getElementById('signatureCanvas');
                signatureCtx = signatureCanvas.getContext('2d');

                function getMousePos(e) {
                    const rect = signatureCanvas.getBoundingClientRect();
                    const scaleX = signatureCanvas.width / rect.width;
                    const scaleY = signatureCanvas.height / rect.height;
                    return {
                        x: (e.clientX - rect.left) * scaleX,
                        y: (e.clientY - rect.top) * scaleY
                    };
                }

                function getTouchPos(e) {
                    const rect = signatureCanvas.getBoundingClientRect();
                    const scaleX = signatureCanvas.width / rect.width;
                    const scaleY = signatureCanvas.height / rect.height;
                    return {
                        x: (e.touches[0].clientX - rect.left) * scaleX,
                        y: (e.touches[0].clientY - rect.top) * scaleY
                    };
                }

                function startDrawing(e) {
                    isDrawing = true;
                    const pos = e.touches ? getTouchPos(e) : getMousePos(e);
                    [lastX, lastY] = [pos.x, pos.y];
                }

                function draw(e) {
                    if (!isDrawing) return;
                    e.preventDefault();

                    const pos = e.touches ? getTouchPos(e) : getMousePos(e);

                    signatureCtx.strokeStyle = '#000';
                    signatureCtx.lineWidth = 2;
                    signatureCtx.lineCap = 'round';
                    signatureCtx.lineJoin = 'round';

                    signatureCtx.beginPath();
                    signatureCtx.moveTo(lastX, lastY);
                    signatureCtx.lineTo(pos.x, pos.y);
                    signatureCtx.stroke();

                    [lastX, lastY] = [pos.x, pos.y];
                    // NO actualizar Livewire en cada trazo
                }

                function stopDrawing() {
                    isDrawing = false;
                }

                // Mouse events
                signatureCanvas.addEventListener('mousedown', startDrawing);
                signatureCanvas.addEventListener('mousemove', draw);
                signatureCanvas.addEventListener('mouseup', stopDrawing);
                signatureCanvas.addEventListener('mouseout', stopDrawing);

                // Touch events
                signatureCanvas.addEventListener('touchstart', startDrawing, {
                    passive: false
                });
                signatureCanvas.addEventListener('touchmove', draw, {
                    passive: false
                });
                signatureCanvas.addEventListener('touchend', stopDrawing);
            }

            window.clearSignature = function() {
                if (signatureCanvas && signatureCtx) {
                    signatureCtx.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
                }
            };

            window.guardarFirmaConDatos = function() {
                if (signatureCanvas) {
                    const signatureData = signatureCanvas.toDataURL('image/png');
                    @this.set('signatureData', signatureData).then(() => {
                        @this.call('guardarFirma');
                    });
                } else {
                    @this.call('guardarFirma');
                }
            };

            // Inicializar cuando el modal se abre
            document.addEventListener('livewire:initialized', () => {
                Livewire.hook('morph.updated', () => {
                    setTimeout(() => {
                        const canvas = document.getElementById('signatureCanvas');
                        if (canvas && !canvas.dataset.initialized) {
                            canvas.dataset.initialized = 'true';
                            initSignatureCanvas();
                        }
                    }, 100);
                });
            });

            // También inicializar en DOMContentLoaded por si acaso
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    const canvas = document.getElementById('signatureCanvas');
                    if (canvas) {
                        initSignatureCanvas();
                    }
                }, 500);
            });
        </script>
    @endpush
</div>
