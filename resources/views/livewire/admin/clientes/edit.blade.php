<x-form.modal.card title="EDITAR CLIENTE" max-width="2xl" wire:model.live="modalEdit" align="center">

    <div class="grid grid-cols-12 gap-4">

        <div class="col-span-12 sm:col-span-6">
            <x-form.select label="Seleccion tipo Doc.:" wire:model.live="tipo_documento_id"
                placeholder="Selecciona un cliente" option-description="codigo" :async-data="route('api.documentos.index')"
                option-label="descripcion" option-value="codigo" />
        </div>

        <div class="col-span-12 sm:col-span-6">
            <x-form.input label="Número Documento:" placeholder="10203040" wire:model='numero_documento'>
                @if (in_array($tipo_documento_id, [1, 6]))
                    <x-slot name="append">
                        <x-form.button class="h-full" icon="magnifying-glass" rounded="rounded-r-md" primary flat
                            spinner="buscarDocumento" wire:click="buscarDocumento" wire:loading.attr="disabled" />
                    </x-slot>
                @endif
            </x-form.input>
            @if ($errorConsulta)
                <p class="mt-1 text-sm text-red-600">{{ $errorConsulta }}</p>
            @endif
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

        <div class="col-span-12 sm:col-span-6">
            <x-form.select id="ubigeo" name="ubigeo" label="Ubigeo:" wire:model.live="ubigeo"
                placeholder="Buscar departamento / provincia / distrito" :async-data="[
                    'api' => route('api.ubigeos.index'),
                ]"
                option-label="option_description" option-value="ubigeo_inei" />
        </div>

        <div class="col-span-12 sm:col-span-6">
            <x-form.select
                label="Rubro de cliente"
                wire:model.live="rubro_id"
                placeholder="Sin rubro"
                :options="$rubros->map(fn($r) => ['value' => $r->id, 'label' => $r->nombre])->toArray()"
                option-label="label"
                option-value="value"
            />
        </div>

        <div class="col-span-12 sm:col-span-6">
            <x-form.select
                label="Sector del cliente"
                wire:model.live="sector_id"
                placeholder="Sin sector"
                :options="$sectores->map(fn($s) => ['value' => $s->id, 'label' => $s->nombre])->toArray()"
                option-label="label"
                option-value="value"
            />
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
