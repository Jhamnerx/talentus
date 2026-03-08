<x-form.modal.card title="Nueva Orden de Trabajo" wire:model.live="modalSave" max-width="2xl">
    <div class="space-y-4">
        {{-- Tipo de Orden --}}
        <x-form.select label="Tipo de Orden *" wire:model.live="work_order_type_id" placeholder="Seleccionar tipo"
            :options="$tipos" option-label="nombre" option-value="id" />

        {{-- Vehículo --}}
        <x-form.select autocomplete="off" label="Vehículo *" wire:model.live="vehiculo_id" placeholder="Buscar por placa"
            :async-data="route('api.vehiculos.index')" option-label="placa" option-value="id">

            <x-slot name="beforeOptions" class="p-2 flex justify-center">
                <x-form.button wire:click.prevent="addVehiculo(`${search}`)" x-on:click="close" primary flat full>
                    <span x-html="`Registrar Vehículo <b>${search}</b>`"></span>
                </x-form.button>
            </x-slot>
        </x-form.select>

        {{-- Cliente (autocompleta) --}}
        <x-form.input label="Cliente *" wire:model="cliente_nombre" disabled />

        {{-- Técnico --}}
        <x-form.select label="Técnico Asignado *" wire:model="tecnico_id" placeholder="Seleccionar técnico"
            :options="$tecnicos" option-label="name" option-value="id" />

        {{-- Fecha Programada --}}
        <x-form.datetime.picker label="Fecha Programada *" wire:model.live="fecha_programada"
            parse-format="YYYY-MM-DD HH:mm" display-format="DD-MM-YYYY HH:mm" :clearable="false" />

        {{-- Vincular Mantenimiento Programado (solo cuando el tipo lo requiere) --}}
        @if ($tipoRequiereMantenimiento)
            <div
                class="rounded-lg border border-amber-200 bg-amber-50 p-3
                        dark:border-amber-600/30 dark:bg-amber-950/20">
                <div class="mb-2 flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-amber-500 dark:text-amber-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-semibold text-amber-700 dark:text-amber-400">
                        Mantenimiento Programado
                    </span>
                </div>

                @if (!$vehiculo_id)
                    <p class="text-xs text-amber-600 dark:text-amber-400/80">
                        Selecciona un vehículo para ver las notificaciones de mantenimiento pendientes.
                    </p>
                @elseif ($mantenimientosPendientes->isEmpty())
                    <p class="text-xs text-amber-600 dark:text-amber-400/80">
                        No hay mantenimientos programados pendientes para este vehículo.
                    </p>
                @else
                    <x-form.select label="Vincular con Notificación de Mantenimiento" wire:model="mantenimiento_id"
                        placeholder="Seleccionar mantenimiento programado (opcional)" :options="$mantenimientosPendientes"
                        option-label="label" option-value="id" :clearable="true" />
                    <p class="mt-1 text-xs text-amber-600 dark:text-amber-400/80">
                        Al finalizar la orden, el mantenimiento vinculado se marcará como
                        <strong class="font-semibold text-amber-700 dark:text-amber-300">completado</strong>.
                    </p>
                @endif
            </div>
        @endif

        {{-- Observaciones --}}
        <x-form.textarea label="Observaciones Iniciales" wire:model="observaciones_inicial"
            placeholder="Información adicional..." rows="3" />
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-form.button flat label="Cancelar" wire:click="closeModal" />
            <x-form.button primary label="Crear Orden" wire:click="save" spinner="save" />
        </div>
    </x-slot>

</x-form.modal.card>
