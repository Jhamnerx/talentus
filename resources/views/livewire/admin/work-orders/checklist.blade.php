<div class="px-4 sm:px-6 lg:px-8 py-6 w-full max-w-7xl mx-auto">

    {{-- Header con Progreso --}}
    <div class="mb-5 bg-white dark:bg-gray-800 rounded-lg shadow p-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    Checklist
                    <span
                        class="ml-2 px-2 py-0.5 rounded text-sm font-semibold
                        {{ $fase === 'before' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' }}">
                        {{ $fase === 'before' ? 'ANTES del trabajo' : 'DESPUÉS del trabajo' }}
                    </span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Orden: <span
                        class="font-mono font-semibold text-gray-700 dark:text-gray-300">{{ str_pad($workOrder->id, 5, '0', STR_PAD_LEFT) }}</span>
                    &nbsp;·&nbsp; Vehículo: <span
                        class="font-semibold text-gray-700 dark:text-gray-300">{{ $workOrder->vehiculo->placa ?? 'N/A' }}</span>
                </p>
            </div>

            <div class="flex items-center gap-6 shrink-0">
                {{-- Contador --}}
                <div class="text-center">
                    <div
                        class="text-3xl font-extrabold {{ $completados === $totalItems ? 'text-emerald-500' : 'text-blue-500 dark:text-blue-400' }}">
                        {{ $completados }}<span
                            class="text-lg text-gray-400 dark:text-gray-500">/{{ $totalItems }}</span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">completados</p>
                </div>
                {{-- Círculo de progreso textual --}}
                <div class="text-right hidden sm:block">
                    <span
                        class="text-2xl font-bold {{ $completados === $totalItems ? 'text-emerald-500' : 'text-blue-500 dark:text-blue-400' }}">
                        {{ $progreso }}%
                    </span>
                    <p class="text-xs text-gray-500 dark:text-gray-400">progreso</p>
                </div>
            </div>
        </div>

        {{-- Barra de Progreso --}}
        <div class="overflow-hidden h-2.5 rounded-full bg-gray-200 dark:bg-gray-700">
            <div style="width:{{ $progreso }}%"
                class="h-full rounded-full transition-all duration-500
                {{ $completados === $totalItems ? 'bg-emerald-500' : 'bg-blue-500' }}">
            </div>
        </div>
    </div>

    {{-- Checklist Items por Categoría — 2 columnas --}}
    @foreach ($checklistPorCategoria as $categoria => $items)
        <div class="mb-5 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">

            {{-- Header de Categoría --}}
            <div
                class="flex items-center justify-between bg-gray-100 dark:bg-gray-700/80 px-5 py-2.5 border-b border-gray-200 dark:border-gray-600">
                <h3 class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-widest">
                    {{ $categoria }}
                </h3>
                @php
                    $completadosCategoria = collect($items)->filter(fn($i) => isset($resultados[$i['id']]))->count();
                @endphp
                <span
                    class="text-xs font-semibold px-2 py-0.5 rounded-full
                    {{ $completadosCategoria === count($items) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-gray-200 text-gray-600 dark:bg-gray-600 dark:text-gray-300' }}">
                    {{ $completadosCategoria }}/{{ count($items) }}
                </span>
            </div>

            {{-- Grid 2 columnas --}}
            <div
                class="grid grid-cols-1 lg:grid-cols-2 divide-y divide-gray-100 dark:divide-gray-700/50 lg:divide-y-0 lg:divide-x">
                @foreach ($items as $index => $item)
                    @php $resultado = $resultados[$item['id']] ?? null; @endphp
                    <div
                        class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors
                        {{ $index > 0 && $index % 2 === 0 ? 'lg:col-span-2 lg:border-t lg:border-gray-100 dark:lg:border-gray-700/50' : '' }}
                        border-b border-gray-100 dark:border-gray-700/50 last:border-b-0">

                        <div class="flex items-start gap-3">

                            {{-- Estado (círculo) --}}
                            <div class="shrink-0 mt-0.5">
                                @if ($resultado)
                                    <div
                                        class="w-8 h-8 rounded-full flex items-center justify-center
                                        {{ $resultado === 'ok' ? 'bg-emerald-100 dark:bg-emerald-900/50' : '' }}
                                        {{ $resultado === 'observado' ? 'bg-amber-100 dark:bg-amber-900/50' : '' }}
                                        {{ $resultado === 'no_aplica' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                        @if ($resultado === 'ok')
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @elseif($resultado === 'observado')
                                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                @else
                                    <div
                                        class="w-8 h-8 rounded-full flex items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600">
                                    </div>
                                @endif
                            </div>

                            {{-- Contenido --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white leading-tight">
                                        {{ $item['nombre'] }}
                                    </h4>
                                </div>

                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3 leading-relaxed">
                                    {{ $item['descripcion'] }}
                                </p>

                                {{-- Radio Buttons compactos --}}
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" wire:click="seleccionarResultado({{ $item['id'] }}, 'ok')"
                                        class="inline-flex items-center gap-1.5 cursor-pointer px-3 py-1.5 rounded-lg border-2 transition-all text-xs font-medium
                                        {{ $resultado === 'ok'
                                            ? 'border-emerald-500 bg-emerald-50 text-emerald-700 dark:border-emerald-500 dark:bg-emerald-900/30 dark:text-emerald-300'
                                            : 'border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-emerald-400 hover:text-emerald-600 dark:hover:border-emerald-500 dark:hover:text-emerald-400' }}">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        OK
                                    </button>

                                    <button type="button"
                                        wire:click="seleccionarResultado({{ $item['id'] }}, 'observado')"
                                        class="inline-flex items-center gap-1.5 cursor-pointer px-3 py-1.5 rounded-lg border-2 transition-all text-xs font-medium
                                        {{ $resultado === 'observado'
                                            ? 'border-amber-500 bg-amber-50 text-amber-700 dark:border-amber-500 dark:bg-amber-900/30 dark:text-amber-300'
                                            : 'border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-amber-400 hover:text-amber-600 dark:hover:border-amber-500 dark:hover:text-amber-400' }}">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Observado
                                    </button>

                                    <button type="button"
                                        wire:click="seleccionarResultado({{ $item['id'] }}, 'no_aplica')"
                                        class="inline-flex items-center gap-1.5 cursor-pointer px-3 py-1.5 rounded-lg border-2 transition-all text-xs font-medium
                                        {{ $resultado === 'no_aplica'
                                            ? 'border-gray-400 bg-gray-100 text-gray-700 dark:border-gray-400 dark:bg-gray-700 dark:text-gray-300'
                                            : 'border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-gray-400 hover:text-gray-700 dark:hover:border-gray-400 dark:hover:text-gray-300' }}">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        N/A
                                    </button>
                                </div>

                                {{-- Observaciones --}}
                                @if ($resultado === 'observado')
                                    <div class="mt-2">
                                        <x-form.textarea wire:model.live.blur="observaciones.{{ $item['id'] }}"
                                            placeholder="Describe la observación..." rows="2"
                                            class="w-full text-xs" />
                                    </div>
                                @endif

                                {{-- Botón Foto (solo si resultado es observado o no aplica) --}}
                                @if ($resultado && $resultado !== 'ok')
                                    <div class="mt-2">
                                        <x-form.button xs outline secondary icon="camera"
                                            wire:click="abrirModalFoto({{ $item['id'] }})">
                                            Subir evidencia
                                        </x-form.button>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    {{-- Separador vertical entre columnas en lg --}}
                    @if ($loop->odd && !$loop->last)
                        {{-- nada, la división la maneja divide-x --}}
                    @endif
                @endforeach

                {{-- Si hay número impar de items, rellenar con celda vacía para mantener el grid --}}
                @if (count($items) % 2 !== 0)
                    <div class="hidden lg:block p-4 bg-gray-50/50 dark:bg-gray-800/50"></div>
                @endif
            </div>
        </div>
    @endforeach

    {{-- Barra inferior fija --}}
    <div class="sticky bottom-4 mt-4">
        <div
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="overflow-hidden h-2 w-32 rounded-full bg-gray-200 dark:bg-gray-700">
                    <div style="width:{{ $progreso }}%"
                        class="h-full rounded-full transition-all duration-500 {{ $completados === $totalItems ? 'bg-emerald-500' : 'bg-blue-500' }}">
                    </div>
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    <span
                        class="font-bold {{ $completados === $totalItems ? 'text-emerald-600 dark:text-emerald-400' : 'text-blue-600 dark:text-blue-400' }}">
                        {{ $completados }}/{{ $totalItems }}
                    </span> ítems completados
                </span>
            </div>
            <div class="flex gap-3">
                <x-form.button outline secondary href="{{ route('admin.work-orders.show', $workOrder) }}"
                    wire:navigate>
                    Cancelar
                </x-form.button>

                <x-form.button primary icon="check-circle" wire:click="finalizarChecklist" :disabled="$completados < $totalItems">
                    @if ($completados < $totalItems)
                        Faltan {{ $totalItems - $completados }} ítems
                    @else
                        Finalizar Checklist
                    @endif
                </x-form.button>
            </div>
        </div>
    </div>


    {{-- Modal para Subir Evidencia (opcional) --}}
    @if ($fotoTemplateId)
        <x-form.modal.card wire:model="fotoTemplateId" title="Subir Evidencia Fotográfica" width="md">
            <div class="space-y-4">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ $checklist[$fotoTemplateId]['nombre'] ?? '' }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Resultado: <span
                        class="font-semibold capitalize">{{ str_replace('_', ' ', $resultados[$fotoTemplateId] ?? '') }}</span>
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
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Máximo 5MB · Opcional</p>
                    @error("fotos.{$fotoTemplateId}")
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-between w-full">
                    <x-form.button outline secondary wire:click="cerrarModalFoto">
                        Omitir
                    </x-form.button>
                    <x-form.button primary wire:click="subirFoto" spinner="subirFoto" :disabled="!isset($fotos[$fotoTemplateId])">
                        Guardar Foto
                    </x-form.button>
                </div>
            </x-slot>
        </x-form.modal.card>
    @endif
</div>
