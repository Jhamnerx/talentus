<div>

    <!-- Basic Modal -->

    <!-- Start -->
    <div x-data="{ modalOpen: @entangle('modalOpen') }">

        <div class="relative inline-flex">

            <!-- Create button -->

            <button wire:click="openModal" aria-controls="basic-modal"
                class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="hidden xs:block ml-2">Añadir Flota</span>
            </button>



        </div>
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalOpen" x-transition:enter="transition ease-in-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-1/3 max-h-full"
                @keydown.escape.window="modalOpen = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">CREAR FLOTA</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->
                <div class="px-8 py-5 bg-white sm:p-6">

                    <div class="grid grid-cols-12 gap-6">

                        <div class="col-span-12 sm:col-span-12">

                            <label class="block text-sm font-medium mb-1" for="placa">Nombre: <span
                                    class="text-rose-500">*</span></label>
                            <div class="relative">

                                <input wire:model="nombre" placeholder="NOMBRE DE FLOTA" name="nombre" id="nombre"
                                    class="form-input w-full pl-9 valid:border-emerald-300
                            required:border-rose-300 invalid:border-rose-300 peer" type="text" />


                                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                        <g stroke-linecap="square" stroke-miterlimit="10" fill="none"
                                            stroke="currentColor" stroke-linejoin="miter" class="nc-icon-wrapper">
                                            <line data-cap="butt" x1="32" y1="29" x2="41" y2="19" stroke-linecap="butt">
                                            </line>
                                            <path data-cap="butt"
                                                d="M57,29,52.829,8.98A5,5,0,0,0,47.934,5H16.066a5,5,0,0,0-4.895,3.98L7,29"
                                                stroke-linecap="butt"></path>
                                            <polyline points="16 54 16 58 6 58 6 54"></polyline>
                                            <path
                                                d="M62,49H2V36.066a4.99,4.99,0,0,1,1.465-3.532L7,29H57l3.535,3.535A5,5,0,0,1,62,36.071Z">
                                            </path>
                                            <circle cx="11" cy="40" r="3"></circle>
                                            <polyline points="58 54 58 58 48 58 48 54"></polyline>
                                            <circle cx="53" cy="40" r="3"></circle>
                                            <line x1="25" y1="40" x2="39" y2="40"></line>
                                        </g>
                                    </svg>

                                </div>
                            </div>
                            @error('nombre')

                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{$message}}
                            </p>

                            @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-12">

                            <label class="block text-sm font-medium mb-1" for="clientes_id">Cliente:</label>
                            <div class="relative">
                                <input wire:model="nombre_cliente" placeholder="BUSCAR CLIENTE" id="cliente"
                                    class="form-input w-full pl-9" type="text" />

                                <input type="hidden" id="clientes_id" name="clientes_id" wire:model="clientes_id">

                                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                    <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                        <g stroke-linecap="square" stroke-miterlimit="10" fill="none"
                                            stroke="currentColor" stroke-linejoin="miter" class="nc-icon-wrapper">
                                            <path
                                                d="M19,20h-6 c-4.971,0-9,4.029-9,9v0c0,0,4.5,2,12,2s12-2,12-2v0C28,24.029,23.971,20,19,20z">
                                            </path>
                                            <path d="M9,8c0-3.866,3.134-7,7-7 s7,3.134,7,7s-3.134,8-7,8S9,11.866,9,8z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            @error('clientes_id')

                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{$message}}
                            </p>

                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-12">

                            <label class="block text-sm font-medium mb-1" for="descripcion">DESCRIPCIÓN:</label>
                            <div class="relative">
                                <textarea class="form-input w-full pl-9" wire:model="descripcion" name="descripcion"
                                    id="descripcion" rows="2" placeholder="Ingresar Breve Descripcíon"></textarea>
                                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                    <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                        <g class="nc-icon-wrapper">
                                            <path
                                                d="M15,33,6.293,30.274a1,1,0,0,0-.255.433l-4,14a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l14-4a.994.994,0,0,0,.433-.255Z"
                                                fill="#fbe5d5"></path>
                                            <path d="M28.586,7.981,6.293,30.274,17.707,41.688,40,19.4Z" fill="#ff7163">
                                            </path>
                                            <path
                                                d="M3.3,40.3l-1.26,4.409a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l4.409-1.26Z"
                                                fill="#4c4c4c"></path>
                                            <path d="M34.3,13.7,12.01,35.99l5.7,5.7L40,19.4Z" fill="#f74b3b"></path>
                                            <path
                                                d="M44.828,8.91,39.07,3.153a4.093,4.093,0,0,0-5.656,0l-4.63,4.631L40.2,19.2l4.63-4.631a4,4,0,0,0,0-5.657Z"
                                                fill="#3d6c7b"></path>
                                            <rect x="33.294" y="5.618" width="2" height="16.142"
                                                transform="translate(0.365 28.258) rotate(-45)" fill="#2a4b55"></rect>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>

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