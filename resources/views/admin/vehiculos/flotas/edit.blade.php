@extends('layouts.admin')

@section('contenido')
<!-- Code block starts -->
<div
    class="my-6 lg:my-12 container px-6 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
    <!-- Add customer button -->
    <a href="{{route('admin.almacen.categorias.index')}}">
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
        <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">EDITAR CATEGORIA</h4>
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
                <h3 class="text-lg font-medium leading-6 text-gray-900">Formulario para editar una flota
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    No dejes vacios los campos obligatorios
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">

            {!! Form::model($flota, ['route' => ['admin.vehiculos.flotas.update', $flota], 'method' => 'put'])
            !!}
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6 sm:col-span-4">
                            {!! Form::hidden('empresa_id', session('empresa')) !!}
                            {{-- Nombre Categoria --}}

                            <label class="block text-sm font-medium mb-1" for="placa">Nombre: <span
                                    class="text-rose-500">*</span></label>
                            <div class="relative">
                                {!! Form::text('nombre', null, ['class' => 'form-input w-full pl-9
                                valid:border-emerald-300
                                required:border-rose-300 invalid:border-rose-300 peer']) !!}



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
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block text-sm font-medium mb-1" for="clientes_id">Cliente:</label>
                            <div class="relative">

                                {!! Form::select('clientes_id', $clientes, null, ['class' => 'form-select w-full pl-9'])
                                !!}



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

                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <label class="block text-sm font-medium mb-1" for="descripcion">DESCRIPCIÓN:</label>
                            <div class="relative">


                                {!! Form::textarea('descripcion', null, ['class' => 'form-input w-full pl-9', 'rows' =>
                                '4', 'placeholder' => 'Ingresar Breve Descripción']) !!}
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
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    {!! Form::submit('GUARDAR', ['class'=>'btn bg-emerald-500 hover:bg-emerald-600 focus:outline-none
                    focus:ring-2 focus:ring-offset-2
                    focus:ring-emerald-600 text-white']) !!}

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection