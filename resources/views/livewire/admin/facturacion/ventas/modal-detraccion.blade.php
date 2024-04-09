<x-form.modal.card title="Información de Detracción" max-width='lg' wire:model.live="openModalDetraccion" align="center">

    <div class="grid grid-cols-12 gap-6 text-sm">

        <div class="col-span-12">

            <span>La información de detraccion siempre se registrará en moneda nacional "SOL" independiente de la moneda
                del comprobante.</span>
        </div>

        <div class="col-span-12">

            <x-form.select autocomplete="off" id="codigo_detraccion" name="codigo_detraccion"
                label="código de bien/servicio sujeto a detracción*:" wire:model.live="codigo_detraccion"
                placeholder="Selecciona" :async-data="[
                    'api' => route('api.detracciones.index'),
                ]" option-label="descripcion" option-value="codigo" />

        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.input wire:model.live="cuenta_bancaria" label="Nro. Cta. Banco de la Nación:" placeholder="" />

        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.select autocomplete="off" id="metodo_pago_id" name="metodo_pago_id" label="Medio de pago:"
                wire:model.live="metodo_pago_id" placeholder="Selecciona" :async-data="[
                    'api' => route('api.metodos.pago.index'),
                ]" option-label="descripcion"
                option-value="codigo" />
        </div>

        <div class="col-span-12 sm:col-span-6">

            <x-form.input wire:model.live="porcentaje" label="Porcentaje de detracción:" placeholder="12" />

        </div>

        <div class="col-span-12 sm:col-span-6">

            <x-form.input wire:model.live="monto" label="Monto de detracción:" placeholder="0.00" />

        </div>

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" wire:click='closeModal' />
                <x-form.button primary label="Guardar" wire:click="setDatos" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
