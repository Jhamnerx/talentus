<div>

    <!-- Basic Modal -->

    <!-- Start -->
    <div x-data="{ openModalSave: @entangle('openModalSave') }">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="openModalSave"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-10"
            role="dialog" aria-modal="true" x-show="openModalSave"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg text-center overflow-auto w-full md:w-3/4 lg:w-3/4 xl:w-3/4 2xl:w-3/4 max-h-full"
                @keydown.escape.window="openModalSave = false">
                <div
                    class="inline-block align-middle w-full bg-white rounded-lg text-left overflow-hidden relative shadow-xl transition-all my-4">
                    <div
                        class="flex items-center justify-between px-6 py-4 text-lg font-medium text-black border-b border-gray-200 border-solid">
                        <div class="flex justify-between w-full">
                            Añadir rol
                            <button class="text-slate-400 hover:text-slate-500" @click="openModalSave = false">
                                <div class="sr-only">Close</div>
                                <svg class="w-4 h-4 fill-current">
                                    <path
                                        d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                </svg>
                            </button>
                        </div>

                    </div>
                    {!! Form::open(['route' => 'admin.ajustes.roles.store', 'autocomplete' => 'off']) !!}
                    <div class="px-4 md:px-8 py-4 md:py-6">
                        <div class="relative w-full text-left mt-3">
                            <label
                                class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">

                                <div>
                                    Nombre
                                    <span class="text-sm text-red-500"> * </span>
                                </div>


                            </label>
                            <div class="flex flex-col mt-1">

                                <div class="relative rounded-md shadow-sm font-base">

                                    <input name="name" type="text"
                                        class="font-base block w-full sm:text-sm border-gray-200 rounded-md text-black focus:ring-indigo-400 focus:border-indigo-400"
                                        tabindex="0">


                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <h6 class="text-sm not-italic font-medium text-gray-800 px-4 md:px-8 py-1.5">Permisos <span
                                class="text-sm text-red-500"> *</span></h6>
                        <div class="text-sm not-italic font-medium text-gray-300 px-4 md:px-8 py-1.5">
                            <a class="cursor-pointer text-indigo-400">Seleccionar todo</a> /
                            <a class="cursor-pointer text-indigo-400">Ninguno</a>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 py-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 px-8 sm:px-8">
                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">Categorias</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="check_i231t5ggs" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="ver-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">

                                            <label for="check_i231t5ggs"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver categoria
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="check_7ae5vb3bz" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="crear-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_7ae5vb3bz"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear categoria
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="check_jxfpqul1t" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="editar-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_jxfpqul1t"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar categoria
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="check_9grgp7y5g" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="eliminar-categoria">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_9grgp7y5g"
                                                class="font-medium text-gray-600 cursor-pointer">eliminar
                                                categoria</label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- PRODUCTOS --}}
                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">Productos</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="ver-producto" id="check_6f6h3lakd"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_6f6h3lakd"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="crear-producto" id="check_chrthkf7x"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_chrthkf7x"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="editar-producto" id="check_a5j55m769"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_a5j55m769"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="eliminar-producto" id="check_lj2i8ysx6"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_lj2i8ysx6"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar item
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">Sim Card y Lineas
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="ver-sim_card" id="check_cndx5pjaq"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_cndx5pjaq"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver sim y lineas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="crear-sim_card" id="check_7a25umedy"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_7a25umedy"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear sim y lineas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="editar-sim_card" id="check_dmjh1npj4"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_dmjh1npj4"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar sim y lineas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="eliminar-sim_card" id="check_am4865hz2"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_am4865hz2"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="importar-sim_card" id="check_am4865hz2"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_am4865hz2"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                importar sim card
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="exportar-sim_card" id="check_am4865hz2"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_am4865hz2"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                exportar sim card
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- DISPOSITIVOS --}}
                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">Dispositivos</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="ver-dispositivo" id="check_0zxpd3hn1"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_0zxpd3hn1"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="crear-dispositivo" id="check_4j0jyvnot"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_4j0jyvnot"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="editar-dispositivo"
                                                id="check_5lobzv2d9" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_5lobzv2d9"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar dispositivo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="eliminar-dispositivo"
                                                id="check_d65ryptb0" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_d65ryptb0"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar dispositivo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="importar-dispositivo"
                                                id="check_ja2g4n9ij" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_ja2g4n9ij"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                importar dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="exportar-dispositivo"
                                                id="check_ja2g4n9ij" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_ja2g4n9ij"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                exportar dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">Guias</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="ver-guias" id="check_94lbtu5o4"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_94lbtu5o4"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver guias
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="crear-guias" id="check_i0ziweh6i"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_i0ziweh6i"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear guias
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="editar-guias" id="check_ydvr36aty"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_ydvr36aty"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar guias
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" value="eliminar-guias" id="check_nev2sv7dd"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="check_nev2sv7dd"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar guias
                                            </label>

                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">
                                    RecurringInvoice
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_5oiwxpq2f" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_5oiwxpq2f"
                                                class="font-medium text-gray-600 cursor-pointer">ver recurring
                                                invoice</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_thpdn4bjs" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_thpdn4bjs"
                                                class="font-medium text-gray-600 cursor-pointer">crear recurring
                                                invoice</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_n9ur6r4r3" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_n9ur6r4r3"
                                                class="font-medium text-gray-600 cursor-pointer">editar recurring
                                                invoice</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_zbm4gt3e8" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_zbm4gt3e8"
                                                class="font-medium text-gray-600 cursor-pointer">eliminar recurring
                                                invoice</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">Payment</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_vbvrk364m" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_vbvrk364m"
                                                class="font-medium text-gray-600 cursor-pointer">ver
                                                payment</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_t4lxd556n" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_t4lxd556n"
                                                class="font-medium text-gray-600 cursor-pointer">crear
                                                payment</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_96wwrpj9m" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_96wwrpj9m"
                                                class="font-medium text-gray-600 cursor-pointer">editar
                                                payment</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_01pp7scx8" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_01pp7scx8"
                                                class="font-medium text-gray-600 cursor-pointer">eliminar
                                                payment</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_i9yrpuo6v" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_i9yrpuo6v"
                                                class="font-medium text-gray-600 cursor-pointer">send
                                                payment</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">Expense</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_uuqc24435" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_uuqc24435"
                                                class="font-medium text-gray-600 cursor-pointer">ver
                                                expense</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_umo2pdi18" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_umo2pdi18"
                                                class="font-medium text-gray-600 cursor-pointer">crear
                                                expense</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_uc05dofu0" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_uc05dofu0"
                                                class="font-medium text-gray-600 cursor-pointer">editar
                                                expense</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_xqe739weu" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_xqe739weu"
                                                class="font-medium text-gray-600 cursor-pointer">eliminar
                                                expense</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">CustomField</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_o2lz08j44" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_o2lz08j44"
                                                class="font-medium text-gray-600 cursor-pointer">ver custom
                                                field</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_nq6tpgohl" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_nq6tpgohl"
                                                class="font-medium text-gray-600 cursor-pointer">crear custom
                                                field</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_wzuti6q5s" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_wzuti6q5s"
                                                class="font-medium text-gray-600 cursor-pointer">editar custom
                                                field</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_sinhldree" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_sinhldree"
                                                class="font-medium text-gray-600 cursor-pointer">eliminar custom
                                                field</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">Common</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_uuvy0f68w" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_uuvy0f68w"
                                                class="font-medium text-gray-600 cursor-pointer">ver financial
                                                reports</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_cmscfk54p" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_cmscfk54p"
                                                class="font-medium text-gray-600 cursor-pointer">ver company
                                                dashboard</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">
                                    ExchangeRateProvider</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_p9sap54rz" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_p9sap54rz"
                                                class="font-medium text-gray-600 cursor-pointer">ver exchange rate
                                                provider</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_7l1jotctl" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_7l1jotctl"
                                                class="font-medium text-gray-600 cursor-pointer">crear exchange
                                                rate
                                                provider</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_1nwbv5dp9" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_1nwbv5dp9"
                                                class="font-medium text-gray-600 cursor-pointer">editar exchange
                                                rate
                                                provider</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_x470mqtbr" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_x470mqtbr"
                                                class="font-medium text-gray-600 cursor-pointer">eliminar exchange
                                                rate
                                                provider</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-1">
                                <p class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2">Note</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_0e64w1pnw" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_0e64w1pnw"
                                                class="font-medium text-gray-600 cursor-pointer">ver all
                                                notes</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5"><input name="permission[]"
                                                id="check_ud2y1ciw3" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm"><label for="check_ud2y1ciw3"
                                                class="font-medium text-gray-600 cursor-pointer">manage
                                                notes</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!---->
                        </div>
                    </div>
                    <div class="z-0 flex justify-end p-4 border-t border-solid border--200 border-modal-bg">
                        <button
                            class="inline-flex whitespace-nowrap items-center borderfocus:outline-none focus:ring-2 focus:ring-offset-2 px-4 py-2  leading-5 rounded-md border-transparent  border-solid border-indigo-500 font-normal transition ease-in-out duration-150 text-indigo-500 hover:bg-indigo-200 shadow-inner focus:ring-indigo-500 mr-3 text-sm"
                            type="button">
                            Cancelar
                        </button>
                        <button
                            class="inline-flex whitespace-nowrap items-center border font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 px-4 py-2 text-sm leading-5 rounded-md border-transparent shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500"
                            type="submit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" verBox="0 0 24 24"
                                stroke="currentColor" class="-ml-1 mr-2 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            Guardar
                        </button>
                    </div>

                    {!! Form::close() !!}
                </div>

            </div>

        </div>
    </div>
    <!-- End -->

</div>
