<div>
    <x-form.modal.card
        title="Características del Plan: {{ is_array($plan?->name) ? $plan->name['es'] ?? ($plan->name['en'] ?? 'Plan') : $plan?->name ?? 'Plan' }}"
        wire:model.live="modalFeatures" width="4xl" align="center">

        <div class="space-y-6">

            <!-- Features Existentes -->
            @if ($plan && count($features) > 0)
                <div class="bg-gray-50 dark:bg-gray-900/20 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        📌 Características configuradas ({{ count($features) }})
                    </h3>
                    <div class="space-y-2">
                        @foreach ($features as $feature)
                            <div
                                class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ is_array($feature['name']) ? $feature['name']['es'] ?? ($feature['name']['en'] ?? 'Sin nombre') : $feature['name'] }}
                                    </div>
                                    @if (!empty($feature['description']))
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            {{ is_array($feature['description']) ? $feature['description']['es'] ?? ($feature['description']['en'] ?? '') : $feature['description'] }}
                                        </div>
                                    @endif
                                </div>
                                <x-form.button negative icon="trash" flat
                                    wire:click="deleteFeature({{ $feature['id'] }})"
                                    spinner="deleteFeature({{ $feature['id'] }})" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                    <p>Este plan no tiene características configuradas aún.</p>
                </div>
            @endif

            <!-- Agregar Nueva Feature -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">➕ Agregar característica</h3>
                <div class="flex flex-col gap-3">
                    <x-form.input label="Nombre *" wire:model.live="name"
                        placeholder="Ej: Geocercas, Alertas configurables, App móvil"
                        wire:keydown.enter="addFeature" />
                    <x-form.textarea label="Descripción (opcional)" wire:model.live="description"
                        placeholder="Detalle adicional" rows="2" />
                    <x-form.button label="Agregar" wire:click="addFeature" primary spinner="addFeature"
                        icon="plus" />
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