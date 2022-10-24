@extends('layouts.admin')
@section('ruta', 'clientes-contactos')

@section('contenido')
    <!-- Code block starts -->
    <div
        class="my-6 lg:my-12 container px-6 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
        <!-- Add customer button -->
        <a href="{{ route('admin.clientes.contactos.index') }}">
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
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">CREAR CONTACTO</h4>
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
            <div class="md:col-span-1 ml-4">
                <div class="px-6 sm:px-2">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Formulario para crear un contacto
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Rellena los campos obligatorios
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2 clienteId">

                {!! Form::open(['route' => 'admin.clientes.contactos.store', 'autocomplete' => 'off']) !!}
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-12 gap-4">

                            <div class="col-span-12 sm:col-span-6">

                                {!! Html::decode(
                                    Form::label('nombre', 'Nombre: <span class="text-rose-500">*</span>', [
                                        'class' => 'block text-sm font-medium mb-1',
                                    ]),
                                ) !!}


                                {!! Form::text('nombre', null, [
                                    'placeholder' => 'Escribe el nombre...',
                                    'id' => 'nombre',
                                    'class' => 'form-input w-full valid:border-emerald-300 required:border-rose-300 invalid:border-rose-300
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               peer',
                                    'required',
                                ]) !!}

                                @error('nombre')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6 mb-2">
                                <div wire:ignore>
                                    <label
                                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                        <div>Cliente <span class="text-sm text-red-500"> * </span></div>
                                    </label>

                                    <select required name="clientes_id" id=""
                                        class="form-select w-full clientes_id pl-3">

                                    </select>
                                </div>


                                @error('clientes_id')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                {!! Form::label('cargo', 'Cargo:', ['class' => 'block text-sm font-medium mb-1']) !!}

                                {!! Form::text('cargo', null, ['placeholder' => 'Escribe el cargo', 'class' => 'form-input w-full']) !!}
                                @error('cargo')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                {!! Form::label('telefono', 'Telefono:', ['class' => 'block text-sm font-medium mb-1']) !!}

                                <div class="relative">


                                    <input x-mask="999999999" type="tel" value="{{ old('telefono') }}" max="maxlength"
                                        w-full pl-12', placeholder="987654321" class="form-input pl-12">


                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <span class="text-sm text-slate-400 font-medium px-3">+51</span>
                                    </div>
                                </div>
                                @error('telefono')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                {!! Form::label('email', 'Correo:', ['class' => 'block text-sm font-medium mb-1']) !!}

                                {!! Form::email('email', null, ['placeholder' => 'clientes@correo.com', 'class' => 'form-input w-full']) !!}
                                @error('email')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                {!! Form::label('birthday', 'Fcha. Nacimiento:', ['class' => 'block text-sm font-medium mb-1']) !!}

                                {!! Form::text('birthday', null, ['placeholder' => '18/05/1997', 'class' => 'form-input w-full']) !!}
                                @error('birthday')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-12 mt-4">
                                <span class="text-bold text-center mb-2">Opciones Adicionales:</span>
                                <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">


                                    <div class="m-2 w-full mt-2">
                                        <label for="fondo">Es Gerente:</label>
                                        <!-- Start -->
                                        <div class="flex items-center" x-data="{ checked: false }">
                                            <div class="form-switch">
                                                <input name="is_gerente" value="1" type="checkbox" id="fondo-1"
                                                    class="sr-only fondo" x-model="checked" />
                                                <label class="bg-slate-400" for="fondo-1">
                                                    <span class="bg-white shadow-sm" aria-hidden="true"></span>

                                                </label>
                                            </div>

                                        </div>
                                        <!-- End -->
                                    </div>

                                </div>
                            </div>
                            <div class="col-span-12">
                                {!! Form::label('descripcion', 'Descripción:', [
                                    'class' => 'block text-sm font-medium
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            mb-1',
                                ]) !!}
                                {!! Form::textarea('descripcion', null, [
                                    'placeholder' => 'Escribe la direccion...',
                                    'class' => 'form-input w-full',
                                ]) !!}


                            </div>



                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        {!! Form::submit('GUARDAR', [
                            'class' => 'btn hover:cursor-pointer bg-emerald-500 hover:bg-emerald-600 focus:outline-none
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            focus:ring-2 focus:ring-offset-2
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            focus:ring-emerald-600 text-white',
                        ]) !!}

                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#nombre').caseEnforcer('capitalize');
        $('#cargo').caseEnforcer('uppercase');
        $('#email').caseEnforcer('lowercase');



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

                        obj.id = obj.id || obj.value; // replace pk with your identifier
                        obj.text = obj.data; // replace pk with your identifier

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


        // INICIALIZAR LOS INPUTS DE FECHA
        $(document).ready(function() {

            flatpickr('#birthday', {
                mode: 'single',
                defaultDate: "today",
                disableMobile: "true",
                dateFormat: "d/m/Y",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });

        })
    </script>
@stop
