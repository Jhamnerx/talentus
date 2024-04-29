<x-admin.facturacion.form-modal-w-buttons titulo="NUEVO ITEM" wire:model.live="showModal" maxWidth="2xl">
    {{-- <div class="col-span-12 md:col-start-2">
        <span class="font-semibold text-sm">{{ $divisa }}</span>
        <span class="font-semibold text-sm">{{ $tipo_comprobante_id }}</span>
    </div> --}}
    @if ($deduce_anticipos)
        <div class="col-span-12 md:col-start-2 mt-2">
            <x-form.checkbox left-label="Anticipo" id="is_anticipo_p" name="is_anticipo_p" value="true" lg
                wire:model.live="anticipo" />
        </div>
    @endif

    @if ($anticipo)
        <div class="col-span-12 md:col-start-2">
            <span class="font-semibold text-sm">Información del anticipo</span>
        </div>

        {{-- DATOS DE DE COMPROBANTE --}}
        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">
            <label for="product_selected_id">{{ Str::ucfirst($comprobante_slug) }} de Venta:</label> <br>
            <label for="sr">Serie - Nro.</label>
        </div>

        <div class="col-span-4 md:col-span-2">

            <x-form.input id="serie_ref" errorless='false' placeholder="F001" name="serie_ref"
                wire:model.live="prepayments.serie_ref" maxlength="4" />
        </div>

        <div class="col-span-4 md:col-span-3">

            <x-form.input id="correlativo_ref" errorless='false' placeholder="1" name="correlativo_ref"
                wire:model.change="prepayments.correlativo_ref" />
        </div>

        <div class="col-span-12 md:col-start-2 md:col-end-7 text-sm">
            <x-form.errors only="prepayments.serie_ref|prepayments.correlativo_ref" />
        </div>

        {{-- FECHA DE COMPROBANTE --}}
        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">
            <label for="fecha_emision_ref">Fecha de Emisión:</label>
        </div>

        <div class="col-span-12 md:col-start-5 md:col-span-4">
            <x-form.datetime-picker id="fecha_emision_ref" name="fecha_emision_ref"
                wire:model.live="prepayments.fecha_emision_ref" :min="now()->subDays(1)" :max="now()" without-time
                parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
        </div>

        {{-- VALOR UNITARIO --}}
        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

            <label for="total_invoice_ref">Importe total {{ Str::ucfirst($comprobante_slug) }} de Venta:</label>
        </div>

        <div class="col-span-12 md:col-start-5 md:col-span-4">

            <x-form.inputs.currency prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" id="total_invoice_ref"
                name="total_invoice_ref" wire:model.live="prepayments.total_invoice_ref" precision="2" disabled />
        </div>
    @else
        <div class="col-span-12 md:col-start-2 md:col-end-5 mt-2 text-sm">
            <label for="product_selected_id">Producto:</label>
        </div>

        <div class="col-span-12 md:col-span-7 mt-2">

            <x-form.select autocomplete="off" :clearable="false" wire:model.live="product_selected_id"
                id="product_selected_id" name="product_selected_id" placeholder="Seleccionar producto o servicio"
                :async-data="[
                    'api' => route('api.productos.index'),
                ]" option-label="descripcion" option-value="id" option-description="option_description"
                :template="[
                    'name' => 'user-option',
                    'config' => ['src' => 'imagen'],
                ]" :always-fetch="true">
            </x-form.select>

        </div>

        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">
            <label for="codigo">Código:</label>
        </div>

        <div class="col-span-12 md:col-start-5 md:col-span-4">

            <x-form.input id="codigo" name="codigo" wire:model.live="selected.codigo" placeholder="COD-PROD13" />

        </div>

        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

            <label for="cantidad">Cantidad:</label>

        </div>

        <div class="col-span-12 md:col-start-5 md:col-span-4">

            <x-form.inputs.number id="cantidad" name="cantidad" wire:model.live="selected.cantidad" min="1"
                step="1" />

        </div>

        <div class="col-start-5 col-span-6 md:col-start-9 md:col-end-12 text-sm">

            <span x-text="$wire.selected.unit_name"
                class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                UNIDAD
            </span>

        </div>
    @endif


    @if ($anticipo)
        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

            <label for="prepayments_descripcion">Descripción:</label>

        </div>

        <div class="col-span-12 md:col-start-5 md:col-end-11">

            <x-form.textarea name="prepayments_descripcion" id="prepayments_descripcion"
                wire:model.live="prepayments.descripcion" />

        </div>

        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

            <label for="valor_venta_ref">Anticipo a Valor de Venta:</label>
        </div>

        <div class="col-span-12 md:col-start-5 md:col-span-4">

            <x-form.inputs.currency id="valor_venta_ref" name="valor_venta_ref"
                prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live="prepayments.valor_venta_ref"
                precision="4" />

        </div>
    @else
        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

            <label for="descripcion">Descripción:</label>

        </div>

        <div class="col-span-12 md:col-start-5 md:col-end-11">

            <x-form.textarea name="descripcion" id="descripcion" wire:model.live="selected.descripcion" />

        </div>

        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

            <label for="valor_unitario">Valor Unitario:</label>
        </div>

        <div class="col-span-12 md:col-start-5 md:col-span-4">

            <x-form.inputs.currency id="valor_unitario" name="valor_unitario"
                prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live="selected.valor_unitario"
                precision="4" />

        </div>
    @endif


    <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

        <label for="igv">IGV:</label>
    </div>

    <div class="col-span-4 md:col-span-2">

        <x-form.radio id="gravado" name="gravado" value="10" wire:model.live="tipo_afectacion"
            label="Gravado" />
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

        <x-form.inputs.currency id="igv" name="igv" precision="4" placeholer="0.00" disabled
            prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live="selected.igv" />
    </div>

    @if ($selected['afecto_icbper'])
        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

            <label for="icbper">
                ICBPER:
            </label>
        </div>

        <div class="col-span-12 md:col-start-5 md:col-span-4">

            <x-form.inputs.currency id="icbper" name="icbper" precision="4" placeholer="0.00" disabled
                prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live="selected.icbper" />

        </div>

        <div class="col-span-12 md:col-start-9 md:col-span-4">

            <x-form.inputs.currency id="total_icbper" name="total_icbper" precision="4" placeholer="0.00" disabled
                prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live="selected.total_icbper" />

        </div>
    @endif

    <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

        <label for="total">
            Importe Total del Item:
        </label>
    </div>

    <div class="col-span-12 md:col-start-5 md:col-span-4">

        <x-form.inputs.currency id="total" name="total" precision="4" placeholer="0.00"
            prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live="selected.total" disabled />

    </div>
    {{-- <div class="col-span-12 md:col-start-5 md:col-span-4">
        {{ json_encode($selected) }}

    </div> --}}

</x-admin.facturacion.form-modal-w-buttons>

@push('scripts')
@endpush
