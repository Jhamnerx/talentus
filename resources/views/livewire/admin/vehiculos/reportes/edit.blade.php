<div>
    <div x-data="{ modalEdit: @entangle('openModalEdit').live }">

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

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-6/12 max-h-full"
                @keydown.escape.window="modalEdit = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">EDITAR REPORTE</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalEdit = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <form autocomplete="off">
                    <!-- Modal content -->
                    <div class="px-8 py-5 bg-white sm:p-6">

                        <div class="grid grid-cols-12 gap-6">

                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="vehiculo">Vehiculo: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative" wire:ignore lang="es">


                                    <input class="form-input w-full pl-9" type="text" readonly wire:model.live='vehiculo'>

                                    @error('vehiculo')
                                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                            <g stroke-linecap="square" stroke-miterlimit="10" fill="none"
                                                stroke="currentColor" stroke-linejoin="miter" class="nc-icon-wrapper">
                                                <line data-cap="butt" x1="32" y1="29" x2="41"
                                                    y2="19" stroke-linecap="butt">
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
                                                <line x1="25" y1="40" x2="39" y2="40">
                                                </line>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('vehiculos_id')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="marca">Fecha Transmision:</label>
                                <div class="relative">
                                    <input maxlength="10" wire:model.live="fecha_t" required name="fecha" type="text"
                                        class="form-input valid:border-emerald-300
                                                            required:border-rose-300 invalid:border-rose-300 peer inputDate font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block sm:text-sm border-gray-200 rounded-md text-black input w-full"
                                        placeholder="Selecciona la fecha">
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <g fill="none" class="nc-icon-wrapper">
                                                <path
                                                    d="M10.08 10.86c.05-.33.16-.62.3-.87.14-.25.34-.46.59-.62.24-.15.54-.22.91-.23.23.01.44.05.63.13.2.09.38.21.52.36s.25.33.34.53c.09.2.13.42.14.64h1.79c-.02-.47-.11-.9-.28-1.29-.17-.39-.4-.73-.7-1.01-.3-.28-.66-.5-1.08-.66-.42-.16-.88-.23-1.39-.23-.65 0-1.22.11-1.7.34-.48.23-.88.53-1.2.92-.32.39-.56.84-.71 1.36-.15.52-.24 1.06-.24 1.64v.27c0 .58.08 1.12.23 1.64.15.52.39.97.71 1.35.32.38.72.69 1.2.91.48.22 1.05.34 1.7.34.47 0 .91-.08 1.32-.23.41-.15.77-.36 1.08-.63.31-.27.56-.58.74-.94.18-.36.29-.74.3-1.15h-1.79c-.01.21-.06.4-.15.58-.09.18-.21.33-.36.46s-.32.23-.52.3c-.19.07-.39.09-.6.1-.36-.01-.66-.08-.89-.23a1.75 1.75 0 0 1-.59-.62c-.14-.25-.25-.55-.3-.88a6.74 6.74 0 0 1-.08-1v-.27c0-.35.03-.68.08-1.01zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('fecha_t')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>



                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="numero">Hora Transmision: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative">

                                    <input maxlength="6" wire:model.live="hora_t" type="text"
                                        class="form-input w-full pl-9 hora_t" placeholder="Selecciona la Hora"
                                        required />



                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M46,21a1,1,0,0,1-1-1A17.018,17.018,0,0,0,28,3a1,1,0,0,1,0-2A19.021,19.021,0,0,1,47,20,1,1,0,0,1,46,21Z"
                                                    fill="#49c549"></path>
                                                <path
                                                    d="M38,21a1,1,0,0,1-1-1,9.011,9.011,0,0,0-9-9,1,1,0,0,1,0-2A11.013,11.013,0,0,1,39,20,1,1,0,0,1,38,21Z"
                                                    fill="#9ee09e"></path>
                                                <path
                                                    d="M31.376,29.175,27.79,33.658A37.835,37.835,0,0,1,14.343,20.212l4.483-3.586a3.047,3.047,0,0,0,.88-3.614l-4.087-9.2A3.045,3.045,0,0,0,12.068,2.1L4.29,4.115A3.066,3.066,0,0,0,2.029,7.5,45.2,45.2,0,0,0,40.5,45.971a3.062,3.062,0,0,0,3.383-2.26L45.9,35.932a3.047,3.047,0,0,0-1.712-3.551L34.99,28.3A3.046,3.046,0,0,0,31.376,29.175Z"
                                                    fill="#3d6c7b"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('hora_t')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>


                            <div class="col-span-12 sm:col-span-12 mt-4">
                                <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">
                                    <div class="">
                                        <button type="button" wire:click.prevent="changeStatus(1)"
                                            class="w-full text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">SOLUCIONAR</button>
                                    </div>
                                    <div>
                                        <button type="button" wire:click.prevent="changeStatus(2)"
                                            class="w-full text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                                            EN ESPERA
                                        </button>
                                    </div>
                                    <div class="">
                                        <button type="button" wire:click.prevent="changeStatus(3)"
                                            class="w-full text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">SOLUCIONADO</button>
                                    </div>



                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-12">

                                <label class="block text-sm font-medium mb-1" for="descripcion">Detalle:</label>
                                <div class="relative">
                                    <textarea wire:model.live="detalle" class="form-input w-full pl-9" name="descripcion" id="descripcion" rows="5"
                                        placeholder="Ingresar Breve Descripcíon"></textarea>
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M15,33,6.293,30.274a1,1,0,0,0-.255.433l-4,14a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l14-4a.994.994,0,0,0,.433-.255Z"
                                                    fill="#fbe5d5"></path>
                                                <path d="M28.586,7.981,6.293,30.274,17.707,41.688,40,19.4Z"
                                                    fill="#ff7163">
                                                </path>
                                                <path
                                                    d="M3.3,40.3l-1.26,4.409a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l4.409-1.26Z"
                                                    fill="#4c4c4c"></path>
                                                <path d="M34.3,13.7,12.01,35.99l5.7,5.7L40,19.4Z" fill="#f74b3b">
                                                </path>
                                                <path
                                                    d="M44.828,8.91,39.07,3.153a4.093,4.093,0,0,0-5.656,0l-4.63,4.631L40.2,19.2l4.63-4.631a4,4,0,0,0,0-5.657Z"
                                                    fill="#3d6c7b"></path>
                                                <rect x="33.294" y="5.618" width="2" height="16.142"
                                                    transform="translate(0.365 28.258) rotate(-45)" fill="#2a4b55">
                                                </rect>
                                            </g>
                                        </svg>
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
                            wire:click.prevent="closeModal">Cerrar</button>
                        <button wire:click.prevent="actualizarReporte()"
                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Guardar</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- End -->
</div>

@once
    @push('scripts')
        <script>
            $('.vehiculos_id').select2({
                placeholder: '    Buscar un Vehiculo',
                language: "es",
                selectionCssClass: 'pl-9',
                minimumInputLength: 2,
                width: '100%',
                ajax: {
                    url: '{{ route('search.vehiculos') }}',
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
            $('.vehiculos_id').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('vehiculos_id', data.id)
            });
        </script>
    @endpush
@endonce
