<div>

    <!-- Basic Modal -->

    <!-- Start -->
    <div x-data="{ openModalEdit: @entangle('openModalEdit') }">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="openModalEdit"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="editar-basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-10"
            role="dialog" aria-modal="true" x-show="openModalEdit"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg text-center overflow-auto w-full md:w-3/4 lg:w-3/4 xl:w-3/4 2xl:w-3/4 max-h-full"
                @keydown.escape.window="openModalEdit = false">
                <div
                    class="inline-block align-middle w-full bg-white rounded-lg text-left overflow-hidden relative shadow-xl transition-all my-4">
                    <div
                        class="flex items-center justify-between px-6 py-4 text-lg font-medium text-black border-b border-gray-200 border-solid">
                        <div class="flex justify-between w-full">
                            Editar Rol {{$name}}
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

                                    <input name="name" wire:model="name" type="text"
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
                                            <input name="permission[]" wire:model="permission" id="editar-ver-categoria"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="ver-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">

                                            <label for="editar-ver-categoria"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver categoria
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                id="editar-crear-categoria" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="crear-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-categoria"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear categoria
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                id="editar-editar-categoria" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="editar-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-categoria"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar categoria
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                id="editar-cambiar.estado-categoria" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="cambiar.estado-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-cambiar.estado-categoria"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estado categoria
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                id="editar-eliminar-categoria" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                                                value="eliminar-categoria">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-categoria"
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
                                            <input name="permission[]" wire:model="permission" value="ver-producto"
                                                id="editar-ver-producto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-producto"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="crear-producto"
                                                id="editar-crear-producto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-producto"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="editar-producto"
                                                id="editar-editar-producto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-producto"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="cambiar.estado-producto" id="editar-cambiar.estado-producto"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-cambiar.estado-producto"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estado producto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="eliminar-producto"
                                                id="editar-eliminar-producto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-producto"
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
                                            <input name="permission[]" wire:model="permission" value="ver-sim_card"
                                                id="editar-ver-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver sim y lineas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="crear-sim_card"
                                                id="editar-crear-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear sim y lineas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="editar-sim_card"
                                                id="editar-editar-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar sim y lineas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar.numero-sim_card" id="editar-asignar.linea-sim_card"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-asignar.linea-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                asignar linea
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="asignar.linea-sim_card" id="editar-eliminar.numero-sim_card"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar.numero-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar numero de sim card
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="eliminar-sim_card"
                                                id="editar-eliminar-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="ver.cambios-sim_card" id="editar-ver.cambios-sim_card"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver.cambios-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver cambios sim card
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="importar-sim_card"
                                                id="editar-importar-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-importar-sim_card"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                importar sim card
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="exportar-sim_card"
                                                id="editar-exportar-sim_card" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-exportar-sim_card"
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
                                            <input name="permission[]" wire:model="permission" value="ver-dispositivo"
                                                id="editar-ver-dispositivo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="ver.modelos-dispositivo" id="editar-ver.modelos-dispositivo"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver.modelos-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver modelos dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="crear-dispositivo"
                                                id="editar-crear-dispositivo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="editar-dispositivo" id="editar-editar-dispositivo"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar dispositivo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-dispositivo" id="editar-eliminar-dispositivo"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar dispositivo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="importar-dispositivo" id="editar-importar-dispositivo"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-importar-dispositivo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                importar dispositivos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="exportar-dispositivo" id="editar-exportar-dispositivo"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-exportar-dispositivo"
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
                                            <input name="permission[]" wire:model="permission" value="ver-guias"
                                                id="editar-ver-guias" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-guias"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver guias
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="crear-guias"
                                                id="editar-crear-guias" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-guias"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear guias
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="editar-guias"
                                                id="editar-editar-guias" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-guias"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar guias
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="detalle-guias"
                                                id="editar-detalle-guias" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-detalle-guias"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver detalle guias
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="eliminar-guias"
                                                id="editar-eliminar-guias" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-guias"
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
                                            <input name="permission[]" wire:model="permission" value="ver-cliente"
                                                id="editar-ver-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">ver clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="crear-cliente"
                                                id="editar-crear-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">crear clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="editar-cliente"
                                                id="editar-editar-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">editar
                                                clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="cambiar.estado-cliente" id="editar-cambiar.estado-cliente"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-cambiar.estado-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estados clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="eliminar-cliente"
                                                id="editar-eliminar-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="exportar-cliente"
                                                id="editar-xportar-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-xportar-cliente"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                exportar clientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="importar-cliente"
                                                id="editar-importar-cliente" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-importar-cliente"
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
                                            <input name="permission[]" wire:model="permission" value="ver-contacto"
                                                id="editar-ver-contacto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-contacto"
                                                class="font-medium text-gray-600 cursor-pointer">ver contacto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="crear-contacto"
                                                id="editar-crear-contacto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-contacto"
                                                class="font-medium text-gray-600 cursor-pointer">crear contacto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="editar-contacto"
                                                id="editar-editar-contacto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-contacto"
                                                class="font-medium text-gray-600 cursor-pointer">editar
                                                contacto
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="eliminar-contacto"
                                                id="editar-eliminar-contacto" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-contacto"
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
                                            <input name="permission[]" wire:model="permission" value="ver-proveedor"
                                                id="editar-ver-proveedor" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">ver proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="crear-proveedor"
                                                id="editar-crear-proveedor" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">crear proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                id="editar-editar-proveedor" value="editar-proveedor" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">editar proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                id="editar-cambiar.estado-proveedor" value="cambiar.estado-proveedor"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-cambiar.estado-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">cambiar
                                                estado
                                                proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                id="editar-exportar-proveedor" value="exportar-proveedor"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-exportar-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                exportar proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                id="editar-importar-proveedor" value="importar-proveedor"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-importar-proveedor"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                importar proveedor
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-proveedor" id="editar-eliminar-proveedor"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-proveedor"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="ver-compras_facturas" id="editar-ver-compras_facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-compras_facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver facturas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="crear-compras_facturas" id="editar-crear-compras_facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-compras_facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear facturas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="editar-compras_facturas" id="editar-editar-compras_facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-compras_facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-compras_facturas" id="editar-eliminar-compras_facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-compras_facturas"
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
                                            <input name="permission[]" wire:model="permission" value="ver-cotizaciones"
                                                id="editar-ver-cotizaciones" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="crear-cotizaciones" id="editar-crear-cotizaciones"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="editar-cotizaciones" id="editar-editar-cotizaciones"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-cotizaciones" id="editar-eliminar-cotizaciones"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="convertir-cotizaciones" id="editar-convertir-cotizaciones"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-convertir-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                convertir cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="enviar-cotizaciones" id="editar-enviar-cotizaciones"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-enviar-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar cotizaciones
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="estados-cotizaciones" id="editar-estados-cotizaciones"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-estados-cotizaciones"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estados
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="descargar-cotizaciones" id="editar-descargar-cotizaciones"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-descargar-cotizaciones"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="ver-ventas-facturas" id="editar-ver-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver facturas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="crear-ventas-facturas" id="editar-crear-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear facturas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="editar-ventas-facturas" id="editar-editar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-ventas-facturas" id="editar-eliminar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="exportar-ventas-facturas" id="editar-exportar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-exportar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                exportar facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="enviar-ventas-facturas" id="editar-enviar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-enviar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="enviar-ventas-facturas" id="editar-enviar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-enviar-ventas-facturas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estados facturas</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="descargar-ventas-facturas" id="editar-descargar-ventas-facturas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-descargar-ventas-facturas"
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
                                            <input name="permission[]" wire:model="permission" value="ver-recibo"
                                                id="editar-ver-recibo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-recibo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver recibos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="crear-recibo"
                                                id="editar-crear-recibo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-recibo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear recibo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="editar-recibo"
                                                id="editar-editar-recibo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-recibo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar recibo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="eliminar-recibo"
                                                id="editar-eliminar-recibo" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-recibo"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                eliminar recibo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="enviar-recibos"
                                                id="editar-enviar-recibos" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-enviar-recibos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar recibos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="reportes-recibos"
                                                id="editar-estados-recibos" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-estados-recibos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estado recibos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="reportes-recibos"
                                                id="editar-reportes-recibos" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-reportes-recibos"
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
                                            <input name="permission[]" wire:model="permission" value="ver-contrato"
                                                variant="indigo" type="checkbox" id="editar-ver-contrato"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="editar-crear-contrato"
                                                wire:model="permission" value="crear-contrato" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission" value="editar-contrato"
                                                id="editar-editar-contrato" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="descargar-contrato" id="editar-descargar-contrato"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-descargar-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="caracteristicas-contrato" id="editar-caracteristicas-contrato"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-caracteristicas-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar caracteristicas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="cambiar.estado-contrato" id="editar-cambiar.estado-contrato"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-cambiar.estado-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estado contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="editar-enviar-contrato"
                                                wire:model="permission" value="enviar-contrato" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-enviar-contrato"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar contrato
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="editar-crear-registro-contrato"
                                                wire:model="permission" value="crear-registro-contrato" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-registro-contrato"
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
                                            <input name="permission[]" id="editar-ver-vehiculos-vehiculos"
                                                wire:model="permission" value="ver-vehiculos-vehiculos" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-vehiculos-vehiculos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver vehiculos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" id="editar-crear-vehiculos-vehiculos"
                                                wire:model="permission" value="crear-vehiculos-vehiculos"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-vehiculos-vehiculos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear vehiculos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="editar-vehiculos-vehiculos"
                                                id="editar-editar-vehiculos-vehiculos" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-vehiculos-vehiculos"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar vehiculos
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-vehiculos-vehiculos"
                                                id="editar-eliminar-vehiculos-vehiculos" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-vehiculos-vehiculos"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="ver-vehiculos-flotas" id="editar-ver-vehiculos-flotas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-vehiculos-flotas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver flotas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="crear-vehiculos-flotas" id="editar-crear-vehiculos-flotas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-vehiculos-flotas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear flotas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="editar-vehiculos-flotas" id="editar-editar-vehiculos-flotas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-vehiculos-flotas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar flotas
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-vehiculos-flotas" id="editar-eliminar-vehiculos-flotas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-vehiculos-flotas"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="ver-vehiculos-reportes" id="editar-ver-vehiculos-reportes"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-vehiculos-reportes"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver reportes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="crear-vehiculos-reportes" id="editar-crear-vehiculos-reportes"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-vehiculos-reportes"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear reportes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="editar-vehiculos-reportes" id="editar-editar-vehiculos-reportes"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-vehiculos-reportes"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar reportes
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-vehiculos-reportes"
                                                id="editar-eliminar-vehiculos-reportes" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-vehiculos-reportes"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="ver-certificados-actas" id="editar-ver-certificados-actas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver actas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="crear-certificados-actas" id="editar-crear-certificados-actas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear actas
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="editar-certificados-actas" id="editar-editar-certificados-actas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar acta
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="descargar-certificados-actas"
                                                id="editar-descargar-certificados-actas" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-descargar-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar acta
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="enviar-certificados-actas" id="editar-enviar-certificados-actas"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-enviar-certificados-actas"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar acta
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-certificados-actas"
                                                id="editar-eliminar-certificados-actas" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-certificados-actas"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="ver-certificados-gps" id="editar-ver-certificados-gps"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="crear-certificados-gps" id="editar-crear-certificados-gps"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="editar-certificados-gps" id="editar-editar-certificados-gps"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="descargar-certificados-gps"
                                                id="editar-descargar-certificados-gps" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-descargar-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="enviar-certificados-gps" id="editar-enviar-certificados-gps"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-enviar-certificados-gps"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar certificado
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-certificados-gps" id="editar-eliminar-certificados-gps"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-certificados-gps"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="ver-certificados-velocimetros"
                                                id="editar-ver-certificados-velocimetros" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-ver-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="crear-certificados-velocimetros"
                                                id="editar-crear-certificados-velocimetros" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-crear-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="editar-certificados-velocimetros"
                                                id="editar-editar-certificados-velocimetros" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-editar-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="descargar-certificados-velocimetros"
                                                id="editar-descargar-certificados-velocimetros" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-descargar-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="enviar-certificados-velocimetros"
                                                id="editar-enviar-certificados-velocimetros" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-enviar-certificados-velocimetros"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                enviar cert. velocimetro
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="eliminar-certificados-velocimetros"
                                                id="editar-eliminar-certificados-velocimetros" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-eliminar-certificados-velocimetros"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.solicitudes.index" id="editar-admin.solicitudes.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.solicitudes.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver solicitudes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.solicitudes.finalize"
                                                id="editar-admin.solicitudes.finalize" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.solicitudes.finalize"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.reportes.index" id="editar-admin.reportes.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.reportes.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver reportes y descargar
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.reportes.logs.index" id="editar-admin.reportes.logs.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.reportes.logs.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Ver logs y cambios
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.reportes.logs.actions"
                                                id="editar-admin.reportes.logs.actions" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.reportes.logs.actions"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.usuarios.index" id="editar-admin.usuarios.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.usuarios.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver usuarios
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.usuarios.create" id="editar-admin.usuarios.create"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.usuarios.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear usuarios
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.usuarios.edit" id="editar-admin.usuarios.edit"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.usuarios.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar usuarios
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.usuarios.status" id="editar-admin.usuarios.status"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.usuarios.status"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                cambiar estado usuarios
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.usuarios.delete" id="editar-admin.usuarios.delete"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.usuarios.delete"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.cobros.index" id="editar-admin.cobros.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.cobros.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver cobros
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.cobros.create" id="editar-admin.cobros.create"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.cobros.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear cobros
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                id="editar-admin.cobros.edit" value="admin.cobros.edit" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.cobros.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar cobros
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.cobros.delete" id="editar-admin.cobros.delete"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.cobros.delete"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.payments.index" id="editar-admin.payments.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.payments.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver pagos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.payments.create" id="editar-admin.payments.create"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.payments.create"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.ciudades.index"
                                                id="editar-admin.settings.ciudades.index" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.ciudades.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver ciudades
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.ciudades.create"
                                                id="editar-admin.settings.ciudades.create" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.ciudades.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear ciudades
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.ciudades.edit"
                                                id="editar-admin.settings.ciudades.edit" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.ciudades.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar ciudades
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.ciudades.delete"
                                                id="editar-admin.settings.ciudades.delete" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.ciudades.delete"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.roles.index"
                                                id="editar-admin.settings.roles.index" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.roles.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver roles
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.roles.create"
                                                id="editar-admin.settings.roles.create" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.roles.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                crear roles
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.roles.edit" id="editar-admin.settings.roles.edit"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.roles.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar roles
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.roles.delete"
                                                id="editar-admin.settings.roles.delete" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.roles.delete"
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
                                            <input name="permission[]" wire:model="permission"
                                                id="editar-admin.settings.plantilla.index"
                                                value="admin.settings.plantilla.index" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.plantilla.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver informacion
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.plantilla.informacion.edit"
                                                id="editar-admin.settings.plantilla.informacion.edit" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.plantilla.informacion.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                editar informacion
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.plantilla.sunat.edit"
                                                id="editar-admin.settings.plantilla.sunat.edit" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.plantilla.sunat.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Actualizar Accesos Sunat
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.plantilla.series.edit"
                                                id="editar-admin.settings.plantilla.series.edit" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.plantilla.series.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Actualizar series
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="admin.settings.plantilla.images.edit"
                                                id="editar-admin.settings.plantilla.images.edi" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-admin.settings.plantilla.images.edi"
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
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.index" id="editar-tecnico.tareas.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                ver modulo
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.reportes" id="editar-tecnico.tareas.reportes"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.reportes"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                descargar reportes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.cards" id="editar-tecnico.tareas.cards"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.cards"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Ver resumenes tabla
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.cards.sin-leer.actions"
                                                id="editar-tecnico.tareas.cards.sin-leer.actions" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.cards.sin-leer.actions"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Acciones: Tabla Sin Leer
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.cards.complete.actions"
                                                id="editar-tecnico.tareas.cards.complete.actions" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.cards.complete.actions"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Acciones: Tabla Completados
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.cards.pendient.actions"
                                                id="editar-tecnico.tareas.cards.pendient.actions" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.cards.pendient.actions"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Acciones: Tabla Pendientes
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.cards.canceled.actions"
                                                id="editar-tecnico.tareas.cards.canceled.actions" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.cards.canceled.actions"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Acciones: Tabla Cancelados
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.tecnicos.admin"
                                                id="editar-tecnico.tareas.tecnicos.admin" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.tecnicos.admin"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Administrar Tecnicos
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.tabla-historial"
                                                id="editar-tecnico.tareas.tabla-historial" variant="indigo"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.tabla-historial"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Ver Tabla Historial
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.create" id="editar-tecnico.tareas.create"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.create"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Crear Tarea
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.edit" id="editar-tecnico.tareas.edit"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.edit"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Editar Tarea
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.delete" id="editar-tecnico.tareas.delete"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.delete"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Eliminar Tarea
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.action.pdf" id="editar-tecnico.tareas.action.pdf"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.action.pdf"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Accion: Descargar PDF
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.action.wsp" id="editar-tecnico.tareas.action.wsp"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.action.wsp"
                                                class="font-medium text-gray-800 cursor-pointer">
                                                Accion: Enviar WhatsApp
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.tipo.index" id="editar-tecnico.tareas.tipo.index"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.tipo.index"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Tipo Tarea: Ver
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.tipo.create"
                                                id="editar-tecnico.tareas.tipo.create" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.tipo.create"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Tipo Tarea: Crear
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.tipo.edit" id="editar-tecnico.tareas.tipo.edit"
                                                variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.tipo.edit"
                                                class="font-medium text-gray-600 cursor-pointer">
                                                Tipo Tarea: Editar
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="relative flex items-start" variant="indigo">
                                        <div class="flex items-center h-5">
                                            <input name="permission[]" wire:model="permission"
                                                value="tecnico.tareas.tipo.delete"
                                                id="editar-tecnico.tareas.tipo.delete" variant="indigo" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="editar-tecnico.tareas.tipo.delete"
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
                    <button wire:click.prevent="update"
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
