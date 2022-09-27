@extends('layouts.admin')
@section('ruta', 'almacen-guias')


@section('contenido')

    <div
        class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
        <a href="{{ route('admin.almacen.guias.index') }}">
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
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">REGISTRAR GUIA REMISION</h4>
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

    <div class="p-6 shadow overflow-hidden sm:rounded-md">
        {!! Form::open([
            'route' => 'admin.almacen.guias.store',
            'class' => 'formularioFactura',
            'autocomplete' => 'off',
        ]) !!}
        <div class="px-4 py-2 bg-gray-100 sm:p-6">

            <div class="grid grid-cols-12 gap-2 mb-4">

                <div class="col-span-12 sm:col-span-2 mb-2 gap-2">
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>
                            Serie y Número Correlativo
                            <span class="text-sm text-red-500"> * </span>
                        </div>
                    </label>
                    <div class="relative">
                        <input name="numero" id="numero"
                            class="form-input w-full pl-9 py-2 outline-none focus:outline-none rounded-md text-black text-sm"
                            type="text" placeholder="T001-002" />
                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                            <svg class="w-4 h-4 fill-current shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <g class="nc-icon-wrapper">
                                    <path
                                        d="M38,23a1,1,0,0,1-.707-.293l-6-6a1,1,0,0,1,0-1.414l8-8a1,1,0,0,1,1.414,0l6,6a1,1,0,0,1,0,1.414l-2,2a1,1,0,0,1-1.414,0L41,14.414,38.414,17l2.293,2.293a1,1,0,0,1,0,1.414l-2,2A1,1,0,0,1,38,23Z"
                                        fill="#eba40a"></path>
                                    <path
                                        d="M44.061,3.939a1.5,1.5,0,0,0-2.122,0L17.923,27.956a10.027,10.027,0,1,0,2.121,2.121L44.061,6.061A1.5,1.5,0,0,0,44.061,3.939ZM12,43a7,7,0,1,1,4.914-11.978c.011.012.014.027.025.039s.027.014.039.025A6.995,6.995,0,0,1,12,43Z"
                                        fill="#ffd764"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    @error('numero')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- <div class="h-1 border-dashed lg:border-b-2 border-gray-300 rounded-l-lg"></div> --}}
                <div class="col-span-12 sm:col-span-3 mb-2 gap-2">
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Fecha Emisión <span class="text-sm text-red-500"> * </span></div>
                    </label>
                    <div class="relative">
                        <input name="fecha_emision" id="fecha_emision"
                            class="form-input w-full pl-9 py-2 outline-none focus:outline-none rounded-md text-black text-sm fecha_emision"
                            type="text" placeholder="2022-09-28" />
                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                            <svg class="w-4 h-4 fill-current  shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <g class="nc-icon-wrapper">
                                    <path d="M2,41a5,5,0,0,0,5,5H41a5,5,0,0,0,5-5V16H2Z" fill="#e3e3e3"></path>
                                    <path d="M41,6H7a5,5,0,0,0-5,5v5H46V11A5,5,0,0,0,41,6Z" fill="#ff7163"></path>
                                    <path
                                        d="M23.239,38.894H12.359V36.6c2.891-2.922,5.36-5.363,6.175-6.414,1.382-1.784,1.136-3.3.484-3.88-1.287-1.142-3.435-.085-4.913,1.139l-1.788-2.119a7.62,7.62,0,0,1,5.557-2.225c2.88,0,4.928,1.662,4.928,4.216a6.047,6.047,0,0,1-1.549,3.949c-.826,1.032-4.8,4.855-4.8,4.855h6.781Z"
                                        fill="#aeaeae"></path>
                                    <path
                                        d="M24.7,32.155q0-4.62,1.954-6.877A7.319,7.319,0,0,1,32.5,23.021a10.653,10.653,0,0,1,2.087.16V25.81a8.524,8.524,0,0,0-1.874-.213c-1.8,0-3.517.431-4.364,2.023a6.926,6.926,0,0,0-.628,2.842,4.211,4.211,0,0,1,3.513-1.809c2.937,0,4.449,2.015,4.449,4.929,0,3.271-1.916,5.4-5.3,5.4C26.6,38.979,24.7,36.12,24.7,32.155Zm5.621,4.194c1.545,0,2.182-1.16,2.182-2.725,0-1.461-.651-2.448-2.118-2.448a2.318,2.318,0,0,0-2.417,2.161C27.965,34.856,28.82,36.349,30.318,36.349Z"
                                        fill="#aeaeae"></path>
                                    <path d="M11.5,12A1.5,1.5,0,0,1,10,10.5v-7a1.5,1.5,0,0,1,3,0v7A1.5,1.5,0,0,1,11.5,12Z"
                                        fill="#363636"></path>
                                    <path d="M36.5,12A1.5,1.5,0,0,1,35,10.5v-7a1.5,1.5,0,0,1,3,0v7A1.5,1.5,0,0,1,36.5,12Z"
                                        fill="#363636"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    @error('fecha_emision')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>



            </div>
            <div class="border-solid border-b-2 border-gray-200 mb-3">
                <span class="font-semibold  text-base leading-tight font-sans text-gray-800 dark:text-gray-100">
                    DATOS DESTINATARIO:
                </span>
            </div>

            <div class="grid grid-cols-12 gap-4">

                <div class="col-span-12 sm:col-span-3 mb-2">
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Tipo Documento <span class="text-sm text-red-500"> * </span></div>
                    </label>
                    <div class="relative">

                        {!! Form::select('tipo_documento', ['RUC' => 'RUC', 'DNI' => 'DNI'], null, [
                            'class' => 'form-select w-full pl-9 py-2 text-black text-sm',
                            '@onchange' => 'cambiarTipoDocumento($event.target.value)',
                        ]) !!}

                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                            <svg class="w-4 h-4 fill-current shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 64 64">
                                <g stroke-linecap="round" fill="none" stroke="currentColor" stroke-linejoin="round"
                                    class="nc-icon-wrapper">
                                    <rect x="8" y="3" width="48" height="58"></rect>
                                    <circle cx="25" cy="26" r="5"></circle>
                                    <path d="M25,36A11,11,0,0,0,14,47H36A11,11,0,0,0,25,36Z"></path>
                                    <circle cx="40" cy="21" r="4"></circle>
                                    <path d="M40,40H50a10,10,0,0,0-16-8"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    @error('tipo_documento')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="col-span-12 sm:col-span-3 mb-2">

                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>N° Documento <span class="text-sm text-red-500"> * </span></div>
                    </label>
                    <div class="relative">
                        <input id="numero_documento" name="numero_documento" class="form-input w-full pl-9"
                            type="text" />
                        <button class="absolute inset-0 right-auto group" type="button" aria-label="Search">
                            <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                                viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                <path
                                    d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                            </svg>
                        </button>
                    </div>

                    @error('numero_documento')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>



                <div class="col-span-12 mb-2">


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
            </div>


            <div class="px-4 py-3 text-right sm:px-6 col-span-12 mb-2 gap-2">
                {!! Form::submit('GUARDAR', [
                    'class' => 'btn bg-emerald-500 hover:bg-emerald-600 focus:outline-none
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        focus:ring-2 focus:ring-offset-2
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        focus:ring-emerald-600 text-white',
                ]) !!}

            </div>



        </div>
        {!! Form::close() !!}







    </div>



@stop
@section('js')

    <script>
        $(document).ready(function() {

            flatpickr('.fecha_emision', {
                mode: 'single',
                defaultDate: "today",
                minDate: "today",
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
        })
    </script>
@endsection
