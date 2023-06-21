@extends('layouts.admin')
@section('ruta', 'vehiculos-vehiculos')
@section('contenido')
    <!-- Code block starts -->
    <div
        class="my-6 lg:my-12 container px-6 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
        <!-- Add customer button -->
        <a href="{{ route('admin.vehiculos.index') }}">
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
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">EDITAR VEHICULO</h4>
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


    <div class="mt-10 mx-4 sm:mt-0">
        <div class="flex ...">

            <div class="grow h-14 ...">
                {!! Form::model($vehiculo, ['route' => ['admin.vehiculos.update', $vehiculo], 'method' => 'put']) !!}
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-12 gap-6">

                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="placa">Placa: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative">

                                    {!! Form::text('placa', null, [
                                        'placeholder' => 'ABC-780',
                                        'class' => '"form-input w-full
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            pl-9
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            valid:border-emerald-300
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            required:border-rose-300 invalid:border-rose-300 peer',
                                    ]) !!}

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
                                                <line x1="25" y1="40" x2="39" y2="40"></line>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('placa')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="marca">Marca:</label>
                                <div class="relative">

                                    {!! Form::text('marca', null, [
                                        'placeholder' => 'TOYOTA',
                                        'class' => 'form-input w-full
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            pl-9',
                                    ]) !!}
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
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="modelo">Modelo:</label>
                                <div class="relative">
                                    {!! Form::text('modelo', null, [
                                        'placeholder' => 'HILUX',
                                        'class' => 'form-input w-full
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            pl-9',
                                    ]) !!}
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <g fill="none" class="nc-icon-wrapper">
                                                <path
                                                    d="M20 18v-1c1.1 0 1.99-.9 1.99-2L22 5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2v1H0v2h24v-2h-4zM4 5h16v10H4V5z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="tipo">Tipo:</label>
                                <div class="relative">

                                    {!! Form::text('tipo', null, [
                                        'placeholder' => 'PICK UP',
                                        'class' => 'form-input w-full
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            pl-9',
                                    ]) !!}
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <g fill="none" class="nc-icon-wrapper">
                                                <path
                                                    d="M4 16c0 .88.39 1.67 1 2.22V20c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h8v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1.78c.61-.55 1-1.34 1-2.22V6c0-3.5-3.58-4-8-4s-8 .5-8 4v10zm3.5 1c-.83 0-1.5-.67-1.5-1.5S6.67 14 7.5 14s1.5.67 1.5 1.5S8.33 17 7.5 17zm9 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-6H6V6h12v5z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="year">Año:</label>
                                <div class="relative">

                                    {!! Form::text('year', null, [
                                        'placeholder' => '2019',
                                        'class' => 'form-input w-full
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            pl-9',
                                    ]) !!}
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current  shrink-0 ml-3 mr-2"
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
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="color">Color:</label>
                                <div class="relative">

                                    {!! Form::text('color', null, ['placeholder' => 'BLANCO ROJO AZUL', 'class' => 'form-input w-full pl-9']) !!}
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current  shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <rect x="3" y="3" width="17" height="17"
                                                    rx="3" fill="#6cc4f5"></rect>
                                                <path
                                                    d="M46.138,9.419,38.581,1.862a2.945,2.945,0,0,0-4.162,0L26.862,9.419a2.943,2.943,0,0,0,0,4.162l7.557,7.557a2.948,2.948,0,0,0,4.162,0l7.557-7.557a2.943,2.943,0,0,0,0-4.162Z"
                                                    fill="#c456eb"></path>
                                                <rect x="28" y="28" width="17" height="17"
                                                    rx="3" fill="#6cc4f5"></rect>
                                                <rect x="3" y="28" width="17" height="17"
                                                    rx="3" fill="#6cc4f5"></rect>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="motor">Motor:</label>
                                <div class="relative">

                                    {!! Form::text('motor', null, [
                                        'placeholder' => '1GDG066086',
                                        'class' => 'form-input
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            w-full pl-9',
                                    ]) !!}
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current shrink-0 ml-3 mr-2"
                                            xmlns="
                                                            http://www.w3.org/2000/svg"
                                            viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M43.989,35.373,30.167,23.437,23,30.389l12.373,13.6q.1.115.213.225a6.1,6.1,0,0,0,8.627,0h0c.073-.073.144-.148.213-.224A6.1,6.1,0,0,0,43.989,35.373Z"
                                                    fill="#ff7163"></path>
                                                <path
                                                    d="M8.414,14H11l8.847,8.847L23,20l-9-9V8.414a1,1,0,0,0-.293-.707L8,2,2,8l5.707,5.707A1,1,0,0,0,8.414,14Z"
                                                    fill="#949494"></path>
                                                <path
                                                    d="M35.629,24.383A11.321,11.321,0,0,0,45.977,14.034a12.35,12.35,0,0,0-.485-4.291L39.48,15.754,32.251,8.525l6.011-6.012a12.342,12.342,0,0,0-4.29-.477,11.321,11.321,0,0,0-10.35,10.348,12.345,12.345,0,0,0,.479,4.295L3.046,35.688a3.171,3.171,0,0,0-.226,4.478c.036.04.072.078.11.115l4.793,4.794a3.17,3.17,0,0,0,4.483-.008c.037-.036.072-.074.107-.112L31.333,23.9A12.353,12.353,0,0,0,35.629,24.383Z"
                                                    fill="#c8c8c8"></path>
                                                <path
                                                    d="M39,40a1,1,0,0,1-.707-.293l-7-7a1,1,0,0,1,1.414-1.414l7,7A1,1,0,0,1,39,40Z"
                                                    fill="#f74b3b"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="serie">Serie:</label>
                                <div class="relative">


                                    {!! Form::text('serie', null, ['placeholder' => '8AJHA8CD9K2629775', 'class' => 'form-input w-full pl-9']) !!}
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
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
                            </div>
                            <div class="col-span-12 sm:col-span-12 selectCliente" wire:ignore>
                                <label class="block text-sm font-medium mb-1" for="clientes_id">Cliente:</label>

                                {{-- {!! Form::select('clientes_id', [$vehiculo->clientes_id => $vehiculo->clientes->nombre], $vehiculo->clientes_id, [
                                    'class' => 'clientes_id w-full',
                                ]) !!} --}}
                                @if ($vehiculo->cliente)
                                    {!! Form::select(
                                        'clientes_id',
                                        [$vehiculo->clientes_id => $vehiculo->cliente->razon_social],
                                        $vehiculo->clientes_id,
                                        [
                                            'class' => 'clientes_id w-full',
                                        ],
                                    ) !!}
                                @else
                                    {!! Form::select('clientes_id', [], null, ['class' => 'clientes_id w-full']) !!}
                                @endif






                            </div>

                            <div class="col-span-6 sm:col-span-6">


                                <label class="block text-sm font-medium mb-1" for="numero">Número: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative">
                                    @if ($vehiculo->sim_card)
                                        <input required type="text" name="numero"
                                            value="{{ $vehiculo->sim_card->linea ? $vehiculo->sim_card->linea->numero : '' }}"
                                            class="form-input w-full pl-9 numero" placeholder="987654321">
                                    @else
                                        <input required type="text" name="numero"
                                            class="form-input w-full pl-9 numero" placeholder="987654321">
                                    @endif


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
                                @error('numero')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="operador">Operador:</label>
                                <div class="relative">

                                    {!! Form::text('operador', $vehiculo->sim_card ? $vehiculo->sim_card->operador : null, [
                                        'placeholder' => 'Claro',
                                        'class' => 'form-input w-full pl-9 operador',
                                        'disabled',
                                    ]) !!}
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M45.5,32.131l-21-12a1,1,0,0,0-.992,0l-21,12A1,1,0,0,0,2.137,33.5a.986.986,0,0,0,.371.371l21,12a1,1,0,0,0,.992,0l21-12a1,1,0,0,0,0-1.736Z"
                                                    fill="#2a4b55"></path>
                                                <path
                                                    d="M45.5,23.132l-21-12a1,1,0,0,0-.992,0l-21,12a1,1,0,0,0,0,1.736l21,12a1,1,0,0,0,.992,0l21-12a1,1,0,0,0,.371-1.365A.986.986,0,0,0,45.5,23.132Z"
                                                    fill="#4d8b9d"></path>
                                                <path
                                                    d="M45.5,14.132l-21-12a1,1,0,0,0-.992,0l-21,12a1,1,0,0,0,0,1.736l21,12a1,1,0,0,0,.992,0l21-12a1,1,0,0,0,0-1.736Z"
                                                    fill="#8ebac7"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="sim_card">Sim Card:</label>
                                <div class="relative">

                                    {!! Form::text('sim_card', $vehiculo->sim_card ? $vehiculo->sim_card->sim_card : null, [
                                        'placeholder' => '3189219220212',
                                        'class' => 'form-input w-full pl-9 sim_card',
                                        'disabled',
                                        'required',
                                    ]) !!}

                                    {!! Form::hidden('sim_card_id', null, ['class' => 'sim_card_id']) !!}
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <g fill="none" class="nc-icon-wrapper">
                                                <g clip-path="url(#clip0)">
                                                    <path
                                                        d="M18.99 5c0-1.1-.89-2-1.99-2h-7L7.66 5.34 19 16.68 18.99 5zM3.65 3.88L2.38 5.15 5 7.77V19c0 1.1.9 2 2 2h10.01c.35 0 .67-.1.96-.26l1.88 1.88 1.27-1.27L3.65 3.88z"
                                                        fill="#666"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0">
                                                        <path fill="#666" d="M0 0h24v24H0z"></path>
                                                    </clipPath>
                                                </defs>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="imei">IMEI GPS:</label>
                                <div class="relative">


                                    <div class="relative">

                                        {!! Form::text('dispositivo_imei', $vehiculo->dispositivos ? $vehiculo->dispositivos->imei : null, [
                                            'placeholder' => '357073292893290',
                                            'class' => 'form-input w-full
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        pl-9
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        valid:border-emerald-300
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        required:border-rose-300 invalid:border-rose-300 peer dispositivo',
                                            'required',
                                        ]) !!}
                                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                            {!! Form::hidden('dispositivos_id', null, ['class' => 'dispositivos_id']) !!}
                                            <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                                <g class="nc-icon-wrapper">
                                                    <circle cx="24" cy="24" r="23" fill="#cbeafb">
                                                    </circle>
                                                    <path
                                                        d="M1,24A22.94,22.94,0,0,0,8.768,41.227L10.8,38.18s1.452-.419,1.765-.981c.98-1.764-.76-4.835-.76-4.835a9.974,9.974,0,0,0-.35-2.176c-.262-.653-2.091-1.548-2.091-1.548S7.6,25.765,7.6,24a2.63,2.63,0,0,1,2.483-2.743,4.288,4.288,0,0,0,2.81-2.026s2.222-.589,2.744-1.5-.587-4.175-.587-4.175a5.46,5.46,0,0,0-.022-2.62,4.955,4.955,0,0,0-1.646-1.981,10.868,10.868,0,0,0-2.56-3.8A22.967,22.967,0,0,0,1,24Z"
                                                        fill="#78d478"></path>
                                                    <path
                                                        d="M24,1c-.62,0-1.232.032-1.839.08-.2.619-1.231,2.208-.971,2.925s2.395,1.384,2.395,1.384S23.019,7.6,24,8.383s2.549-.261,3.136-.065.457,4.05.457,4.05,1.895,2.091,3.758,2.353,4.7-2.9,4.7-2.9a37.386,37.386,0,0,0,6.1-1.95A22.954,22.954,0,0,0,24,1Z"
                                                        fill="#78d478"></path>
                                                    <path
                                                        d="M40.858,25.5c.523,1.242-.982,4.412-2.222,5.031a8.421,8.421,0,0,0-3.22,2.568c-.458.719-1.059,3.684-2.561,4.272s-5.065,3.942-6.96,3.419S24,35.761,25.307,33.735c.78-1.209-.131-3.855-.2-4.769S22.3,26.352,22.3,25.438c0-1.438,3.136-5.228,3.136-5.228s2.57-.849,3.354-.653a11.848,11.848,0,0,1,2.266,1.11,15.713,15.713,0,0,1,4.051.849l1.5,1.372S40.335,24.261,40.858,25.5Z"
                                                        fill="#78d478"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>

                                    @livewire('admin.dispositivos.save-quick')
                                </div>

                                @error('dispositivos_id')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                                @error('dispositivo_imei')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="modelo_id">MODELO GPS:</label>
                                <div class="relative">

                                    {!! Form::text('modelo_id', $vehiculo->dispositivos ? $vehiculo->dispositivos->modelo->modelo : null, [
                                        'placeholder' => 'FMB920',
                                        'class' => 'form-input w-full pl-9 modelo_gps',
                                        'disabled',
                                    ]) !!}
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <g fill="none" class="nc-icon-wrapper">
                                                <path opacity=".3" d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm8.94-3A8.994 8.994 0 0 0 13 3.06V1h-2v2.06A8.994 8.994 0 0 0 3.06 11H1v2h2.06A8.994 8.994 0 0 0 11 20.94V23h2v-2.06A8.994 8.994 0 0 0 20.94 13H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="descripcion">DESCRIPCIÓN:</label>
                                <div class="relative">

                                    {!! Form::textarea('descripcion', null, [
                                        'placeholder' => 'Ingresar Descripcion',
                                        'class' => 'form-input w-full pl-9',
                                        'rows' => 2,
                                    ]) !!}

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
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        {!! Form::submit('GUARDAR', [
                            'class' => 'btn cursor-pointer bg-emerald-500 hover:bg-emerald-600 focus:outline-none
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

@once
    @push('scripts')
        <script>
            $('.clientes_id').select2({
                placeholder: 'Buscar una cliente',
                language: "es",

                // tags: true,
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
                        //console.log(data);
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {

                            results: suggestions,

                        };

                    },


                },
                minimumInputLength: 2,
                templateResult: formatCliente,
            });

            function formatCliente(cliente) {
                if (cliente.loading) {
                    return cliente.text;
                }

                var $container = $(

                    "<div class='select2-result-clientes clearfix'>" +
                    "<div class='select2-result-clientes__meta'>" +
                    "<div class='select2-result-clientes__title'></div>" +
                    "<div class='select2-result-clientes__description'></div>" +
                    "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-clientes__title").text(cliente.text);
                $container.find(".select2-result-clientes__description").text(cliente.razon_social);
                // $container.find(".select2-result-clientes__stargazers").append(repo.stargazers_count + " Stars");

                return $container;
            }
        </script>
        <script>
            $('.numero').devbridgeAutocomplete({
                lookup: function(query, done) {
                    $.ajax({
                        url: "{{ route('search.lineas') }}",
                        dataType: 'json',
                        data: {
                            term: query
                        },
                        success: function(data) {

                            done(data);

                        }
                    })

                },
                minChars: 2,
                autoSelectFirst: false,
                deferRequestBy: 5,
                onSelect: function(suggestion) {

                    //console.log(suggestion.operador);

                    $('.operador').val(suggestion.operador);
                    $('.sim_card').val(suggestion.sim_card);

                    $('.sim_card_id').val(suggestion.sim_card_id);


                },
                onHint: function(hint) {
                    //$('#numero').val(hint);
                    //console.log(hint);


                },
                onSearchComplete: function(query, suggestions) {

                },
                onInvalidateSelection: function() {
                    $('#selction-ajax').html('You selected: none');
                },

            });
        </script>


        <script>
            $('.dispositivo').devbridgeAutocomplete({
                lookup: function(query, done) {
                    $.ajax({
                        url: "{{ route('search.dispositivos') }}",
                        dataType: 'json',
                        data: {
                            term: query
                        },
                        success: function(data) {

                            done(data);

                        }
                    })

                },
                minChars: 2,
                autoSelectFirst: false,
                deferRequestBy: 5,
                onSelect: function(suggestion) {

                    //console.log(suggestion.operador);

                    $('.modelo_gps').val(suggestion.modelo);

                    $('.dispositivos_id').val(suggestion.data);

                    // $('.sim_card').val(suggestion.sim_card);

                },
                onHint: function(hint) {
                    //$('#numero').val(hint);
                    //console.log(hint);


                },
                onSearchComplete: function(query, suggestions) {

                },
                onInvalidateSelection: function() {
                    $('#selction-ajax').html('You selected: none');
                },

            });
        </script>
    @endpush
@endonce
