<div>
    <div
        class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
        <!-- Add customer button -->
        <a href="{{ route('admin.ventas.recibos.index') }}">
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
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-200">CREAR RECIBO</h4>
            <ul aria-label="current Status"
                class="flex flex-col md:flex-row items-start md:items-center text-gray-600 dark:text-gray-400 text-sm mt-3">
                <li class="flex items-center mr-4">
                    <div class="mr-1">
                        <img class="dark:hidden"
                            src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_with_sub_text_and_border-svg1.svg"
                            alt="Active">
                        <img class="dark:block hidden"
                            src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_with_sub_text_and_border-svg1dark.svg"
                            alt="Active">
                    </div>
                    <span>Active</span>
                </li>

            </ul>
        </div>
    </div>
    {{ json_encode($errors->all()) }}
    <!-- Code block ends -->
    <div class="p-6 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 sm:p-6">

            <div class="grid grid-cols-12 gap-2">

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-0 md:pr-4 gap-2">

                    {{-- CLIENTE --}}
                    <div class="col-span-12 mb-2 selectCliente">

                        <x-form.select label="Selecciona un cliente:" wire:model.live="clientes_id"
                            placeholder="Selecciona un cliente" option-description="numero_documento" :async-data="route('api.clientes.index')"
                            option-label="razon_social" option-value="id">

                            <x-slot name="afterOptions" class="p-2 flex justify-center"
                                x-show="displayOptions.length === 0">
                                <x-form.button wire:click.prevent="OpenModalCliente(`${search}`)" x-on:click="close"
                                    primary flat full>
                                    <span x-html="`Crear cliente <b>${search}</b>`"></span>
                                </x-form.button>
                            </x-slot>
                        </x-form.select>

                    </div>

                    @if ($cliente)
                        <x-admin.ventas.cliente-selected :cliente="$cliente">
                        </x-admin.ventas.cliente-selected>
                    @endif


                    {{-- SERIE --}}
                    <div class="col-span-12 md:col-span-6 xl:col-span-4">

                        <x-form.select id="serie" name="serie" label="Serie:" wire:model.live="serie"
                            placeholder="Selecciona una serie" :async-data="[
                                'api' => route('api.series.index'),
                                'params' => ['tipo_comprobante' => '10'],
                            ]" option-label="serie"
                            option-value="serie" />
                    </div>

                    {{-- CORRELATIVO --}}
                    <div class="col-span-12 md:col-span-6 xl:col-span-4">

                        <x-form.number id="correlativo" name="numero" wire:model.live="numero"
                            label="Número Recibo:" />

                    </div>

                    {{-- FECHA --}}
                    <div class="col-span-12 xs:col-span-6 gap-2">

                        <x-form.datetime.picker label="Fecha de Emision:" id="fecha_emision" name="fecha_emision"
                            wire:model.live="fecha_emision" :min="now()->subDays(10)" :max="now()" without-time
                            parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                    </div>

                    {{-- FECHA PAGO --}}
                    <div class="col-span-12 xs:col-span-6 gap-2">

                        <x-form.datetime.picker label="Fecha de Pago:" id="fecha_pago" name="fecha_pago"
                            wire:model.live="fecha_pago" :min="now()->subDays(15)" :max="now()->addDays(30)" without-time
                            parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />

                    </div>

                </div>

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-red-600 lg:pl-6 mb-2 gap-2">
                    {{-- moneda --}}
                    <div class="col-span-12 md:col-span-6 mb-2">

                        <x-form.select label="Moneda:" id="divisa" name="divisa" :options="[['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]"
                            option-label="name" option-value="id" wire:model.live="divisa" :clearable="false"
                            icon='currency-dollar' />

                    </div>


                    <div class="col-span-12 md:col-span-6 mb-3">

                        <x-form.select id="tipo_venta" name="tipo_venta" label="Forma Pago:" :options="[['name' => 'CONTADO', 'id' => 'CONTADO'], ['name' => 'CREDITO', 'id' => 'CREDITO']]"
                            option-label="name" option-value="id" wire:model.live="tipo_venta" :clearable="false" />

                    </div>

                    {{-- FORMA DE PAGO --}}
                    <div class="col-span-12 md:col-span-6">

                        <x-form.select id="forma_pago" name="forma_pago" label="MÉTODO DE PAGO:" :options="[
                            ['name' => 'En efectivo', 'id' => '009'],
                            ['name' => 'Depósito en cuenta', 'id' => '001'],
                            ['name' => 'Tarjeta de débito', 'id' => '005'],
                            ['name' => 'Tarjeta de crédito', 'id' => '006'],
                            ['name' => 'Transferencia bancaria', 'id' => '003'],
                            ['name' => 'Giro', 'id' => '002'],
                        ]"
                            option-label="name" option-value="id" wire:model.live="forma_pago" :clearable="false" />

                    </div>


                    <div class="col-span-12">
                        <x-form.textarea label="Nota:" id="nota" name="nota" wire:model.live="nota"
                            placeholder="Ingresar nota opcional" />
                    </div>

                </div>


                <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3">

                    <div class="grid grid-cols-2 gap-2 mt-4 pt-4 pb-4 bg-white px-3 mb-2">
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex" wire:ignore>
                                <x-form.select :clearable="false" wire:model.live="product_selected_id"
                                    id="product_selected_id" name="product_selected_id"
                                    placeholder="Seleccionar producto o servicio" :async-data="[
                                        'api' => route('api.productos.index'),
                                    ]"
                                    option-label="descripcion" option-value="id"
                                    option-description="option_description" :template="[
                                        'name' => 'user-option',
                                        'config' => ['src' => 'imagen'],
                                    ]" :always-fetch="true">
                                    <x-slot name="beforeOptions" class="p-2 flex justify-center">
                                        <x-form.button wire:click.prevent='addProductoModal(`${search}`)'
                                            x-on:click="close" primary flat full>
                                            <span x-html="`Registrar Producto <b>${search}</b>`"></span>
                                        </x-form.button>
                                    </x-slot>
                                </x-form.select>
                            </div>
                        </div>

                        <div class="col-span-2 sm:col-span-1">

                        </div>
                    </div>

                    {{-- LISTA DE PRODUCTOS --}}

                    <x-admin.ventas.tabla-detalle-venta :items="$items" :selected="$selected">

                    </x-admin.ventas.tabla-detalle-venta>


                    <div class="flex">
                        {{-- DIV PARA SUB Y TOTALES --}}
                        <div class="py-2 ml-auto mt-5 w-full sm:w-2/4 lg:w-1/4 mr-2">

                            <div class="py-2 border-t border-b">
                                <div class="flex justify-between">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm">Monto Total
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-xl text-gray-800 font-bold">
                                            {{ $simbolo }}<span>{{ number_format($total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="px-4 py-3 text-right sm:px-6 sticky my-2 bg-white border-b border-slate-200 z-5">

                <div class="grid gap-2 content-end">

                    <div class="text-center md:text-right">

                        <x-form.button wire:click.prevent="save" spinner="save" label="CREAR RECIBO" black md
                            icon="shopping-cart" />
                    </div>

                </div>
            </div>



        </div>

    </div>

</div>
@section('js')
@endsection
