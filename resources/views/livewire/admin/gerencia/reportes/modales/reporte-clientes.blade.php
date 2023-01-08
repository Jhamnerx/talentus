<div>
    <div x-data="{ modalReporte: @entangle('modalReporte') }">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalReporte"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalReporte"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-1/3 max-h-full"
                @keydown.escape.window="modalReporte = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">REPORTE DE CLIENTES</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalReporte = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <form autocomplete="off" autocapitalize="true">


                    <div class="px-8 py-5 bg-white sm:p-6 divide-y">

                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12 md:col-span-6 gap-2">
                                <label class="block text-sm font-medium mb-1" for="plataforma">Solo Activos:
                                </label>
                                <div class="flex flex-wrap items-center">


                                    <div class="">
                                        <label class=" flex items-center">
                                            <input type="checkbox" name="radio-buttons" class="form-radio w-6 h-6"
                                                wire:model="is_active" value="true" />
                                            {{-- <span class="text-sm ml-2">{{$tecnico->name}}</span> --}}
                                        </label>
                                    </div>


                                </div>
                            </div>
                            <div class="col-span-12">
                                <label
                                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                    <div>OPCIONES PARA EXPORTAR: </div>

                                </label>
                                <div class="flex flex-wrap items-center justify-center -m-1.5">
                                    <div class="flex flex-wrap pt-2 -space-x-px gap-3">
                                        <button wire:click.prevent="exportToPdf"
                                            class="btn bg-white border-slate-200 hover:bg-slate-50 text-slate-600 hover:text-indigo-600 rounded-none first:rounded-l last:rounded-r">PDF</button>
                                    </div>
                                </div>

                            </div>
                            <div class="col-span-12">
                                <div class="mb-1 text-center w-full" wire:loading wire:target="exportToPdf">

                                    <div class='loader-download'>
                                        <div class='loader--dot-download'></div>
                                        <div class='loader--dot-download'></div>
                                        <div class='loader--dot-download'></div>
                                        <div class='loader--dot-download'></div>
                                        <div class='loader--dot-download'></div>
                                        <div class='loader--dot-download'></div>
                                        <div class='loader--text-download'></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            wire:click="closeModal">Cerrar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End -->

</div>
