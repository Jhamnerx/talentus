<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    {{-- Header con Progreso --}}
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Checklist {{ strtoupper($fase) }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Orden: {{ str_pad($workOrder->id, 5, '0', STR_PAD_LEFT) }} | Vehículo:
                    {{ $workOrder->vehiculo->placa ?? 'N/A' }}
                </p>
            </div>

            <div class="text-right">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                    {{ $completados }}/{{ $totalItems }}
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Ítems completados</p>
            </div>
        </div>

        {{-- Barra de Progreso --}}
        <div class="relative pt-1">
            <div class="flex mb-2 items-center justify-between">
                <div>
                    <span
                        class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200 dark:bg-blue-900 dark:text-blue-300">
                        Progreso
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-xs font-semibold inline-block text-blue-600 dark:text-blue-400">
                        {{ $progreso }}%
                    </span>
                </div>
            </div>
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200 dark:bg-gray-700">
                <div style="width:{{ $progreso }}%"
                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500">
                </div>
            </div>
        </div>
    </div>

    {{-- Checklist Items por Categoría --}}
    @foreach ($checklistPorCategoria as $categoria => $items)
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            {{-- Header de Categoría --}}
            <div class="bg-gray-100 dark:bg-gray-700 px-6 py-3 border-b border-gray-200 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white uppercase">
                    {{ $categoria }}
                </h3>
            </div>

            {{-- Items de la Categoría --}}
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($items as $item)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                        <div class="flex items-start gap-4">
                            {{-- Nombre y Descripción --}}
                            <div class="flex-1">
                                <h4 class="text-base font-medium text-gray-900 dark:text-white mb-1">
                                    {{ $item['nombre'] }}
                                    @if ($item['requiere_foto'])
                                        <span
                                            class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Foto requerida
                                        </span>
                                    @endif
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $item['descripcion'] }}
                                </p>

                                {{-- Resultado (Radio Buttons) --}}
                                <div class="mt-4 flex flex-wrap gap-4">
                                    <label
                                        class="inline-flex items-center cursor-pointer px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 hover:border-green-500 dark:hover:border-green-400 transition-all">
                                        <input type="radio" wire:model.live="resultados.{{ $item['id'] }}"
                                            value="ok"
                                            class="form-radio h-5 w-5 text-green-600 dark:text-green-500 focus:ring-green-500">
                                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            <span class="inline-flex items-center">
                                                ✅ OK
                                            </span>
                                        </span>
                                    </label>

                                    <label
                                        class="inline-flex items-center cursor-pointer px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 hover:border-yellow-500 dark:hover:border-yellow-400 transition-all">
                                        <input type="radio" wire:model.live="resultados.{{ $item['id'] }}"
                                            value="observado"
                                            class="form-radio h-5 w-5 text-yellow-600 dark:text-yellow-500 focus:ring-yellow-500">
                                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            ⚠️ Observado
                                        </span>
                                    </label>

                                    <label
                                        class="inline-flex items-center cursor-pointer px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 hover:border-gray-500 dark:hover:border-gray-400 transition-all">
                                        <input type="radio" wire:model.live="resultados.{{ $item['id'] }}"
                                            value="no_aplica"
                                            class="form-radio h-5 w-5 text-gray-600 dark:text-gray-500 focus:ring-gray-500">
                                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            ➖ No Aplica
                                        </span>
                                    </label>
                                </div>

                                {{-- Observaciones (Si está marcado como OBSERVADO) --}}
                                @if (isset($resultados[$item['id']]) && $resultados[$item['id']] === 'observado')
                                    <div class="mt-3">
                                        <x-form.textarea wire:model.blur="observaciones.{{ $item['id'] }}"
                                            placeholder="Describe la observación..." rows="2" class="w-full" />
                                    </div>
                                @endif

                                {{-- Upload de Foto --}}
                                @if ($item['requiere_foto'] && isset($resultados[$item['id']]))
                                    <div class="mt-3">
                                        <x-form.button xs outline primary icon="camera"
                                            wire:click="abrirModalFoto({{ $item['id'] }})">
                                            Subir Evidencia
                                        </x-form.button>
                                    </div>
                                @endif
                            </div>

                            {{-- Indicador de Estado --}}
                            <div class="shrink-0">
                                @if (isset($resultados[$item['id']]))
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center
                                        {{ $resultados[$item['id']] === 'ok' ? 'bg-green-100 dark:bg-green-900' : '' }}
                                        {{ $resultados[$item['id']] === 'observado' ? 'bg-yellow-100 dark:bg-yellow-900' : '' }}
                                        {{ $resultados[$item['id']] === 'no_aplica' ? 'bg-gray-100 dark:bg-gray-700' : '' }}
                                    ">
                                        @if ($resultados[$item['id']] === 'ok')
                                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @elseif($resultados[$item['id']] === 'observado')
                                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                @else
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-200 dark:bg-gray-600">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- Botón Finalizar --}}
    <div class="mt-6 flex justify-end gap-4 sticky bottom-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
        <x-form.button lg outline secondary href="{{ route('admin.work-orders.show', $workOrder) }}" wire:navigate>
            Cancelar
        </x-form.button>

        <x-form.button lg primary icon="check-circle" wire:click="finalizarChecklist" :disabled="$completados < $totalItems">
            Finalizar Checklist ({{ $completados }}/{{ $totalItems }})
        </x-form.button>
    </div>

    {{-- Modal para Subir Foto --}}
    @if ($fotoTemplateId)
        <x-form.modal.card wire:model="fotoTemplateId" title="Subir Evidencia Fotográfica" width="md">
            <div class="space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $checklist[$fotoTemplateId]['nombre'] ?? '' }}
                </p>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Seleccionar Foto
                    </label>
                    <input type="file" wire:model="fotos.{{ $fotoTemplateId }}" accept="image/*"
                        class="block w-full text-sm text-gray-900 dark:text-gray-100 
                               border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer 
                               bg-gray-50 dark:bg-gray-700 focus:outline-none focus:ring-2 
                               focus:ring-blue-500 dark:focus:ring-blue-600">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Máximo 5MB</p>
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-3">
                    <x-form.button outline secondary wire:click="cerrarModalFoto">
                        Cancelar
                    </x-form.button>

                    <x-form.button primary wire:click="subirFoto" :disabled="!isset($fotos[$fotoTemplateId])">
                        Subir Foto
                    </x-form.button>
                </div>
            </x-slot>
        </x-form.modal.card>
    @endif
</div>
