<x-form.modal.card title="EDITAR CONTACTO" max-width="3xl" blur wire:model.live="modalEdit" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-6">

            <x-form.input wire:model.live='nombre' label="Nombre:" placeholder="Escribe el nombre" />

        </div>

        <div class="col-span-12 sm:col-span-6">

            <x-form.select label="Selecciona un cliente:" wire:model.live="clientes_id"
                placeholder="Selecciona un cliente" option-description="numero_documento" :async-data="route('api.clientes.index')"
                option-label="razon_social" option-value="id">

                <x-slot name="afterOptions" class="p-2 flex justify-center" x-show="displayOptions.length === 0">
                    <x-form.button wire:click.prevent="OpenModalCliente(`${search}`)" x-on:click="close" primary flat
                        full>
                        <span x-html="`Crear cliente <b>${search}</b>`"></span>
                    </x-form.button>
                </x-slot>

            </x-form.select>
        </div>

        <div class="col-span-12 sm:col-span-4">

            <x-form.input type="tel" wire:model.live='numero_documento' label="DNI:" placeholder="10203040" />

        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.input label="Cargo:" placeholder="GERENTE" wire:model.live='cargo' />

        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.input icon="phone" type="tel" label="Telefono:" placeholder="987654321"
                wire:model.live='telefono' />
        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.input label="Correo:" placeholder="clientes@correo.com" wire:model.live='email' />
        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.datetime-picker label="Fecha. Nacimiento:" id="birthday" name="birthday" wire:model.live="birthday"
                without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
        </div>


        <div class="col-span-12 sm:col-span-12 mt-4">
            <span class="text-bold text-center mb-2">Opciones Adicionales:</span>
            <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">

                <div class="m-2 w-full mt-2">

                    <x-form.toggle left-label="Es Gerente?" wire:model.live="is_gerente" value="1" />
                </div>

            </div>
        </div>
        <div class="col-span-12">

            <x-form.textarea wire:model.live="descripcion" label="Descripción:" />
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
