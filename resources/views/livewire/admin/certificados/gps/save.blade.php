<div>

    <!-- Basic Modal -->
    <!-- Start -->
    <div x-data="{ modalSave: @entangle('openModalSave') }">


        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalSave"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalSave" x-transition:enter="transition ease-in-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-6/12 max-h-full"
                @keydown.escape.window="modalSave = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">CREAR CERTIFICADO GPS</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalSave = false">
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

                                <label class="block text-sm font-medium mb-1" for="numero">Numero: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative" wire:ignore lang="es">
                                    <input placeholder="Ejem. 205" maxlength="10" wire:model="numero" required
                                        name="fecha" type="text"
                                        class="form-input valid:border-emerald-300 required:border-rose-300 invalid:border-rose-300 peer font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block sm:text-sm border-gray-200 rounded-md text-black w-full">
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M11.631,36.841,1,26l3-3,8,5L35,4l3,2L14.65,36.653a2,2,0,0,1-2.8.379A2.062,2.062,0,0,1,11.631,36.841Z"
                                                    fill="#78d478"></path>
                                                <path d="M46,13H41a1,1,0,0,1,0-2h5a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                                </path>
                                                <path d="M46,22H34a1,1,0,0,1,0-2H46a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                                </path>
                                                <path d="M46,31H27a1,1,0,0,1,0-2H46a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                                </path>
                                                <path d="M46,40H20a1,1,0,0,1,0-2H46a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                                </path>
                                            </g>
                                        </svg>

                                    </div>
                                </div>
                                @error('numero')

                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    {{$message}}
                                </p>

                                @enderror

                            </div>

                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="vehiculos_id">Vehiculo: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative" wire:ignore lang="es">


                                    <select name="vehiculos_id" class="vehiculos_id w-full form-input pl-9 "
                                        required></select>

                                    @error('vehiculos_id')

                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{$message}}
                                    </p>

                                    @enderror

                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M11,45H5a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,11,45Z"
                                                    fill="#363636"></path>
                                                <path
                                                    d="M43,45H37a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,43,45Z"
                                                    fill="#363636"></path>
                                                <path
                                                    d="M42,21,40.415,7.533A4,4,0,0,0,36.443,4H11.557A4,4,0,0,0,7.585,7.533L6,21Z"
                                                    fill="#e3e3e3"></path>
                                                <path
                                                    d="M42,22a1,1,0,0,1-.992-.883L39.422,7.649A3,3,0,0,0,36.442,5H11.558a3,3,0,0,0-2.98,2.649L6.993,21.117a1,1,0,0,1-1.986-.234L6.592,7.415A5,5,0,0,1,11.558,3H36.442a5,5,0,0,1,4.966,4.415l1.585,13.468a1,1,0,0,1-.876,1.11A.945.945,0,0,1,42,22Z"
                                                    fill="#38a838"></path>
                                                <path
                                                    d="M46,38H2a1,1,0,0,1-1-1V26a6,6,0,0,1,6-6H41a6,6,0,0,1,6,6V37A1,1,0,0,1,46,38Z"
                                                    fill="#78d478"></path>
                                                <circle cx="40" cy="27" r="3" fill="#fff"></circle>
                                                <circle cx="8" cy="27" r="3" fill="#fff"></circle>
                                                <path d="M31,31H17a2,2,0,0,1,0-4H31a2,2,0,0,1,0,4Z" fill="#363636">
                                                </path>
                                                <path
                                                    d="M1,34H47a0,0,0,0,1,0,0v3a1,1,0,0,1-1,1H2a1,1,0,0,1-1-1V34A0,0,0,0,1,1,34Z"
                                                    fill="#49c549"></path>
                                                <circle cx="8" cy="34" r="2" fill="#f7bf26"></circle>
                                                <circle cx="40" cy="34" r="2" fill="#f7bf26"></circle>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('vehiculos_id')

                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    {{$message}}
                                </p>

                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="fecha_fin">Fin de Cobertura:
                                    <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <input placeholder="yyyy-mm-dd" maxlength="10" wire:model="fin_cobertura" required
                                        name="fecha_fin" type="text"
                                        class="form-input valid:border-emerald-300 required:border-rose-300 invalid:border-rose-300 peer inputDate font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block sm:text-sm border-gray-200 rounded-md text-black input w-full">
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path d="M2,41a5,5,0,0,0,5,5H41a5,5,0,0,0,5-5V16H2Z" fill="#e3e3e3">
                                                </path>
                                                <path d="M41,6H7a5,5,0,0,0-5,5v5H46V11A5,5,0,0,0,41,6Z" fill="#ff7163">
                                                </path>
                                                <path
                                                    d="M23.239,38.894H12.359V36.6c2.891-2.922,5.36-5.363,6.175-6.414,1.382-1.784,1.136-3.3.484-3.88-1.287-1.142-3.435-.085-4.913,1.139l-1.788-2.119a7.62,7.62,0,0,1,5.557-2.225c2.88,0,4.928,1.662,4.928,4.216a6.047,6.047,0,0,1-1.549,3.949c-.826,1.032-4.8,4.855-4.8,4.855h6.781Z"
                                                    fill="#aeaeae"></path>
                                                <path
                                                    d="M24.7,32.155q0-4.62,1.954-6.877A7.319,7.319,0,0,1,32.5,23.021a10.653,10.653,0,0,1,2.087.16V25.81a8.524,8.524,0,0,0-1.874-.213c-1.8,0-3.517.431-4.364,2.023a6.926,6.926,0,0,0-.628,2.842,4.211,4.211,0,0,1,3.513-1.809c2.937,0,4.449,2.015,4.449,4.929,0,3.271-1.916,5.4-5.3,5.4C26.6,38.979,24.7,36.12,24.7,32.155Zm5.621,4.194c1.545,0,2.182-1.16,2.182-2.725,0-1.461-.651-2.448-2.118-2.448a2.318,2.318,0,0,0-2.417,2.161C27.965,34.856,28.82,36.349,30.318,36.349Z"
                                                    fill="#aeaeae"></path>
                                                <path
                                                    d="M11.5,12A1.5,1.5,0,0,1,10,10.5v-7a1.5,1.5,0,0,1,3,0v7A1.5,1.5,0,0,1,11.5,12Z"
                                                    fill="#363636"></path>
                                                <path
                                                    d="M36.5,12A1.5,1.5,0,0,1,35,10.5v-7a1.5,1.5,0,0,1,3,0v7A1.5,1.5,0,0,1,36.5,12Z"
                                                    fill="#363636"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('fin_cobertura')

                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    {{$message}}
                                </p>

                                @enderror
                            </div>


                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="ciudades_id">Ciudad: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative" wire:ignore>

                                    <select class="form-input w-full pl-9 ciudades" name="ciudades_id" id="">
                                        {{-- <option value="">Selecciona una Ciudad:</option>
                                        @foreach ($ciudades as $ciudad)
                                        <option value="{{$ciudad->id}}">{{$ciudad->nombre}}</option> --}}
                                        {{--
                                        @endforeach --}}
                                    </select>



                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path d="M8,18V7A1,1,0,0,1,9,6h4a1,1,0,0,1,1,1v6.091Z" fill="#f74b3b">
                                                </path>
                                                <path d="M24,3,7,18.111V44a2,2,0,0,0,2,2H39a2,2,0,0,0,2-2V18.111Z"
                                                    fill="#e3e3e3"></path>
                                                <path
                                                    d="M46,24a1,1,0,0,1-.673-.26L24,4.351,2.673,23.74a1,1,0,0,1-1.346-1.481l22-20a1,1,0,0,1,1.346,0l22,20A1,1,0,0,1,46,24Z"
                                                    fill="#ff7163"></path>
                                                <path d="M28,33H20a1,1,0,0,0-1,1V46H29V34A1,1,0,0,0,28,33Z"
                                                    fill="#bf8c5a"></path>
                                                <path
                                                    d="M28,27H20a1,1,0,0,1-1-1V20a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1v6A1,1,0,0,1,28,27Z"
                                                    fill="#3aace9"></path>
                                                <path d="M14.314,46A7,7,0,1,0,1,43a6.932,6.932,0,0,0,.686,3Z"
                                                    fill="#78d478"></path>
                                                <path d="M46.314,46a7,7,0,1,0-12.628,0Z" fill="#78d478"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('ciudades_id')

                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    {{$message}}
                                </p>

                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-12 mt-4">
                                <span class="text-bold text-center mb-2">Caracteristicas:</span>
                                <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">


                                    <div class="m-2 w-full mt-2">
                                        <label for="fondo">Fondo:</label>
                                        <!-- Start -->
                                        <div class="flex items-center" x-data="{ checked: true }">
                                            <div class="form-switch">
                                                <input wire:model="fondo" type="checkbox" id="fondo-1" class="sr-only"
                                                    x-model="checked" />
                                                <label class="bg-slate-400" for="fondo-1">
                                                    <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                                    <span class="sr-only">fondo switch</span>
                                                </label>
                                            </div>
                                            <div class="text-sm text-slate-400 italic ml-2"
                                                x-text="checked ? 'Activado' : 'Desactivado'"></div>
                                        </div>
                                        <!-- End -->
                                    </div>
                                    <div class="m-2 w-full">
                                        <label for="sello">Sello:</label>
                                        <!-- Start -->
                                        <div class="flex items-center" x-data="{ checked: true }">
                                            <div class="form-switch">
                                                <input wire:model="sello" type="checkbox" id="sello-1" class="sr-only"
                                                    x-model="checked" />
                                                <label class="bg-slate-400" for="sello-1">
                                                    <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                                    <span class="sr-only">sello switch</span>
                                                </label>
                                            </div>
                                            <div class="text-sm text-slate-400 italic ml-2"
                                                x-text="checked ? 'Activado' : 'Desactivado'"></div>
                                        </div>
                                        <!-- End -->
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
                        <button wire:click.prevent="guardarCertificado()"
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
        minimumInputLength: 2,
        width: '100%',
        ajax: {
            url: '{{route("search.vehiculos")}}',
            dataType: 'json',
            delay: 250,
            cache: true,
            data: function (params) {

                var query = {
                    term: params.term,
                    //type: 'public'
                }
                //console.log(query);
                // Query parameters will be ?search=[term]&type=public
                return query;
            },
            processResults: function (data, params) {

               // console.log(data.suggestions);
                var suggestions = $.map(data.suggestions, function (obj) {

                    obj.id = obj.id || obj.value; // replace pk with your identifier
                    obj.text = obj.data; // replace pk with your identifier

                    return obj;

                });
                //console.log(data);
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {

                    results: suggestions,
    
                };
                
            },


        }
    });
    $('.ciudades').select2({
       placeholder: '    Selecciona una ciudad',
        language: "es",
        width: '100%',
        ajax: {
            url: '{{route("search.ciudades")}}',
            dataType: 'json',

            cache: true,
            data: function (params) {

                var query = {
                    term: params.term,
                    //type: 'public'
                }

                // Query parameters will be ?search=[term]&type=public
                return query;
            },
            processResults: function (data, params) {

               // console.log(data.suggestions);
                var suggestions = $.map(data.suggestions, function (obj) {

                    obj.id = obj.id || obj.value; // replace pk with your identifier
                    obj.text = obj.data; // replace pk with your identifier

                    return obj;

                });
                //console.log(data);
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {

                    results: suggestions,
    
                };
                
            },


        }
    });

$('.vehiculos_id').on('select2:select', function (e) {
    var data = e.params.data;
   // console.log(data.id);
    @this.set('vehiculos_id',data.id)
});


$('.ciudades').on('select2:select', function (e) {
    var data = e.params.data;
    //console.log(data.id);
    @this.set('ciudades_id',data.id)
});

</script>

@endpush
@endonce