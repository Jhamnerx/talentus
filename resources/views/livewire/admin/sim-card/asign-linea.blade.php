<x-form.modal.card title="ASIGNAR LINEA A SIM CARD" max-width="xl" blur wire:model.live="modalAsign" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-start-3 col-end-10 col-span-12">

            <x-form.select id="sim_card_id" name="sim_card_id" label="1. Ingrese código de nuevo chip:"
                wire:model.live="sim_card_id" placeholder="Selecciona un sim card" :async-data="[
                    'api' => route('api.sim.index'),
                ]"
                x-on:clear="$wire.clearSimCardId()" option-label="sim_card" option-value="id" />
        </div>

        <div class="col-start-3 col-end-10 col-span-12">

            <x-form.select id="lineas_id" name="lineas_id" label="2. Ingrese una línea:" wire:model.live="lineas_id"
                placeholder="Selecciona una linea" :async-data="[
                    'api' => route('api.lineas.index'),
                ]" x-on:clear="$wire.clearLineaId()"
                option-label="numero" option-value="id" />
        </div>


        <div class="col-start-3 col-end-10 col-span-12">

            <x-form.input label="3. Motivo de cambio" placeholder="Motivo de cambio" wire:model.live="motivo" />
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
