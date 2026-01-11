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
