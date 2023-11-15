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
    <!-- Code block ends -->
    <div class="p-6 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 sm:p-6">

            <div class="grid grid-cols-12 gap-2">

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-0 md:pr-4 gap-2">

                    {{-- CLIENTE --}}
                    <div class="col-span-12 mb-2 selectCliente">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Cliente <span class="text-sm text-red-500"> * </span></div>
                        </label>
                        <div class="flex" wire:ignore>
                            <select name="clientes_id" id="" class="form-select w-full clientes_id pl-3"
                                required>
                            </select>

                            @livewire('admin.clientes.button-open-modal')

                        </div>

                        @error('clientes_id')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    @if ($cliente)
                        <x-admin.ventas.cliente-selected :cliente="$cliente">
                        </x-admin.ventas.cliente-selected>
                    @endif



                    {{-- NUMERO --}}
                    <div class="col-span-12 xs:col-span-6 mb-2">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Serie Recibo <span class="text-sm text-red-500"> * </span></div>
                        </label>
                        <div class="relative">

                            <input required readonly wire:model.live="serie" name="serie" id="serie"
                                class="form-input w-full" type="text" />

                        </div>
                        @error('serie_numero')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col-span-12 xs:col-span-6 mb-2">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Número Recibo <span class="text-sm text-red-500"> * </span></div>
                        </label>
                        <div class="relative">

                            <input required readonly wire:model.live="numero" name="numero" id="numero"
                                class="form-input w-full" type="text" />

                        </div>
                        @error('numero')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- FECHA --}}
                    <div class="col-span-12 xs:col-span-6 gap-2">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Fecha de Emisión: <span class="text-sm text-red-500"> * </span></div>

                        </label>
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input name="fecha_emision" wire:model.live="fecha_emision" type="text"
                                class="form-input  fechaEmision font-base pl-8 py-2 sm:text-sm w-full"
                                placeholder="Selecciona la fecha">
                        </div>
                        @error('fecha_emision')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- FECHA CADUCIDAD --}}
                    <div class="col-span-12 xs:col-span-6 gap-2">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Fecha de pago: <span class="text-sm text-red-500" style="display: none;"> *
                                </span>
                            </div>
                        </label>
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input name="fecha_pago" wire:model.live="fecha_pago" type="text"
                                class="form-input  fechaEmision font-base pl-8 py-2 sm:text-sm w-full"
                                placeholder="Selecciona la fecha">
                        </div>
                        @error('fecha_pago')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-red-600 lg:pl-6 mb-2 gap-2">
                    {{-- moneda --}}
                    <div class="col-span-12 md:col-span-6 mb-3">

                        <label class="text-gray-800 block text-sm font-medium mb-1" for="moneda">Moneda
                            <span class="text-rose-500">*</span> </label>

                        <select wire:model.live="divisa" name="divisa" id="moneda" class="form-select w-full divisa">
                            <option value="PEN">SOLES</option>
                            <option value="USD">DOLARES</option>
                        </select>


                        @error('divisa')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div class="col-span-12 md:col-span-6 mb-3">
                        <label class="text-gray-800 block text-sm font-medium mb-1" for="moneda">Forma de Pago
                            <span class="text-rose-500">*</span> </label>

                        <select wire:model.live="forma_pago" name="forma_pago" id="forma_pago"
                            class="form-select w-full">
                            @foreach ($payments_methods as $key => $method)
                                <option value="{{ $key }}"> {{ $method }}</option>
                            @endforeach
                        </select>


                        @error('divisa')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>
                    <div class="col-span-12">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Nota
                            </div>
                        </label>
                        <textarea class="form-input w-full px-4 py-3" name="nota" wire:model.live="nota" id="" cols="30"
                            rows="4" placeholder="Ingresar nota (opcional)"></textarea>
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Tipo de venta <span class="text-sm text-red-500"> * </span></div>
                        </label>
                        <div class="flex flex-wrap items-center -m-3 mt-1">

                            <div class="mx-3">
                                <label class="flex items-center hover:cursor-pointer">
                                    <input checked type="radio" wire:model.live="tipo_venta" name="tipo_venta"
                                        value="CONTADO" class="form-radio " />
                                    <span class="text-sm ml-2">CONTADO</span>
                                </label>
                            </div>
                            <div class="mx-3">
                                <label class="flex items-center hover:cursor-pointer">
                                    <input type="radio" wire:model.live="tipo_venta" name="tipo_venta" value="CREDITO"
                                        class="form-radio" />
                                    <span class="text-sm ml-2">CREDITO</span>
                                </label>
                            </div>

                        </div>

                        @error('tipo_venta')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3">

                    <div class="grid grid-cols-2 gap-2 mt-4 pt-4 pb-4 bg-white px-3 mb-2">
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex" wire:ignore>
                                <button id="productos-button"
                                    class="flex-shrink-0 z-10 hidden md:inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                                    type="button">
                                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                        <path
                                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                    </svg>
                                </button>
                                <label for="productos" class="sr-only">Añadir Artículo</label>
                                <select id="productos"
                                    class="bg-gray-50 productoSelect border border-gray-300 text-gray-900 text-sm rounded-l-lg md:rounded-none rounded-r-lg border-l-gray-100 dark:border-l-gray-700 border-l-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Añadir Artículo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-span-2 sm:col-span-1">

                        </div>
                    </div>

                    {{-- LISTA DE PRODUCTOS --}}
                    <x-admin.ventas.tabla-detalle-venta :items="$items">

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
            <div class="px-4 py-3 text-right sm:px-6">
                <button class="btn bg-emerald-500 hover:cursor-pointer hover:bg-emerald-600 text-white"
                    wire:click.prevent="save">Guardar</button>
            </div>



        </div>

    </div>

</div>
@section('js')
    <script>
        $(document).ready(function() {
            cont = 0;
            detalles = 0;
            flatpickr('.fechaEmision', {
                mode: 'single',
                minDate: "today",
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
            flatpickr('.fechaVencimiento', {
                mode: 'single',
                minDate: "today",
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
        })

        $('.clientes_id').select2({
            placeholder: 'Buscar Cliente',
            language: "es",
            minimumInputLength: 2,
            width: '100%',
            ajax: {
                url: '{{ route('search.clientes') }}',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {
                    var query = {
                        term: params.term,
                    }
                    return query;
                },
                processResults: function(data, params) {
                    var suggestions = $.map(data.suggestions, function(obj) {
                        obj.id = obj.id || obj.value;
                        obj.text = obj.data;
                        return obj;
                    });
                    return {
                        results: suggestions,
                    };
                },
            }
        });

        $('.clientes_id').on('select2:select', function(e) {
            @this.set('clientes_id', this.value)

        })

        $('.productoSelect').on('select2:select', function(e) {

            @this.call('selectProduct', this.value)

        });


        $('.productoSelect').select2({
            placeholder: 'Añadir Artículo',
            language: "es",
            width: '100%',
            ajax: {
                url: '{{ route('search.productos') }}',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {
                    var query = {
                        term: params.term,
                    }
                    return query;
                },
                processResults: function(data, params) {
                    var suggestions = $.map(data.suggestions, function(obj) {

                        obj.id = obj.id || obj.data;
                        obj.text = obj.value;

                        return obj;
                    });
                    return {
                        results: suggestions,
                    };

                },


            }
        });

        function addAlert() {
            iziToast.success({
                position: 'topRight',
                title: 'AGREGADO',
                message: 'Se añadio un producto al recibo',
            });
        }
    </script>
    <script>
        window.addEventListener('unselect-cliente', event => {

            $('.clientes_id').val(null).trigger('change');

        })
        window.addEventListener('add-producto', event => {

            addAlert();

        })
    </script>
@endsection
