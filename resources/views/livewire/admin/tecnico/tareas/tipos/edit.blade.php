<div>
    <div x-data="{ modalEdit: @entangle('modalEdit').live }">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalEdit"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalEdit" x-transition:enter="transition ease-in-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-1/3 max-h-full"
                @keydown.escape.window="modalEdit = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">AÑADIR TIPO TAREA</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalEdit = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->

                <form autocomplete="off" autocapitalize="true">


                    <div class="px-8 py-5 bg-white sm:p-6">

                        <div class="grid grid-cols-12 gap-6">

                            <div class="col-span-12 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="placa">Nombre: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative">

                                    <input wire:model.live="nombre" placeholder="Introduce el nombre" name="nombre"
                                        id="nombre"
                                        class="form-input w-full pl-9 valid:border-emerald-300
                            required:border-rose-300 invalid:border-rose-300 peer"
                                        type="text" required />


                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <g fill="none" class="nc-icon-wrapper">
                                                <path
                                                    d="M15 11V5l-3-3-3 3v2H3v14h18V11h-6zm-8 8H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm6 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm6 12h-2v-2h2v2zm0-4h-2v-2h2v2z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>

                                    </div>
                                </div>
                                @error('nombre')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="costo">Costo: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative">

                                    <input wire:model.live="costo" placeholder="Introduce el costo" name="costo"
                                        id="costo"
                                        class="form-input w-full pl-9 valid:border-emerald-300
                                                    required:border-rose-300 invalid:border-rose-300 peer"
                                        type="text" required />


                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                            <g stroke-linecap="round" fill="none" stroke="currentColor"
                                                stroke-linejoin="round" class="nc-icon-wrapper">
                                                <path d="M55,60,32,47,9,60V8a5,5,0,0,1,5-5H50a5,5,0,0,1,5,5Z"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('costo')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-3">

                                <label class="block text-sm font-medium mb-1" for="afecta_mantenimiento">Afecta
                                    mantenimiento? </label>
                                <x-form.toggle left-label="" lg wire:model.live="afecta_mantenimiento"
                                    value="1" />
                            </div>
                            <div class="col-span-12">
                                <x-form.badge flat positive label="%modelo_gps%" />
                                <x-form.badge flat negative label="%placa%" />
                                <x-form.badge flat warning label="%fecha%" />
                                <x-form.badge flat info label="%hora%" />
                                <x-form.badge flat dark label="%velo_modelo%" />
                            </div>

                            <div class="col-span-12">
                                <x-form.textarea wire:model.live="descripcion" label="Descripcion"
                                    placeholder="Instalación de GPS %modelo_gps% en vehículo: %placa%, Fecha instalación: %fecha% - Hora: %hora%" />
                            </div>
                        </div>

                    </div>
                </form>
                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            wire:click="closeModal">Cerrar</button>
                        <button wire:click.prevent='save'
                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Guardar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End -->

</div>
