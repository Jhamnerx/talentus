<x-form.modal.card title="REGISTRAR CLIENTE" max-width="2xl" wire:model.live="modalSave" align="center">

    <div class="grid grid-cols-12 gap-4">

        <div class="col-span-12 sm:col-span-6">
            <x-form.select label="Seleccion tipo Doc.:" wire:model.live="tipo_documento_id"
                placeholder="Selecciona un cliente" option-description="codigo" :async-data="route('api.documentos.index')"
                option-label="descripcion" option-value="codigo" />
        </div>

        <div class="col-span-12 sm:col-span-6">
            <x-form.input label="Número Documento:" placeholder="10203040" wire:model.live='numero_documento' />
        </div>

        <div class="col-span-12">
            <x-form.input label="Razon Social:" placeholder="INGRESA LA RAZON SOCIAL" wire:model.live='razon_social' />
        </div>

        <div class="col-span-12 sm:col-span-6">
            <x-form.input type="tel" label="Telefono:" placeholder="987654321" wire:model.live='telefono' />
        </div>


        <div class="col-span-12 sm:col-span-6">
            <x-form.input type="email" label="Email:" placeholder="clientes@correo.com" wire:model.live='email' />
        </div>

        <div class="col-span-12">
            <x-form.input label="Dirección:" wire:model.live='direccion' placeholder='Ingresa una direccion' />
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
