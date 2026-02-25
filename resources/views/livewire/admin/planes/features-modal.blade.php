<div>
    <x-form.modal.card
        title="Características del Plan: {{ is_array($plan?->name) ? $plan->name['es'] ?? ($plan->name['en'] ?? 'Plan') : $plan?->name ?? 'Plan' }}"
        wire:model.live="modalFeatures" width="5xl" align="center">

        <div class="space-y-6">

            <!-- Features Existentes -->
            @if ($plan && count($features) > 0)
                <div class="bg-gray-50 dark:bg-gray-900/20 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">📌 Características Existentes
                    </h3>
                    <div class="space-y-2">
                        @foreach ($features as $feature)
                            <div
                                class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ is_array($feature['name']) ? $feature['name']['es'] ?? ($feature['name']['en'] ?? 'Sin nombre') : $feature['name'] }}
                                        </span>
                                        <span
                                            class="text-xs px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200">
                                            {{ $feature['slug'] }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        <span class="font-medium">Valor:</span> {{ $feature['value'] }}
                                    </div>
                                    @if ($feature['description'])
                                        <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                            {{ is_array($feature['description']) ? $feature['description']['es'] ?? ($feature['description']['en'] ?? '') : $feature['description'] }}
                                        </div>
                                    @endif
                                    @if ($feature['resettable_period'] > 0)
                                        <div class="text-xs text-orange-600 dark:text-orange-400 mt-1">
                                            ⏱️ Se resetea cada {{ $feature['resettable_period'] }}
                                            {{ $intervals[$feature['resettable_interval']] ?? $feature['resettable_interval'] }}
                                        </div>
                                    @endif
                                </div>
                                <x-form.button negative icon="trash" wire:click="deleteFeature({{ $feature['id'] }})"
                                    spinner="deleteFeature({{ $feature['id'] }})" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p>Este plan no tiene características configuradas aún.</p>
                </div>
            @endif

            <!-- Agregar Nueva Feature -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">➕ Agregar Nueva Característica
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.input label="Nombre *" wire:model.live="name"
                        placeholder="Ej: Número máximo de vehículos" />
                    <x-form.input label="Slug *" wire:model.live="slug" placeholder="max_vehiculos"
                        hint="Se genera automáticamente" />
                    <div class="md:col-span-2">
                        <x-form.textarea label="Descripción" wire:model.live="description"
                            placeholder="Descripción de la característica" rows="2" />
                    </div>
                    <x-form.input label="Valor *" wire:model.live="value" placeholder="Ej: 50, unlimited, true"
                        hint="Puede ser número, texto o booleano" />
                    <x-form.number label="Orden" wire:model.live="sort_order" placeholder="0" min="0" />

                    <!-- Resettable Period -->
                    <div class="md:col-span-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg p-3">
                        <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">🔄 Periodo de Reseteo
                            (opcional)</h4>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">Si esta característica tiene límite de
                            uso, se puede resetear periódicamente (ej: 100 alertas por mes)</p>
                        <div class="grid grid-cols-2 gap-4">
                            <x-form.number label="Periodo" wire:model.live="resettable_period" placeholder="0"
                                min="0" hint="0 = No se resetea" />
                            <x-form.select label="Intervalo" wire:model.live="resettable_interval">
                                @foreach ($intervals as $key => $value)
                                    <x-select.option label="{{ $value }}" value="{{ $key }}" />
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <x-form.button label="Agregar Característica" wire:click="addFeature" primary
                            spinner="addFeature" icon="plus" class="w-full" />
                    </div>
                </div>
            </div>

            <!-- Ejemplos Comunes -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">💡 Ejemplos de Características
                    Comunes</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600 dark:text-gray-400">
                    <div><span class="font-medium">max_vehiculos:</span> 50</div>
                    <div><span class="font-medium">video_enabled:</span> true</div>
                    <div><span class="font-medium">max_usuarios:</span> 10</div>
                    <div><span class="font-medium">alertas_mensuales:</span> 100</div>
                    <div><span class="font-medium">soporte_prioritario:</span> true</div>
                    <div><span class="font-medium">reportes_personalizados:</span> unlimited</div>
                </div>
            </div>

        </div>

        <x-slot name="footer">
            <div class="flex justify-end">
                <x-form.button label="Cerrar" wire:click="closeModal" primary />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
