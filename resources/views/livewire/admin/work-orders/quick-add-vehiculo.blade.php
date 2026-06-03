<div>
    <x-form.modal.card title="Registrar Vehículo (Rápido)" wire:model.live="modalOpen" width="lg" blur persistent>
        <div class="space-y-4">

            {{-- Placa + botón de consulta API --}}
            <div>
                <x-form.input wire:model.live="placa" label="Placa *" placeholder="Ej: ABC123"
                    hint="Sin espacios. Se convierte a mayúsculas automáticamente."
                    x-on:input="$event.target.value = $event.target.value.replace(/\s/g, '').toUpperCase()">
                    <x-slot name="append">
                        <x-form.button class="h-full" icon="magnifying-glass" rounded="rounded-r-md" primary flat
                            wire:click="buscarPlaca" wire:loading.attr="disabled" spinner="buscarPlaca"
                            title="Consultar placa en el registro vehicular" />
                    </x-slot>
                </x-form.input>
                @if ($errorConsultaPlaca)
                    <p class="mt-1 text-xs text-amber-600">{{ $errorConsultaPlaca }}</p>
                @endif
            </div>

            {{-- Cliente (requerido) --}}
            <x-form.select label="Cliente *" wire:model.live="clientes_id"
                placeholder="Buscar cliente por razón social o RUC" :async-data="route('api.clientes.index')" option-label="razon_social"
                option-value="id" option-description="numero_documento" />

            {{-- Marca / Modelo / Tipo / Año / Color / Motor / Serie --}}
            <div class="grid grid-cols-2 gap-3">
                <x-form.input wire:model="marca" label="Marca" placeholder="TOYOTA" />
                <x-form.input wire:model="modelo" label="Modelo" placeholder="HILUX" />
                <x-form.input wire:model="tipo" label="Tipo" placeholder="PICK UP" />
                <x-form.input wire:model="year" label="Año" placeholder="2024" />
                <x-form.input wire:model="color" label="Color" placeholder="BLANCO" />
                <x-form.input wire:model="motor" label="Motor" placeholder="1GDG066086" />
            </div>
            <x-form.input wire:model="serie" label="Serie" placeholder="8AJHA8CD9K2629775" />

            {{-- Descripción --}}
            <x-form.textarea wire:model="descripcion" label="Descripción" rows="2"
                placeholder="Observaciones adicionales del vehículo..." />

        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary label="Registrar vehículo" wire:click="save" spinner="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
