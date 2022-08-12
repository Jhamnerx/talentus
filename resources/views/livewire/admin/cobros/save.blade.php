<div class="px-4 py-2 bg-gray-50 sm:p-6">
    {!! Form::open(['route' => 'admin.ventas.facturas.store', 'class' => 'formularioFactura']) !!}
    <div class="grid grid-cols-12 gap-2">


        <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-4 gap-2">
            {{-- CLIENTE --}}
            <div class="col-span-12 mb-5" wire:ignore>

                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Cliente <span class="text-sm text-red-500"> * </span></div>
                </label>

                <select name="clientes_id" id="" class="form-select w-full clientes_id pl-3" required>

                </select>
                @error('clientes_id')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- ... -->
            {{-- FECHA CADUCIDAD --}}
            <div class="col-span-6 gap-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Fecha de vencimiento: <span class="text-sm text-red-500" style="display: none;"> *
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
                    <input name="fecha_vencimiento" type="text"
                        class="form-input fechaVencimiento valid:border-emerald-300
                    required:border-rose-300 invalid:border-rose-300 peer font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block w-full sm:text-sm border-gray-200 rounded-md text-black input dark:focus:border-blue-500"
                        placeholder="Selecciona la fecha">
                </div>
                @error('fecha_vencimiento')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-red-600 lg:pl-6">

            <div class="col-span-12 sm:col-span-6">
                <label class="block text-sm font-medium mb-1" for="vehiculos_id">Vehiculo: <span
                        class="text-rose-500">*</span></label>

                <div class="relative" lang="es" wire:ignore>


                    <select id="vehiculos_id" name="vehiculos_id" class="vehiculos_id w-full form-input pl-9 "
                        required></select>



                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                        <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path d="M11,45H5a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,11,45Z"
                                    fill="#363636"></path>
                                <path d="M43,45H37a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,43,45Z"
                                    fill="#363636"></path>
                                <path d="M42,21,40.415,7.533A4,4,0,0,0,36.443,4H11.557A4,4,0,0,0,7.585,7.533L6,21Z"
                                    fill="#e3e3e3"></path>
                                <path
                                    d="M42,22a1,1,0,0,1-.992-.883L39.422,7.649A3,3,0,0,0,36.442,5H11.558a3,3,0,0,0-2.98,2.649L6.993,21.117a1,1,0,0,1-1.986-.234L6.592,7.415A5,5,0,0,1,11.558,3H36.442a5,5,0,0,1,4.966,4.415l1.585,13.468a1,1,0,0,1-.876,1.11A.945.945,0,0,1,42,22Z"
                                    fill="#38a838"></path>
                                <path d="M46,38H2a1,1,0,0,1-1-1V26a6,6,0,0,1,6-6H41a6,6,0,0,1,6,6V37A1,1,0,0,1,46,38Z"
                                    fill="#78d478"></path>
                                <circle cx="40" cy="27" r="3" fill="#fff">
                                </circle>
                                <circle cx="8" cy="27" r="3" fill="#fff">
                                </circle>
                                <path d="M31,31H17a2,2,0,0,1,0-4H31a2,2,0,0,1,0,4Z" fill="#363636">
                                </path>
                                <path d="M1,34H47a0,0,0,0,1,0,0v3a1,1,0,0,1-1,1H2a1,1,0,0,1-1-1V34A0,0,0,0,1,1,34Z"
                                    fill="#49c549"></path>
                                <circle cx="8" cy="34" r="2" fill="#f7bf26">
                                </circle>
                                <circle cx="40" cy="34" r="2" fill="#f7bf26">
                                </circle>
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
            <div class="col-span-12">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Nota
                    </div>
                    <!---->
                </label>
                <textarea class="form-input w-full px-4 py-3" name="nota" id="" cols="30" rows="5"
                    placeholder="Ingresar nota (opcional)"></textarea>
            </div>
            <!-- ... -->

        </div>

    </div>
    <div class="px-4 py-3 text-right sm:px-6">
        {!! Form::submit('GUARDAR', [
            'class' => 'btn bg-emerald-500 hover:bg-emerald-600 focus:outline-none
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            focus:ring-2 focus:ring-offset-2
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            focus:ring-emerald-600 text-white',
        ]) !!}

    </div>
    {!! Form::close() !!}


</div>
@section('js')
    <script>
        // INICIALIZAR LOS INPUTS DE FECHA
        $(document).ready(function() {
            cont = 0;
            detalles = 0;
            flatpickr('.fechaVencimiento', {
                mode: 'single',
                defaultDate: new Date().fp_incr(1),
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
                        //type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function(data, params) {

                    // console.log(data.suggestions);
                    var suggestions = $.map(data.suggestions, function(obj) {

                        obj.id = obj.id || obj.data; // replace pk with your identifier
                        obj.text = obj.value; // replace pk with your identifier
                        // console.log(obj);
                        return obj;

                    });
                    // console.log(suggestions);
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {

                        results: suggestions,

                    };

                },


            }
        });
        $('.vehiculos_id').select2({
            placeholder: '    Buscar un Vehiculo',
            language: "es",
            selectionCssClass: 'pl-9',
            width: '100%',

        });

        window.addEventListener('dataVehiculos', event => {
            // $('.vehiculos_id').select2('destroy');
            data = []
            data = event.detail.data;
            //  $('.vehiculos_id').innerHTML = "";

            $(".vehiculos_id option").remove();

            $('.vehiculos_id').select2({
                placeholder: '    Buscar un Vehiculo',
                language: "es",
                selectionCssClass: 'pl-9',
                width: '100%',
                data: data
            });


        })





        $('.clientes_id').on('select2:select', function(e) {
            var data = e.params.data;
            console.log(data.id);
            @this.set('cliente', data.id)
        });
    </script>
@endsection
