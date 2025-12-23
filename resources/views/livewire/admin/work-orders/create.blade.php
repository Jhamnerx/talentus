<div>
    <x-button wire:click="openModal" primary label="Nueva Orden de Trabajo" icon="plus" />

    <x-modal wire:model="modalSave" max-width="2xl">
        <x-card title="Nueva Orden de Trabajo">
            <div class="space-y-4">
                {{-- Tipo de Orden --}}
                <x-select label="Tipo de Orden *" wire:model.live="work_order_type_id" placeholder="Seleccionar tipo"
                    :options="$tipos" />

                {{-- Vehículo --}}
                <x-select label="Vehículo *" wire:model.live="vehiculo_id" placeholder="Buscar por placa"
                    :async-data="route('api.vehiculos.search')" option-label="placa" option-value="id" />

                {{-- Cliente (autocompleta) --}}
                <x-input label="Cliente *" wire:model="cliente_id" disabled />

                {{-- Técnico --}}
                <x-select label="Técnico Asignado *" wire:model="tecnico_id" placeholder="Seleccionar técnico"
                    :options="$tecnicos" option-label="name" option-value="id" />

                {{-- Fecha Programada --}}
                <x-datetime-picker label="Fecha Programada *" wire:model="fecha_programada" without-timezone
                    without-time-zone />

                {{-- Observaciones --}}
                <x-textarea label="Observaciones Iniciales" wire:model="observaciones_inicial"
                    placeholder="Información adicional..." rows="3" />
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancelar" wire:click="closeModal" />
                    <x-button primary label="Crear Orden" wire:click="save" spinner="save" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
