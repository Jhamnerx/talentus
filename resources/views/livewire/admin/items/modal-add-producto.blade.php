<div>
    <x-form.modal.card title="NUEVO ITEM" wire:model.live="showModal" width="2xl" blur>
        <div class="grid grid-cols-12 gap-4">
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
                    <span class="font-semibold text-sm dark:text-gray-200">Información del anticipo</span>
                </div>

                {{-- DATOS DE DE COMPROBANTE --}}
                <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">
                    <label for="product_selected_id" class="dark:text-gray-300">{{ Str::ucfirst($comprobante_slug) }} de
                        Venta:</label> <br>
                    <label for="sr" class="dark:text-gray-300">Serie - Nro.</label>
                </div>

                <div class="col-span-4 md:col-span-2">

                    <x-form.input id="serie_ref" errorless='false' placeholder="F001" name="serie_ref"
                        wire:model.live="prepayments.serie_ref" maxlength="4" />
                </div>

                <div class="col-span-4 md:col-span-3">

                    <x-form.input id="correlativo_ref" errorless='false' placeholder="1" name="correlativo_ref"
                        wire:model.live.change="prepayments.correlativo_ref" />
                </div>

                <div class="col-span-12 md:col-span-9 md:col-start-2">
                    <x-form.errors only="prepayments.serie_ref|prepayments.correlativo_ref" />
                </div>

                {{-- FECHA DE COMPROBANTE --}}
                <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">
                    <label for="fecha_emision_ref" class="dark:text-gray-300">Fecha de Emisión:</label>
                </div>

                <div class="col-span-12 md:col-start-5 md:col-span-4">
                    <x-form.datetime.picker id="fecha_emision_ref" name="fecha_emision_ref"
                        wire:model.live="prepayments.fecha_emision_ref" :min="now()->subDays(1)" :max="now()" without-time
                        parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                </div>

                {{-- VALOR UNITARIO --}}
                <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                    <label for="total_invoice_ref" class="dark:text-gray-300">Importe total
                        {{ Str::ucfirst($comprobante_slug) }} de Venta:</label>
                </div>

                <div class="col-span-12 md:col-start-5 md:col-span-4">

                    <x-form.currency prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" id="total_invoice_ref"
                        name="total_invoice_ref" wire:model.live="prepayments.total_invoice_ref" precision="2"
                        disabled />
                </div>
            @else
                <div class="col-span-12 md:col-start-2 md:col-end-5 mt-2 text-sm">
                    <label for="product_selected_id" class="dark:text-gray-300">Producto:</label>
                </div>

                <div class="col-span-12 md:col-span-7 mt-2">

                    <x-form.select autocomplete="off" :clearable="false" wire:model.live="product_selected_id"
                        id="product_selected_id" name="product_selected_id"
                        placeholder="Seleccionar producto o servicio" :async-data="[
                            'api' => route('api.productos.index'),
                        ]" option-label="descripcion"
                        option-value="id" option-description="option_description" :template="[
                            'name' => 'user-option',
                            'config' => ['src' => 'imagen'],
                        ]" :always-fetch="true">
                    </x-form.select>

                </div>

                <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">
                    <label for="codigo" class="dark:text-gray-300">Código:</label>
                </div>

                <div class="col-span-12 md:col-start-5 md:col-span-4">

                    <x-form.input id="codigo" name="codigo" wire:model.live="selected.codigo"
                        placeholder="COD-PROD13" />

                </div>

                <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                    <label for="cantidad" class="dark:text-gray-300">Cantidad:</label>

                </div>

                <div class="col-span-12 md:col-start-5 md:col-span-4">

                    <x-form.number id="cantidad" name="cantidad" wire:model.live="selected.cantidad" min="1"
                        step="1" />

                </div>

                <div class="col-start-5 col-span-6 md:col-start-9 md:col-end-12 text-sm">

                    <span x-text="$wire.selected.unit_name"
                        class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 ring-1 ring-inset ring-gray-500/10 dark:ring-gray-400/20">
                        UNIDAD
                    </span>

                </div>
            @endif


            @if ($anticipo)
                <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                    <label for="prepayments_descripcion" class="dark:text-gray-300">Descripción:</label>

                </div>

                <div class="col-span-12 md:col-start-5 md:col-end-11">

                    <x-form.textarea name="prepayments_descripcion" id="prepayments_descripcion"
                        wire:model.live="prepayments.descripcion" />

                </div>

                <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                    <label for="valor_venta_ref" class="dark:text-gray-300">Anticipo a Valor de Venta:</label>
                </div>

                <div class="col-span-12 md:col-start-5 md:col-span-4">

                    <x-form.currency id="valor_venta_ref" name="valor_venta_ref"
                        prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live="prepayments.valor_venta_ref"
                        precision="4" />

                </div>
            @else
                <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                    <label for="descripcion" class="dark:text-gray-300">Descripción:</label>

                </div>

                <div class="col-span-12 md:col-start-5 md:col-end-11">

                    <x-form.textarea name="descripcion" id="descripcion" wire:model.live="selected.descripcion" />

                </div>

                {{-- SELECTOR DE PLAN (visible solo si el producto tiene planes asociados) --}}
                @if ($planesDisponibles->isNotEmpty())
                    <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">
                        <label class="dark:text-gray-300 font-medium text-blue-600 dark:text-blue-400">
                            Plan de servicio:
                        </label>
                    </div>

                    <div class="col-span-12 md:col-start-5 md:col-end-11">
                        <x-form.select wire:model.live="plan_id" placeholder="Sin plan (opcional)" :options="$planesDisponibles
                            ->map(
                                fn($p) => [
                                    'id' => $p->id,
                                    'label' =>
                                        (is_array($p->name) ? $p->name['es'] ?? reset($p->name) : $p->name) .
                                        ' — ' .
                                        number_format((float) $p->price, 2) .
                                        ' ' .
                                        ($p->currency ?? 'PEN'),
                                ],
                            )
                            ->toArray()"
                            option-label="label" option-value="id" />
                    </div>

                    {{-- LISTA DE FEATURES DEL PLAN SELECCIONADO --}}
                    @if (!empty($planFeatures))
                        <div class="col-span-12 md:col-start-5 md:col-end-11">
                            <div
                                class="bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700 p-3">
                                <p
                                    class="text-xs font-semibold text-blue-700 dark:text-blue-300 mb-2 uppercase tracking-wide">
                                    Características incluidas
                                </p>
                                <ul class="space-y-1">
                                    @foreach ($planFeatures as $feat)
                                        <li class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                            <svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-medium">{{ $feat['nombre'] }}</span>
                                            @if (!empty($feat['valor']))
                                                <span class="text-gray-500 dark:text-gray-400">—
                                                    {{ $feat['valor'] }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @endif

                <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                    <label for="valor_unitario" class="dark:text-gray-300">Valor Unitario:</label>
                </div>

                <div class="col-span-12 md:col-start-5 md:col-span-4">

                    <x-form.currency id="valor_unitario" name="valor_unitario"
                        prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live.blur="selected.valor_unitario"
                        precision="4" />

                </div>
            @endif


            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                <label for="igv" class="dark:text-gray-300">IGV:</label>
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

                <x-form.currency id="igv" name="igv" precision="4" placeholer="0.00" disabled
                    prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live="selected.igv" />
            </div>

            @if ($selected['afecto_icbper'])
                <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                    <label for="icbper" class="dark:text-gray-300">
                        ICBPER:
                    </label>
                </div>

                <div class="col-span-12 md:col-start-5 md:col-span-4">

                    <x-form.currency id="icbper" name="icbper" precision="4" placeholer="0.00" disabled
                        prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live="selected.icbper" />

                </div>

                <div class="col-span-12 md:col-start-9 md:col-span-4">

                    <x-form.currency id="total_icbper" name="total_icbper" precision="4" placeholer="0.00" disabled
                        prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live="selected.total_icbper" />

                </div>
            @endif

            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                <label for="total" class="dark:text-gray-300">
                    Importe Total del Item: {{ $tipo_comprobante_id }}
                </label>
            </div>

            <div class="col-span-12 md:col-start-5 md:col-span-4">


                <x-form.currency id="total" name="total" precision="4" placeholer="0.00"
                    prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}" wire:model.live.blur="selected.total" />


            </div>

            @if (app()->environment('local'))
                <div class="col-span-12 md:col-start-5 md:col-span-4">
                    {{ json_encode($selected) }}

                </div>
            @endif
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cancelar" wire:click="$set('showModal', false)" />
                <x-form.button primary label="Agregar" wire:click="addProducto" />
            </div>
        </x-slot>

    </x-form.modal.card>
</div>

@push('scripts')
@endpush
