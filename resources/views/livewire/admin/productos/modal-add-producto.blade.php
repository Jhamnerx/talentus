<x-admin.facturacion.form-modal-w-buttons titulo="NUEVO ITEM" wire:model.live="showModal" maxWidth="2xl">
    <div class="col-span-12 md:col-start-2 md:col-end-5">
        <label for="product_selected_id">Producto:</label>
    </div>

    <div class="col-span-12 md:col-span-7">

        <x-form.select :clearable="false" wire:model.live="product_selected_id" id="productos" name="productos"
            placeholder="Seleccionar producto o servicio" :async-data="[
                'api' => route('api.productos.index'),
            ]" option-label="descripcion" option-value="id"
            option-description="option_description" :template="[
                'name' => 'user-option',
                'config' => ['src' => 'imagen'],
            ]" :always-fetch="true" x-on:selected="$wire.prueba()">

        </x-form.select>

    </div>

    <div class="col-span-12 md:col-start-2 md:col-end-5">
        <label for="codigo">Código:</label>
    </div>

    <div class="col-span-12 md:col-start-5 md:col-span-4">

        <x-form.input wire:model.live="selected.codigo" placeholder="COD-PROD13" />

    </div>

    <div class="col-span-12 md:col-start-2 md:col-end-5">

        <label for="cantidad">Cantidad:</label>

    </div>


    <div class="col-span-12 md:col-start-5 md:col-span-4">

        <x-form.inputs.number name="cantidad" wire:model.live="selected.cantidad" min="1" step="1" />

    </div>

    <div class="col-start-5 col-span-6 md:col-start-9 md:col-end-12">

        <span x-text="$wire.selected.unit_name"
            class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
            UNIDAD
        </span>

    </div>

    <div class="col-span-12 md:col-start-2 md:col-end-5">

        <label for="descripcion">Descripción:</label>

    </div>

    <div class="col-span-12 md:col-start-5 md:col-end-11">

        <x-form.textarea wire:model.live="selected.descripcion" />

    </div>

    <div class="col-span-12 md:col-start-2 md:col-end-5">

        <label for="valor_unitario">Valor Unitario:</label>
    </div>


    <div class="col-span-12 md:col-start-5 md:col-span-4">

        <x-form.inputs.currency prefix="{{ $divisa = 'PEN' ? 'S/ ' : 'US$ ' }}"
            wire:model.live="selected.valor_unitario" />

    </div>

    <div class="col-span-12 md:col-start-2 md:col-end-5">

        <label for="igv">IGV:</label>
    </div>

    <div class="col-span-4 md:col-span-2">

        <x-form.radio id="gravado" name="gravado" value="10" wire:model.live="tipo_afectacion" label="Gravado" />
    </div>
    <div class="col-span-4 md:col-span-2">

        <x-form.radio id="exonerado" name="exonerado" value="20" wire:model.live="tipo_afectacion"
            label="Exonerado" />
    </div>
    <div class="col-span-4 md:col-span-2">

        <x-form.radio id="inafecto" name="inafecto" value="30" wire:model.live="tipo_afectacion"
            label="Inafecto" />
    </div>
    <div class="col-start-3 col-span-6 md:col-start-5 md:col-span-3">

        <x-form.inputs.currency precision="4" placeholer="0.00" disabled
            prefix="{{ $divisa = 'PEN' ? 'S/ ' : 'US$ ' }}" wire:model.live="selected.igv" />
    </div>

    @if ($selected['afecto_icbper'])
        <div class="col-span-12 md:col-start-2 md:col-end-5">

            <label for="icbper">
                ICBPER:
            </label>
        </div>

        <div class="col-span-12 md:col-start-5 md:col-span-4">

            <x-form.inputs.currency precision="4" placeholer="0.00" disabled
                prefix="{{ $divisa = 'PEN' ? 'S/ ' : 'US$ ' }}" wire:model.live="selected.icbper" />

        </div>

        <div class="col-span-12 md:col-start-9 md:col-span-4">

            <x-form.inputs.currency precision="4" placeholer="0.00" disabled
                prefix="{{ $divisa = 'PEN' ? 'S/ ' : 'US$ ' }}" wire:model.live="selected.total_icbper" />

        </div>
    @endif

    <div class="col-span-12 md:col-start-2 md:col-end-5">

        <label for="total">
            Importe Total del Item:
        </label>
    </div>

    <div class="col-span-12 md:col-start-5 md:col-span-4">

        <x-form.inputs.currency precision="4" placeholer="0.00" disabled
            prefix="{{ $divisa = 'PEN' ? 'S/ ' : 'US$ ' }}" wire:model.live="selected.total" />

    </div>
    <div class="col-span-12">
        {{ json_encode($selected) }}
    </div>

</x-admin.facturacion.form-modal-w-buttons>

@push('scripts')
@endpush
