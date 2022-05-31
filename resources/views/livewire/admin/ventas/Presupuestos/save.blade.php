<div class="px-4 py-2 bg-gray-50 sm:p-6">
    {!! Form::open(['route' => 'admin.ventas.presupuestos.store', 'class' => 'formularioPresupuesto']) !!}
    <div class="grid grid-cols-12 gap-2">


        <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-4 gap-2">
            {{-- CLIENTE --}}
            <div class="col-span-12 mb-5">
                {!! Form::hidden('empresa_id', session('empresa')) !!}
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Cliente <span class="text-sm text-red-500"> * </span></div>
                </label>

                <select name="clientes_id" id="" class="form-select w-full clientes_id pl-3" required>

                </select>
                @error('clientes_id')

                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{$message}}
                </p>

                @enderror
            </div>
            {{-- NUMERO --}}
            <div class="col-span-12 mb-5">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Número de Presupuesto <span class="text-sm text-red-500"> * </span></div>
                </label>
                <div class="relative">
                    <input required name="numero" id="numero"
                        class="form-input w-2/4 valid:border-emerald-300
                                                                required:border-rose-300 invalid:border-rose-300 peer pl-12" type="text" />
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <span class="text-sm text-slate-400 font-medium px-3">PRE-</span>
                    </div>
                </div>
                @error('numero')

                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{$message}}
                </p>

                @enderror
            </div>
            {{-- FECHA PRESUPUESTO--}}
            <div class="col-span-6 gap-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Fecha presupuesto <span class="text-sm text-red-500"> * </span></div>
                    <!---->
                    <!---->
                </label>
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input name="fecha" type="text"
                        class="form-input valid:border-emerald-300
                                                                                                            required:border-rose-300 invalid:border-rose-300 peer fechaPresupuesto  font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block sm:text-sm border-gray-200 rounded-md text-black input w-full"
                        placeholder="Selecciona la fecha">
                </div>
                @error('fecha')

                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{$message}}
                </p>

                @enderror
            </div>
            <!-- ... -->
            {{-- FECHA CADUCIDAD--}}
            <div class="col-span-6 gap-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Fecha de caducidad <span class="text-sm text-red-500" style="display: none;"> *
                        </span>
                    </div>
                    <!---->
                    <!---->
                </label>
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input name="fecha_caducidad" type="text"
                        class="form-input fechaFinPresupuesto valid:border-emerald-300
                                                                                                            required:border-rose-300 invalid:border-rose-300 peer font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block w-full sm:text-sm border-gray-200 rounded-md text-black input dark:focus:border-blue-500"
                        placeholder="Selecciona la fecha">
                </div>
                @error('fecha_caducidad')

                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{$message}}
                </p>

                @enderror
            </div>

        </div>

        <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-red-600 lg:pl-6">
            {{-- moneda--}}
            <div class="col-span-6">
                <label class="block text-sm font-medium mb-1 text-gray-800">Tipo de Cambio:
                    <span class="text-rose-500 tipoCambio"> {{$tipoCambio}}</span> </label>
                <label class="text-gray-800 block text-sm font-medium mb-1" for="moneda">Moneda
                    <span class="text-rose-500">*</span> </label>

                <select name="divisa" id="moneda" class="form-select w-full divisa"
                    @change="cambiarDivisa($event.target.value)">
                    <option value="PEN">PEN</option>
                    <option value="USD">USD</option>
                </select>


                @error('divisa')

                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{$message}}
                </p>

                @enderror

            </div>

            <div class="col-span-12">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Nota
                    </div>
                    <!---->
                    <!---->
                </label>
                <textarea class="form-input w-full px-4 py-3" name="nota" id="" cols="30" rows="5"
                    placeholder="Ingresar nota (opcional)"></textarea>
            </div>
            <!-- ... -->

        </div>





        <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3">

            <div class="grid grid-cols-2 gap-2 mt-4 pt-4 pb-4 bg-white px-3 mb-2">
                <div class="col-span-2 sm:col-span-1">
                    <div class="flex">
                        <button id="productos-button"
                            class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                            type="button">
                            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
                        </button>
                        <label for="productos" class="sr-only">Añadir Artículo</label>
                        <select id="productos"
                            class="bg-gray-50 productoSelect border border-gray-300 text-gray-900 text-sm rounded-r-lg border-l-gray-100 dark:border-l-gray-700 border-l-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Añadir Artículo</option>
                        </select>
                    </div>
                </div>
                <!-- ... -->
                <div class="col-span-2 sm:col-span-1">
                    -
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
                                <textarea rows="4" class="form-input descripcion" placeholder="Descripción"></textarea>
                                <p class="mt-2 hidden text-pink-600 text-sm errorDescripcion">
                                    Rellena todos los campos
                                </p>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                <input type="number" min="0" value="1" step="1" class="form-input qyt"
                                    placeholder="Cantidad">
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <input type="number" min="0" step="0.01" class="form-input importe"
                                    placeholder="Importe">
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                <div class="space-x-1">

                                    <button type="button" onclick="add_item_to_table(); return false;"
                                        class="text-white btn bg-cyan-500 hover:text-slate-500 ">
                                        <span class="sr-only">Añadir</span>


                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <g fill="none" class="nc-icon-wrapper">
                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"
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
                        {{-- <div class="filasAddTest">
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <textarea name="items[1][descripcion]" class="form-input"
                                        rows="5">Instalación de Equipo GPS</textarea>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <input type="number" onblur="calculate_total();" onchange="calculate_total();"
                                        name="cantidad" min="0" value="1" class="form-input cantidad"
                                        placeholder="Cantidad" value="1">
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <input type="number" min="0" onblur="calculate_total();"
                                        onchange="calculate_total();" data-quantity="" name="items[1][precio]"
                                        value="19.99" class="form-input precio">
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <input type="number" onblur="calculate_total();" onchange="calculate_total();"
                                        name="items[1][total]" value="00.00" class="form-input importe subtotal">
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="space-x-1">
                                        <button class="text-rose-500 hover:text-rose-600 rounded-full">
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

                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <textarea name="items[1][descripcion]" class="form-input"
                                        rows="5">Equipo GPS FMB920</textarea>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <input type="number" onblur="calculate_total();" onchange="calculate_total();"
                                        name="cantidad" min="0" value="1" class="form-input cantidad"
                                        placeholder="Cantidad" value="2">
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <input type="number" min="0" onblur="calculate_total();"
                                        onchange="calculate_total();" data-quantity="" name="items[1][precio]"
                                        value="460" class="form-input precio">
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <input type="number" onblur="calculate_total();" onchange="calculate_total();"
                                        name="items[1][total]" value="00.00" class="form-input importe subtotal">
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="space-x-1">
                                        <button class="text-rose-500 hover:text-rose-600 rounded-full">
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
                        </div> --}}
                    </tbody>
                    <tfoot>
                        @error('items[]')

                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{$message}}
                        </p>

                        @enderror
                    </tfoot>
                </table>
            </div>



            {{-- <template x-for="presupuesto in items" :key="presupuesto.id">
                <div class="flex -mx-1 px-2 py-4 border-b box-border ">
                    <div class="flex-1 px-1" style="width: 40%; min-width: 280px;">

                        <p class="text-gray-800" x-text="presupuesto.name"></p>

                        <input type="hidden" name="item.name[]" x-model="presupuesto.name">

                    </div>

                    <div class="px-2 w-20 text-right" style="width: 10%; min-width: 120px;">

                        <p class="text-gray-800" x-text="presupuesto.qty"></p>
                        <input type="hidden" name="item.cantidad[]" x-model="presupuesto.qty">
                    </div>

                    <div class="px-2 w-32 text-right" style="width: 15%; min-width: 120px;">
                        <p class="text-gray-800" x-text="numberFormat(presupuesto.rate)"></p>
                        <input type="hidden" name="item.precio[]" x-model="numberFormat(presupuesto.rate)">
                    </div>

                    <div class="px-1 w-32 text-right" style="width: 15%; min-width: 120px;">
                        <p class="text-gray-800" x-text="numberFormat(presupuesto.total)"></p>
                        <input type="hidden" name="item.total[]" x-model="presupuesto.total">
                    </div>

                    <div class="px-1 w-20 text-right">
                        <a href="#" class="text-red-500 hover:text-red-600 text-sm font-semibold"
                            @click.prevent="deleteItem(presupuesto.id)">Eliminar</a>
                    </div>
                </div>
            </template> --}}


            {{-- DIV PARA SUB Y TOTALES --}}
            <div class="py-2 ml-auto mt-5 w-full sm:w-2/4 lg:w-1/4 mr-2">
                <div class="flex justify-between mb-3">
                    <div class="text-gray-900 text-right flex-1 font-medium text-sm">Total neto</div>
                    <div class="text-right w-40">
                        <div class="text-gray-800 text-sm total"> S/. 0.00</div>
                        <input type="hidden" class="subTotalPropuesto" name="subtotal">
                    </div>
                </div>
                <div class="flex justify-between mb-4">
                    <div class="text-gray-900 text-right flex-1 font-medium text-sm">IGV(18%)</div>
                    <div class="text-right w-40">
                        <div class="text-gray-800 text-sm igv"></div>
                        <input type="hidden" class="impuestoPropuesto" name="impuesto">
                    </div>
                </div>

                <div class="py-2 border-t border-b">
                    <div class="flex justify-between">
                        <div class="text-gray-900 text-right flex-1 font-medium text-sm">Monto Total</div>
                        <div class="text-right w-40">
                            <div class="text-xl text-gray-800 font-bold totalPresupuesto"></div>
                            <input type="hidden" class="totalPropuesto" name="total">
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <div class="px-4 py-3 text-right sm:px-6">
        {!! Form::submit('GUARDAR', ['class' => 'btn bg-emerald-500 hover:bg-emerald-600 focus:outline-none
        focus:ring-2 focus:ring-offset-2
        focus:ring-emerald-600 text-white']) !!}

    </div>
    {!! Form::close() !!}


</div>