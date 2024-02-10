<x-form.modal.card title="CREAR FLOTA" blur wire:model.live="modalOpen" sm align="center">

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">

            <x-form.input wire:model.live="nombre" label="Nombre:" placeholder="Escribe el nombre" />

        </div>
        <div class="col-span-12">

            <x-form.select label="Selecciona un cliente:" wire:model.live="clientes_id"
                placeholder="Selecciona un cliente" option-description="numero_documento" :async-data="route('api.clientes.index')"
                option-label="razon_social" option-value="id" hide-empty-message>

                <x-slot name="afterOptions" class="p-2 flex justify-center" x-show="displayOptions.length === 0">
                    <x-form.button wire:click.prevent="OpenModalCliente(`${search}`)" x-on:click="close" primary flat
                        full>
                        <span x-html="`Crear cliente <b>${search}</b>`"></span>
                    </x-form.button>
                </x-slot>
            </x-form.select>

        </div>
        <div class="col-span-12">

            <x-form.textarea wire:model.live="descripcion" label="Descripcion:" placeholder="Escribe la descripción" />

        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

@push('scripts')
@endpush
