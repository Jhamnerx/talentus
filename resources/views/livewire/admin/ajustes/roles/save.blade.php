<div>

    <!-- Basic Modal -->

    <!-- Start -->
    <div x-data="{ openModalSave: @entangle('openModalSave').live }">
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
                            <button class="text-slate-400 hover:text-slate-500" wire:click.prevent="closeModal">
                                <div class="sr-only">Close</div>
                                <svg class="w-4 h-4 fill-current">
                                    <path
                                        d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                </svg>
                            </button>
                        </div>

                    </div>
                    {!! Form::open(['autocomplete' => 'off']) !!}
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

                                    <input name="name" wire:model.live="name" type="text"
                                        class="font-base block w-full sm:text-sm border-gray-200 rounded-md text-black focus:ring-indigo-400 focus:border-indigo-400"
                                        tabindex="0">


                                </div>


                            </div>
                            @error('name')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <h6 class="text-sm not-italic font-medium text-gray-800 px-4 md:px-8 py-1.5">
                            Permisos
                            <span class="text-sm text-red-500"> *</span>
                        </h6>
                        @error('permission')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                        @enderror
                        <div class="text-sm not-italic font-medium text-gray-300 px-4 md:px-8 py-1.5">
                            <a wire:click.prevent="checkAll" class="cursor-pointer text-indigo-400">Seleccionar todo</a>
                            /
                            <a wire:click.prevent="uncheckAll" class="cursor-pointer text-indigo-400">Ninguno</a>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 py-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 px-8 sm:px-8">
                            {{--CATEGORIA--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('categoria')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Categorias</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" id="ver-categoria"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="ver-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">

                                            <label for="ver-categoria" class="font-medium text-gray-600 cursor-pointer">
                                                ver categoria
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" id="crear-categoria"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="crear-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-categoria"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear categoria
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" id="editar-categoria"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="editar-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-categoria"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar categoria
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                id="cambiar.estado-categoria" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="cambiar.estado-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="cambiar.estado-categoria"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estado categoria
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" id="eliminar-categoria"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="eliminar-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-categoria"
                                                class="font-medium text-gray-600 cursor-pointer">eliminar
                                                categoria</label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- PRODUCTOS --}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('producto')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Productos</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="ver-producto"
                                                id="ver-producto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-producto" class="font-medium text-gray-600 cursor-pointer">
                                                ver producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="crear-producto"
                                                id="crear-producto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-producto"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="editar-producto"
                                                id="editar-producto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-producto"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="cambiar.estado-producto" id="cambiar.estado-producto"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="cambiar.estado-producto"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estado producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="eliminar-producto"
                                                id="eliminar-producto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-producto"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar item
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--SIM CARD Y LINEAS--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('sim_card')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">Sim
                                    Card y Lineas
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="ver-sim_card"
                                                id="ver-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-sim_card" class="font-medium text-gray-600 cursor-pointer">
                                                ver sim y lineas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="crear-sim_card"
                                                id="crear-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear sim y lineas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="editar-sim_card"
                                                id="editar-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar sim y lineas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar.numero-sim_card" id="asignar.linea-sim_card"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="asignar.linea-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                asignar linea
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="asignar.linea-sim_card" id="eliminar.numero-sim_card"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar.numero-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar numero de sim card
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="eliminar-sim_card"
                                                id="eliminar-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="ver.cambios-sim_card" id="ver.cambios-sim_card" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver.cambios-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver cambios sim card
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="importar-sim_card"
                                                id="importar-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="importar-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                importar sim card
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="exportar-sim_card"
                                                id="exportar-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="exportar-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                exportar sim card
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- DISPOSITIVOS --}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('dispositivo')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Dispositivos
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="ver-dispositivo"
                                                id="ver-dispositivo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="ver.modelos-dispositivo" id="ver.modelos-dispositivo"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver.modelos-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver modelos dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="crear-dispositivo"
                                                id="crear-dispositivo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="editar-dispositivo" id="editar-dispositivo" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar dispositivo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-dispositivo" id="eliminar-dispositivo" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar dispositivo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="importar-dispositivo" id="importar-dispositivo" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="importar-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                importar dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="exportar-dispositivo" id="exportar-dispositivo" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="exportar-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                exportar dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--GUIAS--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('guias')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Guias</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="ver-guias"
                                                id="ver-guias" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-guias" class="font-medium text-gray-600 cursor-pointer">
                                                ver guias
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="crear-guias"
                                                id="crear-guias" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-guias" class="font-medium text-gray-600 cursor-pointer">
                                                crear guias
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="editar-guias"
                                                id="editar-guias" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-guias" class="font-medium text-gray-600 cursor-pointer">
                                                editar guias
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="detalle-guias"
                                                id="detalle-guias" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="detalle-guias" class="font-medium text-gray-600 cursor-pointer">
                                                ver detalle guias
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="eliminar-guias"
                                                id="eliminar-guias" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-guias"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar guias
                                            </label>

                                        </div>
                                    </div>
                                </div>


                            </div>

                            {{--CLIENTES--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('cliente')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Clientes
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="ver-cliente"
                                                id="ver-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">ver clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="crear-cliente"
                                                id="crear-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">crear clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="editar-cliente"
                                                id="editar-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">editar
                                                clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="cambiar.estado-cliente" id="cambiar.estado-cliente"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="cambiar.estado-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estados clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="eliminar-cliente"
                                                id="eliminar-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="exportar-cliente"
                                                id="xportar-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="xportar-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                exportar clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="importar-cliente"
                                                id="importar-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="importar-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                importar clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--CONTACTOS--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('contacto')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Contactos</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="ver-contacto"
                                                id="ver-contacto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-contacto"
                                                class="font-medium text-gray-600 cursor-pointer">ver contacto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="crear-contacto"
                                                id="crear-contacto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-contacto"
                                                class="font-medium text-gray-600 cursor-pointer">crear contacto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="editar-contacto"
                                                id="editar-contacto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-contacto"
                                                class="font-medium text-gray-600 cursor-pointer">editar
                                                contacto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="eliminar-contacto"
                                                id="eliminar-contacto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-contacto"
                                                class="font-medium text-gray-600 cursor-pointer">eliminar
                                                contacto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--PROVEEDORES--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('proveedor')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Proveedores</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="ver-proveedor"
                                                id="ver-proveedor" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">ver proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="crear-proveedor"
                                                id="crear-proveedor" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">crear proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" id="editar-proveedor"
                                                value="editar-proveedor" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">editar proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                id="cambiar.estado-proveedor" value="cambiar.estado-proveedor"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="cambiar.estado-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">cambiar estado
                                                proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" id="exportar-proveedor"
                                                value="exportar-proveedor" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="exportar-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                exportar proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" id="importar-proveedor"
                                                value="importar-proveedor" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="importar-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                importar proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-proveedor" id="eliminar-proveedor" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--FACTURAS COMPRA--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('compras_facturas')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Facturas Compras
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="ver-compras_facturas" id="ver-compras_facturas" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-compras_facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver facturas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="crear-compras_facturas" id="crear-compras_facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-compras_facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear facturas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="editar-compras_facturas" id="editar-compras_facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-compras_facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-compras_facturas" id="eliminar-compras_facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-compras_facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar facturas</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--COTIZACIONES--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('cotizaciones')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Cotizaciones</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="ver-cotizaciones"
                                                id="ver-cotizaciones" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="crear-cotizaciones" id="crear-cotizaciones" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="editar-cotizaciones" id="editar-cotizaciones" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-cotizaciones" id="eliminar-cotizaciones"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="convertir-cotizaciones" id="convertir-cotizaciones"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="convertir-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                convertir cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="enviar-cotizaciones" id="enviar-cotizaciones" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="enviar-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="estados-cotizaciones" id="estados-cotizaciones" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="estados-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estados
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="descargar-cotizaciones" id="descargar-cotizaciones"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="descargar-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">

                                                Descargar cotizacion
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--FACTURAS VENTA--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('ventas-facturas')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Facturas Venta
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="ver-ventas-facturas" id="ver-ventas-facturas" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver facturas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="crear-ventas-facturas" id="crear-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear facturas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="editar-ventas-facturas" id="editar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-ventas-facturas" id="eliminar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="exportar-ventas-facturas" id="exportar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="exportar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                exportar facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="enviar-ventas-facturas" id="enviar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="enviar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="enviar-ventas-facturas" id="enviar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="enviar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estados facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="descargar-ventas-facturas" id="descargar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="descargar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar facturas</label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--RECIBOS--}}
                            <div class="flex flex-col space-y-1">

                                <p wire:click="checkCategory('recibo')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Recibos
                                </p>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="ver-recibo"
                                                id="ver-recibo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-recibo" class="font-medium text-gray-600 cursor-pointer">
                                                ver recibos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="crear-recibo"
                                                id="crear-recibo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-recibo" class="font-medium text-gray-600 cursor-pointer">
                                                crear recibo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="editar-recibo"
                                                id="editar-recibo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-recibo" class="font-medium text-gray-600 cursor-pointer">
                                                editar recibo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="eliminar-recibo"
                                                id="eliminar-recibo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-recibo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar recibo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="enviar-recibos"
                                                id="enviar-recibos" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="enviar-recibos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar recibos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="reportes-recibos"
                                                id="estados-recibos" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="estados-recibos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estado recibos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="reportes-recibos"
                                                id="reportes-recibos" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="reportes-recibos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                reportes de recibos
                                            </label>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{--CONTRATOS--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('contrato')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Contratos
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="ver-contrato"
                                                variant="indigo" type="checkbox" id="ver-contrato"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-contrato" class="font-medium text-gray-600 cursor-pointer">
                                                ver contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="crear-contrato" wire:model.live="permission"
                                                value="crear-contrato" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" value="editar-contrato"
                                                id="editar-contrato" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="descargar-contrato" id="descargar-contrato" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="descargar-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="caracteristicas-contrato" id="caracteristicas-contrato"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="caracteristicas-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar caracteristicas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="cambiar.estado-contrato" id="cambiar.estado-contrato"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="cambiar.estado-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estado contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="enviar-contrato" wire:model.live="permission"
                                                value="enviar-contrato" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="enviar-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="crear-registro-contrato"
                                                wire:model.live="permission" value="crear-registro-contrato" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-registro-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                convertir a registro cobro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--VEHICULOS--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('vehiculos-vehiculos')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Vehiculos</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="ver-vehiculos-vehiculos"
                                                wire:model.live="permission" value="ver-vehiculos-vehiculos" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-vehiculos-vehiculos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver vehiculos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="crear-vehiculos-vehiculos"
                                                wire:model.live="permission" value="crear-vehiculos-vehiculos"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-vehiculos-vehiculos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear vehiculos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="editar-vehiculos-vehiculos" id="editar-vehiculos-vehiculos"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-vehiculos-vehiculos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar vehiculos
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-vehiculos-vehiculos" id="eliminar-vehiculos-vehiculos"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-vehiculos-vehiculos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar vehiculos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('vehiculos-flotas')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Flotas</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="ver-vehiculos-flotas" id="ver-vehiculos-flotas" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-vehiculos-flotas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver flotas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="crear-vehiculos-flotas" id="crear-vehiculos-flotas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-vehiculos-flotas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear flotas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="editar-vehiculos-flotas" id="editar-vehiculos-flotas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-vehiculos-flotas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar flotas
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-vehiculos-flotas" id="eliminar-vehiculos-flotas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-vehiculos-flotas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar flotas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--REPORTES--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('vehiculos-reportes')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Reportes</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="ver-vehiculos-reportes" id="ver-vehiculos-reportes"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-vehiculos-reportes"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver reportes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="crear-vehiculos-reportes" id="crear-vehiculos-reportes"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-vehiculos-reportes"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear reportes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="editar-vehiculos-reportes" id="editar-vehiculos-reportes"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-vehiculos-reportes"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar reportes
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-vehiculos-reportes" id="eliminar-vehiculos-reportes"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-vehiculos-reportes"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar reportes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--ACTAS--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('certificados-actas')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Actas
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="ver-certificados-actas" id="ver-certificados-actas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver actas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="crear-certificados-actas" id="crear-certificados-actas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear actas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="editar-certificados-actas" id="editar-certificados-actas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar acta
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="descargar-certificados-actas" id="descargar-certificados-actas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="descargar-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar acta
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="enviar-certificados-actas" id="enviar-certificados-actas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="enviar-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar acta
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-certificados-actas" id="eliminar-certificados-actas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar actas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--CERTIFICADOS--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('certificados-gps')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Certificados</p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="ver-certificados-gps" id="ver-certificados-gps" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="crear-certificados-gps" id="crear-certificados-gps"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="editar-certificados-gps" id="editar-certificados-gps"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="descargar-certificados-gps" id="descargar-certificados-gps"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="descargar-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="enviar-certificados-gps" id="enviar-certificados-gps"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="enviar-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-certificados-gps" id="eliminar-certificados-gps"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--CERTIFICADOS VELO--}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('certificados-velocimetros')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Certificado Velocimetros
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="ver-certificados-velocimetros" id="ver-certificados-velocimetros"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="ver-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="crear-certificados-velocimetros"
                                                id="crear-certificados-velocimetros" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="crear-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="editar-certificados-velocimetros"
                                                id="editar-certificados-velocimetros" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="descargar-certificados-velocimetros"
                                                id="descargar-certificados-velocimetros" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="descargar-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="enviar-certificados-velocimetros"
                                                id="enviar-certificados-velocimetros" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="enviar-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="eliminar-certificados-velocimetros"
                                                id="eliminar-certificados-velocimetros" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="eliminar-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ADMIN PERMISOS --}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('solicitudes')"
                                    class="text-sm text-gray-700 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Administración Solicitudes
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.solicitudes.index" id="admin.solicitudes.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.solicitudes.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver solicitudes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.solicitudes.finalize" id="admin.solicitudes.finalize"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.solicitudes.finalize"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Finalizar solicitud
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('.reportes.')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Administración Reportes Gerenciales
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.reportes.index" id="admin.reportes.index" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.reportes.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver reportes y descargar
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.reportes.logs.index" id="admin.reportes.logs.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.reportes.logs.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Ver logs y cambios
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.reportes.logs.actions" id="admin.reportes.logs.actions"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.reportes.logs.actions"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Modificar logs y recuperar
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- USUARIOS --}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('.usuarios.')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Administración Usuarios sistema
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.usuarios.index" id="admin.usuarios.index" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.usuarios.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver usuarios
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.usuarios.create" id="admin.usuarios.create"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.usuarios.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear usuarios
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.usuarios.edit" id="admin.usuarios.edit" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.usuarios.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar usuarios
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.usuarios.status" id="admin.usuarios.status"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.usuarios.status"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estado usuarios
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.usuarios.delete" id="admin.usuarios.delete"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.usuarios.delete"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar usuarios
                                            </label>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- cobros --}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('.cobros.')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Administración Cobros
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.cobros.index" id="admin.cobros.index" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.cobros.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver cobros
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.cobros.create" id="admin.cobros.create" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.cobros.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear cobros
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission" id="admin.cobros.edit"
                                                value="admin.cobros.edit" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.cobros.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar cobros
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.cobros.delete" id="admin.cobros.delete" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.cobros.delete"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar cobros
                                            </label>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- payments --}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('.payments.')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Administración Pagos
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.payments.index" id="admin.payments.index" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.payments.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver pagos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.payments.create" id="admin.payments.create"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.payments.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear pagos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ciudades --}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('.settings.ciudades.')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Administración Ciudades
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.ciudades.index" id="admin.settings.ciudades.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.ciudades.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver ciudades
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.ciudades.create"
                                                id="admin.settings.ciudades.create" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.ciudades.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear ciudades
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.ciudades.edit" id="admin.settings.ciudades.edit"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.ciudades.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar ciudades
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.ciudades.delete"
                                                id="admin.settings.ciudades.delete" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.ciudades.delete"
                                                class="font-medium text-gray-600 cursor-pointer">

                                                eliminar ciudades
                                            </label>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- roles --}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('settings.roles')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Administración Roles
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.roles.index" id="admin.settings.roles.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.roles.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver roles
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.roles.create" id="admin.settings.roles.create"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.roles.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear roles
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.roles.edit" id="admin.settings.roles.edit"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.roles.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar roles
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.roles.delete" id="admin.settings.roles.delete"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.roles.delete"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar eliminar
                                            </label>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- plantilla --}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('.settings.plantilla.')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Administración Plantilla
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                id="admin.settings.plantilla.index"
                                                value="admin.settings.plantilla.index" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.plantilla.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver informacion
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.plantilla.informacion.edit"
                                                id="admin.settings.plantilla.informacion.edit" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.plantilla.informacion.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar informacion
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.plantilla.sunat.edit"
                                                id="admin.settings.plantilla.sunat.edit" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.plantilla.sunat.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Actualizar Accesos Sunat
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.plantilla.series.edit"
                                                id="admin.settings.plantilla.series.edit" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.plantilla.series.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Actualizar series
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="admin.settings.plantilla.images.edit"
                                                id="admin.settings.plantilla.images.edi" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="admin.settings.plantilla.images.edi"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Actualizar imagenes
                                            </label>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- servicio tecnico --}}
                            <div class="flex flex-col space-y-1">
                                <p wire:click="checkCategory('tareas')"
                                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                                    Servicio Tecnico
                                </p>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.index" id="tecnico.tareas.index" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver modulo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.reportes" id="tecnico.tareas.reportes"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.reportes"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar reportes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.cards" id="tecnico.tareas.cards" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.cards"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Ver resumenes tabla
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.cards.sin-leer.actions"
                                                id="tecnico.tareas.cards.sin-leer" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.cards.sin-leer"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Acciones: Tabla Sin Leer
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.cards.complete.actions"
                                                id="tecnico.tareas.cards.complete.actions" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.cards.complete.actions"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Acciones: Tabla Completados
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.cards.pendient.actions"
                                                id="tecnico.tareas.cards.pendient.actions" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.cards.pendient.actions"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Acciones: Tabla Pendientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.cards.canceled.actions"
                                                id="tecnico.tareas.cards.canceled.actions" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.cards.canceled.actions"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Acciones: Tabla Cancelados
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.tecnicos.admin" id="tecnico.tareas.tecnicos.admin"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.tecnicos.admin"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Administrar Tecnicos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.tabla-historial"
                                                id="tecnico.tareas.tabla-historial" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.tabla-historial"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Ver Tabla Historial
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.create" id="tecnico.tareas.create"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.create"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Crear Tarea
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.edit" id="tecnico.tareas.edit" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.edit"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Editar Tarea
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.delete" id="tecnico.tareas.delete"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.delete"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Eliminar Tarea
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.action.pdf" id="tecnico.tareas.action.pdf"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.action.pdf"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Accion: Descargar PDF
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.action.wsp" id="tecnico.tareas.action.wsp"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.action.wsp"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Accion: Enviar WhatsApp
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.tipo.index" id="tecnico.tareas.tipo.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.tipo.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Tipo Tarea: Ver
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.tipo.create" id="tecnico.tareas.tipo.create"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.tipo.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Tipo Tarea: Crear
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.tipo.edit" id="tecnico.tareas.tipo.edit"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.tipo.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Tipo Tarea: Editar
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model.live="permission"
                                                value="tecnico.tareas.tipo.delete" id="tecnico.tareas.tipo.delete"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="tecnico.tareas.tipo.delete"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Tipo Tarea: Eliminar
                                            </label>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="z-0 flex justify-end p-4 border-t border-solid border--200 border-modal-bg">
                    <button wire:click.prevent="closeModal"
                        class="inline-flex whitespace-nowrap items-center borderfocus:outline-none focus:ring-2 focus:ring-offset-2 px-4 py-2  leading-5 rounded-md border-transparent  border-solid border-indigo-500 font-normal transition ease-in-out duration-150 text-indigo-500 hover:bg-indigo-200 shadow-inner focus:ring-indigo-500 mr-3 text-sm"
                        type="button">
                        Cancelar
                    </button>
                    <button wire:click.prevent="save"
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
