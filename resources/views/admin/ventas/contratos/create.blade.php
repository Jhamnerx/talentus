@extends('layouts.admin')
@section('ruta', 'ventas-contratos')
@section('contenido')
    <!-- Code block starts -->
    <div
        class="my-6 lg:my-12 container px-6 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
        <!-- Add customer button -->
        <a href="{{ route('admin.ventas.contratos.index') }}">
            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back w-5 h-5"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                </svg>
                <span class="hidden xs:block ml-2">Atras</span>
            </button>
        </a>
        <div>
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">CREAR CONTRATO</h4>
            <ul aria-label="current Status"
                class="flex flex-col md:flex-row items-start md:items-center text-gray-600 dark:text-gray-400 text-sm mt-3">
                <li class="flex items-center mr-4">
                    <div class="mr-1">
                        <img class="dark:hidden"
                            src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_with_sub_text_and_border-svg1.svg"
                            alt="Active">
                        <img class="dark:block hidden"
                            src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_with_sub_text_and_border-svg1dark.svg"
                            alt="Active">
                    </div>
                    <span>Active</span>
                </li>

            </ul>
        </div>
    </div>
    <!-- Code block ends -->


    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">

            <div class="mt-5 md:mt-0 md:col-span-3 col-span-3 mx-2 md:mx-6">

                {!! Form::open(['route' => 'admin.ventas.contratos.store', 'autocomplete' => 'off', 'files' => 'true']) !!}
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12 sm:col-span-4">
                                {!! Form::hidden('empresa_id', session('empresa')) !!}

                                {!! Html::decode(
                                    Form::label('clientes_id', 'Cliente: <span class="text-rose-500">*</span>', [
                                        'class' => 'block text-sm font-medium mb-1',
                                    ]),
                                ) !!}
                                {!! Form::select('clientes_id', [], null, ['class' => 'w-full clientes_id pl-3']) !!}

                                @error('clientes_id')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            <div class="col-span-12 sm:col-span-4">

                                <label class="block text-sm font-medium mb-1" for="fecha">Fecha:
                                    <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    {!! Form::text('fecha', null, [
                                        'placeholder' => 'yyyy-mm-dd',
                                        'class' => 'form-input
                                                                                                                                                                                                                                                                                                                                valid:border-emerald-300
                                                                                                                                                                                                                                                                                                                                required:border-rose-300 invalid:border-rose-300 peer fechaContrato font-base pl-8 py-2
                                                                                                                                                                                                                                                                                                                                outline-none focus:ring-primary-400
                                                                                                                                                                                                                                                                                                                                focus:outline-none focus:border-primary-400 block sm:text-sm border-gray-200 rounded-md
                                                                                                                                                                                                                                                                                                                                text-black input w-full',
                                        'maxlength' => '10',
                                        'required',
                                    ]) !!}

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
                                @error('fecha')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <label class="block text-sm font-medium mb-1" for="ciudades_id">Ciudad: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative" wire:ignore>

                                    <select class="form-select w-full pl-9 ciudades" name="ciudades_id" id="">

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
                                                <path d="M28,33H20a1,1,0,0,0-1,1V46H29V34A1,1,0,0,0,28,33Z" fill="#bf8c5a">
                                                </path>
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
                                        {{ $message }}
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
                                                <input value="1" name="fondo" type="checkbox" id="fondo-1"
                                                    class="sr-only fondo" x-model="checked" />
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
                                                <input value="1" name="sello" type="checkbox" id="sello-1"
                                                    class="sr-only" x-model="checked" />
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


                            <div class="col-span-12 sm:col-span-12 mt-4 lg:flex lg:items-center lg:justify-between">
                                <div class="flex-1 min-w-0">
                                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Lista de
                                        Vehiculos</h2>
                                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            <!-- Heroicon name: solid/briefcase -->
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                    clip-rule="evenodd" />
                                                <path
                                                    d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                            </svg>
                                            Placa
                                        </div>

                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            <!-- Heroicon name: solid/currency-dollar -->
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Plan: $140k
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3 mb-5">
                                <div class="flex -mx-1 border-b px-2 py-2 ">

                                    <div class="flex-auto px-5 xl:w-32 text-left">
                                        <p class="text-gray-800 uppercase tracking-wide text-sm font-bold">Placa</p>
                                    </div>

                                    <div class="flex-auto xl:w-28 text-left">
                                        <p class="leading-none">
                                            <span
                                                class="block uppercase tracking-wide text-sm font-bold text-gray-800">Plan</span>
                                        </p>
                                    </div>



                                    <div class="flex-auto xl:w-20 text-center">
                                    </div>
                                </div>

                                @livewire('admin.ventas.contratos.modal-vehiculos')

                                <div class="py-3 w-20 text-center">
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            {!! Form::submit('GUARDAR', [
                                'class' => 'btnGuardarContrato btn bg-emerald-500
                                                                                                                                                                                                                                                        hover:bg-emerald-600
                                                                                                                                                                                                                                                        focus:outline-none
                                                                                                                                                                                                                                                        focus:ring-2 focus:ring-offset-2
                                                                                                                                                                                                                                                        focus:ring-emerald-600 text-white',
                            ]) !!}

                        </div>
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>



@endsection

@section('js')

    <script>
        window.addEventListener('vehiculo-add', event => {

            console.log(event.detail.vehiculo);

        })

        var estado = $(".fondo").checked = true | false;
    </script>

    <script>
        function agregarVehiculo(vehiculo) {

            var plan = 30;
            if (localStorage.getItem("listaVehiculosContrato") == null) {

                listado = [];

            } else {

                var listaVehiculosContrato = JSON.parse(localStorage.getItem("listaVehiculosContrato"));

                for (var i = 0; i < listaVehiculosContrato.length; i++) {

                    if (listaVehiculosContrato[i]["idvehiculo"] == vehiculo.id) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ya existe',
                            text: 'El vehiculo ya esta agregado',
                            showConfirmButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Cerrar"

                        })

                        return;

                    }
                }

                //listado.concat(localStorage.getItem("listaVehiculosContrato"));
            }

            listado.push({
                "idvehiculo": vehiculo.id
            });
            localStorage.setItem("listaVehiculosContrato", JSON.stringify(listado));
            addAlert();


            /**
             * AGREGAR VEHICULO
             */

            var fila = '<div class="filas flex -mx-1 px-2 py-4 border-b box-border" id="fila' + cont + '" idvehiculo="' +
                vehiculo.id + '">' +
                '<div class="flex-auto px-1 md:px-5 lg:px-5 xl:w-32 text-left">' +
                '<p class="text-gray-800 xs:text-base">' + vehiculo.placa + '</p>' +
                '<input type="hidden" class="idvehiculo" idvehiculo="' + vehiculo.id + '" name="items[' + cont +
                '][vehiculos_id]" value="' + vehiculo.id + '">' +
                '</div>' +
                '<div class="flex-auto xl:w-28 text-left">' +
                '<input class="form-input w-16 md:w-28 lg:w-28" type="number" name="items[' + cont + '][plan]" value="' +
                plan + '">' +
                '</div>' +
                '<div class="flex-auto xl:w-20 text-center">' +

                '<button type="button" class="text-red-500 hover:text-red-600 text-sm font-semibold" onclick="eliminarDetalleVehiculos(' +
                cont + ')">Eliminar</button>' +
                '</div>' +
                '</div>';


            cont++;
            detalles = detalles + 1;
            $('.detallesvehiculos').append(fila);
            evaluar();

        }

        $(".btnAgregarVehiculo").on("click", function() {

            //localStorage.removeItem("listaVehiculosContrato");

        })


        function evaluar() {
            if (detalles > 0) {
                $(".btnGuardarContrato").show();
            } else {
                $(".btnGuardarContrato").hide();
                cont = 0;
            }
        }

        function addAlert() {
            iziToast.success({
                position: 'topRight',
                title: 'AGREGADO',
                message: 'Añadiste el vehiculo',
            });
        }

        function eliminarDetalleVehiculos(indice) {
            $("#fila" + indice).remove();
            detalles = detalles - 1;
            evaluar();

            var idVehiculo = $(".filas");


            listado = [];

            if (idVehiculo.length != 0) {

                for (var i = 0; i < idVehiculo.length; i++) {

                    var idVehiculoArray = $(idVehiculo[i]).attr("idvehiculo");
                    //console.log(idVehiculoArray);

                    listado.push({
                        "idVehiculo": idVehiculoArray
                    });
                }

                localStorage.setItem("listaVehiculosContrato", JSON.stringify(listado));


            }
        }
    </script>




    <script>
        $(document).ready(function() {
            detalles = 0;
            cont = 0;
            flatpickr('.fechaContrato', {
                mode: 'single',
                defaultDate: "today",
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });

            localStorage.removeItem("listaVehiculosContrato");
            $(".btnGuardarContrato").hide();;
            $('#example').DataTable({
                "deferRender": true,
                "retrieve": true,
                "processing": true,
                "responsive": true,
                "language": {

                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }

                }
            });
        });
    </script>
    <script>
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
            selectionCssClass: 'pl-9',
            ajax: {
                url: '{{ route('search.ciudades') }}',
                dataType: 'json',

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
    </script>
@endsection
