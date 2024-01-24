<div>
    <div
        class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
        <!-- Add customer button -->
        <a href="{{ route('admin.ventas.index') }}">
            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back w-5 h-5"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                </svg>
                <span class="hidden xs:block ml-2">Atras</span>
            </button>
        </a>
        <div class="mt-2 md:mt-0">
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-200">EMITIR
                {{ strtoupper($comprobante_slug == 'nota-venta' ? 'NOTA DE VENTA' : str_replace('-', ' ', $comprobante_slug)) }}
            </h4>
            <ul aria-label="current Status"
                class="flex flex-col md:flex-row items-start md:items-center text-gray-600 dark:text-gray-400 text-sm mt-3">
            </ul>
        </div>
    </div>
    <!-- Code block ends -->
    <div class="p-6 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 sm:p-6">
            <div class="grid grid-cols-12 gap-2">

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-0 md:pr-4 gap-2">

                    {{-- SERIE --}}
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-form.select always-fetch="true" id="serie" name="serie" label="Serie:"
                            wire:model.live="serie" placeholder="Selecciona una serie" :async-data="[
                                'api' => route('api.series.index'),
                                'params' => ['tipo_comprobante' => $tipo_comprobante_id],
                            ]"
                            option-label="serie" option-value="serie" hide-empty-message />
                    </div>

                    {{-- CORRELATIVO --}}
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">

                        <x-form.inputs.number readonly name="correlativo" wire:model.live="correlativo"
                            label="Correlativo:" />

                    </div>

                    {{-- FECHA EMISION --}}
                    <div class="col-span-12 sm:col-span-6 lg:col-span-5 gap-2">
                        <div class="col-span-12 md:col-span-6">

                            <x-form.datetime-picker label="Fecha de Emision:" wire:model.live="fecha_emision"
                                :min="now()->subDays(1)" :max="now()" without-time parse-format="YYYY-MM-DD"
                                display-format="DD-MM-YYYY" :clearable="false" />

                        </div>
                    </div>

                    {{-- MOTIVO --}}
                    <div class="col-span-12 sm:col-span-8 md:col-span-8 lg:col-span-6">
                        <x-form.select always-fetch="true" id="sustento_id" name="sustento_id"
                            label="Tipo de {{ ucwords(str_replace('-', ' de ', $comprobante_slug)) }}:"
                            wire:model.live="sustento_id" placeholder="Selecciona el tipo" :async-data="[
                                'api' => route('api.sustentos.index'),
                                'params' => ['tipo_comprobante' => $tipo_comprobante_id],
                            ]"
                            option-label="descripcion" option-value="codigo" hide-empty-message />
                    </div>
                    {{-- sustento escrito --}}

                    @if ($sustento_id == '02' && $tipo_comprobante_id == '07')
                        {{-- INVOICE NEW --}}
                        <div
                            class="col-span-12 md:col-span-6  {{ $invoice_id_new ? 'lg:col-span-4' : 'lg:col-span-6' }}  mb-3">
                            <x-form.select autocomplete="off" id="invoice_id_new" name="invoice_id_new"
                                label="Nueva {{ $titulo_select_new }} Electrónica" wire:model.live="invoice_id_new"
                                placeholder="Ingrese serie y número" :async-data="[
                                    'api' => route('api.invoices.index'),
                                    'params' => ['tipo_comprobante_ref' => $tipo_comprobante_ref, 'code_sunat' => '0'],
                                ]" option-label="serie_correlativo"
                                :template="[
                                    'name' => 'user-option',
                                    'config' => ['src' => 'imagen'],
                                ]" :always-fetch="true" option-value="id"
                                option-description="option_description" hide-empty-message />
                        </div>

                        @if ($invoice_id_new)
                            <div class="col-span-12 md:col-span-6 lg:col-span-2 mt-0 md:mt-7">
                                <x-form.button wire:click.prevent="verIframe()" label="Ver" outline emerald xs
                                    icon="document-search" />
                            </div>
                        @endif
                    @else
                        <div class="col-span-12 ">

                            <x-form.textarea rows="1" wire:model.live='sustento_texto'
                                label="Motivo o sustento por el cual se emitirá la {{ ucwords(str_replace('-', ' de ', $comprobante_slug)) }}" />

                        </div>
                    @endif

                </div>

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-red-600 lg:pl-6 mb-2 gap-2">

                    {{-- TIPO --}}
                    <div class="col-span-12 md:col-span-6 lg:col-span-4 mb-3">

                        <x-form.select label="Documento a modificar:" :options="[['name' => 'FACTURA', 'id' => '01'], ['name' => 'BOLETA', 'id' => '03']]" option-label="name"
                            option-value="id" wire:model.live="tipo_comprobante_ref" :clearable="false"
                            x-on:selected="$wire.selectTypeInvoice()" />
                    </div>

                    {{-- INVOICE --}}
                    <div
                        class="col-span-12 {{ $invoice_id ? 'md:col-span-6 lg:col-span-6' : 'md:col-span-6 lg:col-span-6' }}  mb-3">

                        <x-form.select autocomplete="off" id="invoice_id" name="invoice_id"
                            label="Selecciona un comprobante" wire:model.live="invoice_id"
                            placeholder="Ingrese serie y número" :async-data="[
                                'api' => route('api.invoices.index'),
                                'params' => ['tipo_comprobante_ref' => $tipo_comprobante_ref],
                            ]" option-label="serie_correlativo"
                            :template="[
                                'name' => 'user-option',
                                'config' => ['src' => 'imagen'],
                            ]" :always-fetch="true" option-value="id"
                            option-description="option_description" empty-message="No se encuentran comprobantes"
                            x-on:clear="$wire.direccion = ''" x-on:selected="$wire.selectInvoice()" />
                    </div>

                    @if ($invoice_id)
                        <div class="col-span-12 md:col-span-6 lg:col-span-2 mt-0 md:mt-7">
                            <x-form.button wire:click.prevent="verIframe()" label="Ver" outline emerald xs
                                icon="document-search" />
                        </div>
                    @endif

                    {{-- MONEDA --}}
                    <div class="col-span-12 md:col-span-6">
                        <x-form.select readonly label="Divisa:" :options="[['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]" option-label="name" option-value="id"
                            wire:model.live="invoice_divisa" :clearable="false" icon='currency-dollar' />
                    </div>

                    {{-- FECHA EMISION --}}
                    <div class="col-span-12 md:col-span-6 gap-2">

                        <x-form.datetime-picker readonly label="Fecha de Emision:"
                            wire:model.live="invoice_fecha_emision" :min="now()->subDays(1)" :max="now()" without-time
                            parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                    </div>

                    {{-- FECHA --}}
                    <div class="col-span-12 md:col-span-6 gap-2">
                        <x-form.datetime-picker readonly label="Fecha Vencimiento:"
                            wire:model.live="invoice_fecha_vencimiento" :min="now()->subDays(1)" :max="now()->addDays(7)"
                            without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                    </div>

                    {{-- TIPO DE VENTA --}}
                    @if ($tipo_comprobante_ref == '01')
                        <div class="col-span-12 md:col-span-6 mb-3">

                            <x-form.select readonly label="Forma Pago:" :options="[
                                ['name' => 'CONTADO', 'id' => 'CONTADO'],
                                ['name' => 'CREDITO', 'id' => 'CREDITO'],
                            ]" option-label="name"
                                option-value="id" wire:model.live="invoice_forma_pago" :clearable="false" />

                        </div>
                    @endif



                </div>

                <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3">

                    {{-- LISTA DE PRODUCTOS --}}
                    <x-admin.facturacion.tabla-detalle :items="$items">

                    </x-admin.facturacion.tabla-detalle>


                    <div class="block md:flex gap-2">
                        {{-- LADO IZQUIERDO --}}
                        <div class="grid grid-cols-12 gap-4 w-full px-4 mx-4 py-2 ml-auto mt-5">

                            {{-- TIPO DESCUENTO --}}
                            <div class="col-span-12 border-b border-cyan-600">
                                <h4 class="font-semibold">DESCUENTO</h4>
                            </div>

                            <div class="col-span-12 md:col-span-12">

                                <div class="flex flex-wrap gap-4">
                                    <div class="mt-2 flex gap-5">
                                        <x-form.radio value="cantidad" id="left-label" md left-label="S/"
                                            wire:model.live="invoice_tipo_descuento" />
                                    </div>


                                    <x-form.inputs.currency readonly icon="currency-dollar"
                                        placeholder="Monto descuento" wire:model.live.lazy="invoice_descuento_monto"
                                        thousands="." decimal="." precision="2" />


                                </div>

                            </div>

                            {{-- FORMA DE PAGO --}}
                            <div class="col-span-12 md:col-span-6">

                                <x-form.select readonly label="MÉTODO DE PAGO:" :options="[
                                    ['name' => 'En efectivo', 'id' => '009'],
                                    ['name' => 'Depósito en cuenta', 'id' => '001'],
                                    ['name' => 'Tarjeta de débito', 'id' => '005'],
                                    ['name' => 'Tarjeta de crédito', 'id' => '006'],
                                    ['name' => 'Transferencia bancaria', 'id' => '003'],
                                    ['name' => 'Giro', 'id' => '002'],
                                ]" option-label="name"
                                    option-value="id" wire:model.live="invoice_metodo_pago_id" :clearable="false" />

                            </div>

                            {{-- COMENTARIO --}}
                            <div class="col-span-12">

                                <x-form.textarea readonly label="Comentario:" placeholder="Escribe tu comentario" />
                            </div>

                        </div>

                        {{-- DIV PARA SUB Y TOTALES DERECHA --}}
                        <div class="py-2 ml-auto mt-5 w-full mx-4">
                            <div class="text-right mb-4 border-b">
                                <h4 class="font-semibold">RESUMEN</h4>
                            </div>

                            <div class="flex justify-between ">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">SUB TOTAL
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">
                                        {{ $simbolo }} <span>{{ round($invoice_sub_total, 4) }}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="flex justify-between mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">OP. GRAVADAS
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">
                                        {{ $simbolo }} <span>{{ round($invoice_op_gravadas, 4) }}</span>
                                    </div>

                                </div>
                            </div>

                            @if ($invoice_op_exoneradas > 0)
                                <div class="flex justify-between mt-2">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">OP.
                                        EXONERADAS
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-gray-800 text-sm">
                                            {{ $simbolo }} <span>{{ round($invoice_op_exoneradas, 4) }}</span>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            @if ($invoice_op_inafectas > 0)
                                <div class="flex justify-between mt-2">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">OP.
                                        INAFECTAS
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-gray-800 text-sm">
                                            {{ $simbolo }} <span>{{ round($invoice_op_inafectas, 4) }}</span>
                                        </div>

                                    </div>
                                </div>
                            @endif
                            @if ($invoice_op_gratuitas > 0)
                                <div class="flex justify-between mt-2">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">OP.
                                        GRATUITAS
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-gray-800 text-sm">
                                            {{ $simbolo }} <span>{{ round($invoice_op_gratuitas, 4) }}</span>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            <div class="flex justify-between mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">DESCUENTO
                                    (-)
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">
                                        {{ $simbolo }} <span>{{ round($invoice_descuento, 2) }}</span>
                                    </div>

                                </div>
                            </div>


                            <div class="flex justify-between mb-4 mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm">IGV(18%)</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">{{ $simbolo }}
                                        <span>{{ round($invoice_igv, 4) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between mb-4 mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm">ICBPER</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">{{ $simbolo }}
                                        <span>{{ number_format($invoice_icbper, 2) }}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="py-2 border-t border-b border-indigo-500">
                                <div class="flex justify-between">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm">Importe Total
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-xl text-gray-800 font-bold">
                                            {{ $simbolo }}<span>{{ round($invoice_total, 4) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
            {{ json_encode($errors->all()) }}
            <div class="px-4 py-3 text-right sm:px-6 sticky my-2 bg-white border-b border-slate-200">

                <div class="grid sm:grid-cols-2 gap-2 content-end">

                    <div class="text-right col-span-2 ">

                        <x-form.button wire:click.prevent="save" spinner="save"
                            label="EMITIR {{ strtoupper($comprobante_slug == 'nota-venta' ? 'NOTA DE VENTA' : str_replace('-', ' DE ', $comprobante_slug)) }}"
                            black md icon="shopping-cart" />
                    </div>
                </div>
            </div>



        </div>

    </div>

</div>
@section('js')
@endsection
