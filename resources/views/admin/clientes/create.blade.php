@extends('layouts.admin')
@section('ruta', 'clientes-clientes')

@section('contenido')
    <!-- Code block starts -->
    <div
        class="my-6 lg:my-12 container px-6 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
        <!-- Add customer button -->
        <a href="{{ route('admin.clientes.index') }}">
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
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">CREAR CLIENTE</h4>
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
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Formulario para crear un cliente
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Rellena los campos obligatorios
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">

                {!! Form::open(['route' => 'admin.clientes.store', 'autocomplete' => 'off']) !!}
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6 mr-4">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 sm:col-span-6">
                                {!! Form::hidden('empresa_id', session('empresa')) !!}
                                {!! Html::decode(
                                    Form::label(
                                        'razon_social',
                                        'Razon Social o Nombre: <span
                                                                                                                                                                                                                                                                                                                                class="text-rose-500">*</span>',
                                        ['class' => 'block text-sm font-medium mb-1'],
                                    ),
                                ) !!}


                                {!! Form::text('razon_social', null, [
                                    'placeholder' => 'Escribe la razon social',
                                    'class' => 'form-input w-full valid:border-emerald-300 required:border-rose-300 invalid:border-rose-300
                                                                                                                                                                                                                                                                                                                            peer',
                                    'required',
                                    'autocapitalize' => 'on',
                                ]) !!}


                                @error('razon_social')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                {!! Html::decode(
                                    Form::label(
                                        'numero_documento',
                                        'DNI/RUC: <span
                                                                                                                                                                                                                                                                                                                                class="text-rose-500">*</span>',
                                        ['class' => 'block text-sm font-medium mb-1'],
                                    ),
                                ) !!}

                                {!! Form::text('numero_documento', null, [
                                    'placeholder' => 'Escribe el N° de documento
                                                                                                                                                                                                                                                                                                                            ',
                                    'class' => 'form-input w-full valid:border-emerald-300
                                                                                                                                                                                                                                                                                                                            required:border-rose-300 invalid:border-rose-300 peer',
                                    'required',
                                    'maxlength' => '11',
                                ]) !!}

                                @error('numero_documento')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                {!! Form::label('telefono', 'Telefono:', ['class' => 'block text-sm font-medium mb-1']) !!}

                                <div class="relative">
                                    {!! Form::text('telefono', null, [
                                        'placeholder' => '987654321',
                                        'class' => 'form-input
                                                                                                                                                                                                                                                                                                                                                                    w-full pl-12',
                                        'maxlength' => '9',
                                    ]) !!}


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
                                {!! Form::label('web_site', 'Web Site:', ['class' => 'block text-sm font-medium mb-1']) !!}

                                {!! Form::text('web_site', null, ['placeholder' => 'Escribe el sitio web', 'class' => 'form-input w-full']) !!}
                                @error('web_site')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-12">
                                {!! Form::label('direccion', 'Direccion:', ['class' => 'block text-sm font-medium mb-1']) !!}
                                {!! Form::text('direccion', null, ['placeholder' => 'Escribe la direccion...', 'class' => 'form-input w-full']) !!}

                            </div>
                            <div class="col-span-12 sm:col-span-12 mt-4">
                                <span class="text-bold text-center mb-2">Opciones:</span>
                                <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">


                                    <div class="m-2 w-full mt-2">
                                        <label for="flota">Crear Flota:</label>
                                        <!-- Start -->
                                        <div class="flex items-center" x-data="{ checked: false }">
                                            <div class="form-switch">
                                                <input value="1" name="flota" type="checkbox" id="flota"
                                                    class="sr-only flota" x-model="checked" />
                                                <label class="bg-slate-400" for="flota">
                                                    <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                                    <span class="sr-only">flota switch</span>
                                                </label>
                                            </div>
                                            <div class="text-sm text-slate-400 italic ml-2"
                                                x-text="checked ? 'Se Creara la Flota' : 'Solo crear cliente'"></div>
                                        </div>
                                        <!-- End -->
                                    </div>




                                </div>
                            </div>



                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            {!! Form::submit('GUARDAR', [
                                'class' => 'btn bg-emerald-500 hover:cursor-pointer hover:bg-emerald-600 cursor-pointer
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

@push('scripts')
    <script>
        $('#numero_documento').on('blur', function() {

            //  console.log($(this).val().length);
            if (parseInt($(this).val().length) === 8) {


                var datos = {
                    'numero': $(this).val(),
                    'tipo': 'DNI',
                }
            }

            if (parseInt($(this).val().length) === 11) {


                var datos = {
                    'numero': $(this).val(),
                    'tipo': 'RUC',
                }


            }
            $.ajax({

                url: "{{ route('consulta.sunat') }}",
                method: "GET",
                data: datos,
                success: function(respuesta) {


                    if (!respuesta.error) {

                        $('#razon_social').val(respuesta.nombre)
                        $('#direccion').val(respuesta.direccion + '' + respuesta.provincia + '-' +
                            respuesta.departamento)
                    }


                }

            });

        })
    </script>
@endpush
