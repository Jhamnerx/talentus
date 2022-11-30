<div>
    <div
        class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
        <!-- Add customer button -->
        <a href="{{ route('admin.ventas.presupuestos.index') }}">
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
        <div>
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">EDITAR PRESUPUESTO</h4>
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

    <div class="p-6 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-2 bg-gray-50 sm:p-6">

            <div class="grid grid-cols-12 gap-2">

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-4 gap-2">
                    {{-- CLIENTE --}}
                    <div class="col-span-12 mb-2">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Cliente <span class="text-sm text-red-500"> * </span></div>
                        </label>
                        <div class="flex" wire:ignore>
                            <select name="clientes_id" id="" class="form-select w-full clientes_id pl-3"
                                required>
                                <option selected value="{{ $presupuesto->clientes_id }}">
                                    {{ $presupuesto->clientes->razon_social }}
                                </option>
                            </select>

                            @livewire('admin.clientes.button-open-modal')

                        </div>

                        @error('clientes_id')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- NUMERO --}}
                    <div class="col-span-12 mb-3">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Número de Presupuesto <span class="text-sm text-red-500"> * </span></div>
                        </label>
                        <div class="relative">
                            <input required wire:model="numero" name="numero" id="numero"
                                class="form-input w-full md:w-2/4" type="text" />

                        </div>
                        @error('numero')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- FECHA PRESUPUESTO --}}

                    <div class="col-span-6 gap-2">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Fecha presupuesto <span class="text-sm text-red-500"> * </span></div>
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

                            <input type="text" wire:model="fecha"
                                class="form-input fechaPresupuesto font-base pl-8 py-2 block sm:text-sm border-gray-200 rounded-md text-black input w-full"
                                placeholder="Seleccion la fecha emisión">
                        </div>
                        @error('fecha')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- FECHA CADUCIDAD --}}
                    <div class="col-span-6 gap-2">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Fecha de caducidad <span class="text-sm text-red-500" style="display: none;"> *
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
                            <input name="fecha_caducidad" type="text" wire:model="fecha_caducidad"
                                class="form-input fechaFinPresupuesto font-base pl-8 py-2  block w-full sm:text-sm border-gray-200 rounded-md text-black input"
                                placeholder="Selecciona la fecha">
                        </div>
                        @error('fecha_caducidad')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-red-600 lg:pl-6 gap-2">
                    {{-- moneda --}}
                    <div class="col-span-12 md:col-span-6 mb-2">
                        <label class="text-gray-800 block text-sm font-medium mb-1" for="moneda">Moneda
                            <span class="text-rose-500">*</span> </label>

                        <select wire:model="divisa" name="divisa" id="moneda" class="form-select w-full divisa">
                            <option value="PEN">SOLES</option>
                            <option value="USD">DOLARES</option>
                        </select>

                        @error('divisa')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>
                    <div class="col-span-12 md:col-span-6 mb-2">
                        <label class="block text-sm font-medium mb-1 text-gray-800">Tipo de Cambio:
                            <span class="text-rose-500 tipoCambio"> {{ $tipoCambio }}</span> </label>

                    </div>
                    <div class="col-span-12">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            Nota
                        </label>

                        <textarea wire:model="nota" class="form-input w-full px-4 py-3" name="nota" id="" rows="4"
                            placeholder="Ingresar nota opcional"></textarea>
                    </div>
                </div>

                <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3">
                    <div class="grid grid-cols-2 gap-2 mt-4 pt-4 pb-4 bg-white px-3 mb-2">
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex btnAddProducto" wire:ignore>
                                <button id="productos-button"
                                    class="flex-shrink-0 cursor-default z-10 hidden md:inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                                    type="button">
                                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                        <path
                                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                    </svg>
                                </button>
                                <label for="productos" class="sr-only">Añadir Artículo</label>
                                <select id="productos" wire:model="producto"
                                    class="bg-gray-50 productoSelect border border-gray-300 text-gray-900 text-sm rounded-r-lg border-l-gray-100 dark:border-l-gray-700 border-l-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Añadir Artículo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-span-2 sm:col-span-1">

                        </div>
                    </div>

                    {{-- LISTA DE PRODUCTOS --}}
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <!-- Table header -->
                            <thead
                                class="text-xs font-semibold uppercase text-white bg-slate-800  border-t border-b border-slate-200">
                                <tr>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Artículo o Servicio</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Descripción</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Cantidad</div>
                                    </th>

                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Precio</div>
                                    </th>

                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Importe</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Acciones</div>
                                    </th>

                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="text-sm divide-y divide-slate-200 listaItems">
                                <!-- Row -->
                                <tr class="main bg-slate-50">
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <textarea wire:model="selected.producto" rows="5" class="form-input descripcion" placeholder="Producto"></textarea>
                                        @if ($errors->has('selected.producto'))
                                            <p class="mt-2  text-pink-600 text-sm">
                                                {{ $errors->first('selected.producto') }}
                                            </p>
                                        @endif
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <textarea wire:model="selected.descripcion" rows="5" class="form-input descripcion" placeholder="Descripción"></textarea>
                                        @if ($errors->has('selected.descripcion'))
                                            <p class="mt-2  text-pink-600 text-sm">
                                                {{ $errors->first('selected.descripcion') }}
                                            </p>
                                        @endif
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                        <input wire:model="selected.cantidad" type="number" min="1"
                                            value="1" step="1" class="form-input qyt"
                                            placeholder="Cantidad">
                                        @if ($errors->has('selected.cantidad'))
                                            <p class="mt-2  text-pink-600 text-sm">
                                                {{ $errors->first('selected.cantidad') }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <input wire:model="selected.precio" type="number" min="0"
                                            step="0.1" class="form-input importe" placeholder="Importe">
                                        @if ($errors->has('selected.precio'))
                                            <p class="mt-2  text-pink-600 text-sm">
                                                {{ $errors->first('selected.precio') }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="space-x-1">

                                            <button type="button" wire:click="addProducto"
                                                class="text-white btn bg-cyan-500 hover:text-slate-500 ">
                                                <span class="sr-only">Añadir</span>


                                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <g fill="none" class="nc-icon-wrapper">
                                                        <path
                                                            d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"
                                                            fill="currentColor">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <p class="mt-2 hidden text-pink-600 text-sm vacio">
                                        Debes añadir al menos 1 item
                                    </p>
                                </tr>
                                {{-- fila para añadir --}}
                                @if ($items->count() > 0)
                                    @foreach ($items->all() as $clave => $item)
                                        <tr wire:key="item-{{ $clave }}-{{ $item['id'] }}">

                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <textarea required wire:model="items.{{ $clave }}.producto" class="form-textarea" rows="4">

                                                </textarea>
                                                @if ($errors->has('items.' . $clave . '.cantidad'))
                                                    <p class="mt-2  text-pink-600 text-sm">
                                                        {{ $errors->first('items.' . $clave . '.cantidad') }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <textarea required wire:model="items.{{ $clave }}.descripcion" class="form-textarea" rows="4">
                                                </textarea>

                                            </td>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <input required type="number" x-mask="99999"
                                                    wire:model="items.{{ $clave }}.cantidad" min="1"
                                                    step="1" class="form-input cantidad" placeholder="Cantidad"
                                                    value="2">
                                                @if ($errors->has('items.' . $clave . '.cantidad'))
                                                    <p class="mt-2  text-pink-600 text-sm">
                                                        {{ $errors->first('items.' . $clave . '.cantidad') }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <input required type="number" required min="1" step="0.1"
                                                    wire:model="items.{{ $clave }}.precio"
                                                    class="form-input precio">
                                                @if ($errors->has('items.' . $clave . '.cantidad'))
                                                    <p class="mt-2  text-pink-600 text-sm">
                                                        {{ $errors->first('items.' . $clave . '.cantidad') }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <input type="text" wire:model="items.{{ $clave }}.total"
                                                    class="form-input importe subtotal" readonly>
                                            </td>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                                <div class="space-x-1">
                                                    <button type="button"
                                                        wire:click.prevent="eliminarProducto('{{ $clave }}')"
                                                        class="text-rose-500 hover:text-rose-600 rounded-full">
                                                        <span class="sr-only">Delete</span>
                                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                            <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                                            <path
                                                                d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>

                                @error('items')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </tfoot>
                        </table>
                    </div>

                    <div class="flex">
                        <div
                            class="py-2 ml-auto mt-5 w-full sm:w-2/4 lg:w-1/4 mr-2 {{ $ConvertirSoles ? '' : 'hidden' }}">
                            <div class="flex justify-between mb-3">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm">Sub Total</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm"> S/.
                                        <span>{{ number_format($sub_total_soles, 2) }}</span>
                                    </div>

                                </div>
                            </div>
                            <div class="flex justify-between mb-4">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm">IGV(18%) Soles</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">S/.
                                        <span>{{ number_format($impuesto_soles, 2) }}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="py-2 border-t border-b">
                                <div class="flex justify-between">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm">Monto Total Soles
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-xl text-gray-800 font-bold">
                                            S/. <span>{{ number_format($total_soles, 2) }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- DIV PARA SUB Y TOTALES --}}
                        <div class="py-2 ml-auto mt-5 w-full sm:w-2/4 lg:w-1/4 mr-2">
                            <div class="flex justify-between mb-3">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm">Sub Total</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">{{ $simbolo }}
                                        <span>{{ number_format($sub_total, 2) }}</span>
                                    </div>

                                </div>
                            </div>
                            <div class="flex justify-between mb-4">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm">IGV(18%)</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">{{ $simbolo }}
                                        <span>{{ number_format($impuesto, 2) }}</span>
                                    </div>
                                </div>
                            </div>
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
                    wire:click.prevent="actualizarPresupuesto">Guardar</button>
            </div>

        </div>

    </div>
</div>

@section('js')
    <script>
        var tipoCambio = parseFloat($(".tipoCambio").text());

        $("#money").maskMoney({
            'thousands': '.'
        });

        $(document).ready(function() {

            // INICIALIZAR LOS INPUTS DE FECHA
            flatpickr('.fechaPresupuesto', {
                mode: 'single',
                defaultDate: "today",
                minDate: "today",
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });

            flatpickr('.fechaFinPresupuesto', {
                mode: 'single',
                defaultDate: new Date().fp_incr(15),
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
                message: 'Se añadio un producto al presupuesto',
            });
        }
    </script>

    <script>
        window.addEventListener('add-producto', event => {
            addAlert();
            $('.productoSelect').val(null).trigger('change');
        })
    </script>
@endsection
