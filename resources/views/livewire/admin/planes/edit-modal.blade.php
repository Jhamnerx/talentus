<div>
    <x-form.modal.card title="Editar Plan: {{ $plan?->name['es'] ?? 'Plan' }}" wire:model.live="modalEdit" width="6xl"
        align="center">
        <div class="space-y-6">

            <!-- Información Básica -->
            <div class="bg-gray-50 dark:bg-gray-900/20 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">📋 Información Básica</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <x-form.input label="Nombre (Español) *" wire:model.live="name_es" placeholder="Ej: Plan Pro" />
                    </div>
                    <x-form.input label="Nombre (Inglés)" wire:model.live="name_en" placeholder="Ej: Pro Plan" />
                    <x-form.input label="Slug *" wire:model.live="slug" placeholder="plan-pro" />
                    <x-form.textarea label="Descripción (Español)" wire:model.live="description_es"
                        placeholder="Descripción del plan" rows="2" />
                    <x-form.textarea label="Descripción (Inglés)" wire:model.live="description_en"
                        placeholder="Plan description" rows="2" />
                    <x-form.select label="Producto Asociado" wire:model.live="producto_id"
                        placeholder="Seleccionar producto">
                        @foreach ($productos as $producto)
                            <x-select.option label="{{ $producto->descripcion }}" value="{{ $producto->id }}" />
                        @endforeach
                    </x-form.select>
                    <div class="flex items-center">
                        <x-form.toggle label="Plan Activo" wire:model.live="is_active" />
                    </div>
                </div>
            </div>

            <!-- Precios -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">💰 Precios</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-form.currency label="Precio Mensual *" wire:model.live="price" placeholder="0.00" />
                    <x-form.currency label="Cuota de Registro" wire:model.live="signup_fee" placeholder="0.00" />
                    <x-form.select label="Moneda *" wire:model.live="currency">
                        @foreach ($currencies as $curr)
                            <x-select.option label="{{ $curr }}" value="{{ $curr }}" />
                        @endforeach
                    </x-form.select>
                </div>
            </div>

            <!-- Facturación -->
            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">📅 Periodo de Facturación</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.number label="Periodo *" wire:model.live="invoice_period" placeholder="1" min="1" />
                    <x-form.select label="Intervalo *" wire:model.live="invoice_interval">
                        @foreach ($intervals as $key => $value)
                            <x-select.option label="{{ $value }}" value="{{ $key }}" />
                        @endforeach
                    </x-form.select>
                </div>
            </div>

            <!-- Periodo de Prueba -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">🎁 Periodo de Prueba</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.number label="Periodo de Prueba" wire:model.live="trial_period" placeholder="0"
                        min="0" hint="0 = Sin periodo de prueba" />
                    <x-form.select label="Intervalo" wire:model.live="trial_interval">
                        @foreach ($intervals as $key => $value)
                            <x-select.option label="{{ $value }}" value="{{ $key }}" />
                        @endforeach
                    </x-form.select>
                </div>
            </div>

            <!-- Grace Period -->
            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">⏰ Periodo de Gracia</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.number label="Periodo de Gracia" wire:model.live="grace_period" placeholder="0"
                        min="0" hint="Días adicionales después del vencimiento" />
                    <x-form.select label="Intervalo" wire:model.live="grace_interval">
                        @foreach ($intervals as $key => $value)
                            <x-select.option label="{{ $value }}" value="{{ $key }}" />
                        @endforeach
                    </x-form.select>
                </div>
            </div>

            <!-- Otras Opciones -->
            <div class="bg-gray-50 dark:bg-gray-900/20 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">⚙️ Otras Opciones</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.number label="Orden de Visualización" wire:model.live="sort_order" placeholder="0"
                        min="0" hint="Menor número aparece primero" />
                    <x-form.number label="Límite de Suscriptores" wire:model.live="active_subscribers_limit"
                        placeholder="Sin límite" min="0" />
                </div>
            </div>

        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button label="Cancelar" wire:click="closeModal" flat />
                <x-form.button label="Actualizar Plan" wire:click="update" primary spinner="update" icon="check" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
