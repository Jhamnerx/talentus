@extends('layouts.admin')
@section('ruta', 'administracion-cobros')
@section('contenido')


    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full bg-white shadow-lg rounded-sm border border-slate-200 min-h-screen">

        <!-- Page content -->
        <div class="max-w-5xl mx-auto flex flex-col lg:flex-row lg:space-x-8 xl:space-x-16">

            <!-- Cart items -->
            <div class="mb-6 lg:mb-0 xl:mr-12">
                <div class="mb-3">
                    <div class="flex text-sm font-medium text-slate-400 space-x-2">
                        <span class="text-indigo-500">Administración</span>
                        <span>-&gt;</span>
                        <span class="text-slate-500">Pagos</span>
                        <span>-&gt;</span>
                        <span class="text-slate-500">Resumen</span>
                    </div>
                </div>
                <header class="mb-2">
                    <!-- Title -->
                    <h1 class="text-2xl md:text-3xl text-slate-800 font-semibold">Pagos realizados ✨</h1>
                </header>

                {{-- PAGOS REALIZADOS --}}
                <ul>
                    <!-- Cart item -->
                    <li class="sm:flex items-center py-6 border-b border-slate-200">
                        <a class="block mb-4 sm:mb-0 mr-5 md:w-32 xl:w-auto shrink-0" href="#0">

                            <svg class="w-44 h-44" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                <g class="nc-icon-wrapper">
                                    <path
                                        d="M42,47H6a1,1,0,0,1-.983-1.187L9,24.906V14a1,1,0,0,1,1-1H38a1,1,0,0,1,1,1V24.906l3.982,20.907A1,1,0,0,1,42,47Z"
                                        fill="#ffd764"></path>
                                    <path
                                        d="M31,21a1,1,0,0,1-1-1V9A6,6,0,0,0,18,9V20a1,1,0,0,1-2,0V9A8,8,0,0,1,32,9V20A1,1,0,0,1,31,21Z"
                                        fill="#a2703f"></path>
                                </g>
                            </svg>
                        </a>
                        <div class="grow">
                            <a href="#0">
                                <h3 class="text-lg font-semibold text-slate-800 mb-1">
                                    Titulo
                                </h3>
                            </a>
                            <div class="text-sm mb-2">
                                Descripcion del pago................................................
                            </div>
                            <!-- Product meta -->
                            <div class="flex flex-wrap justify-between items-center">
                                <!-- Rating and price -->
                                <div class="flex flex-wrap items-center space-x-2 mr-2">

                                    <div class="text-slate-400">·</div>
                                    <!-- Price -->
                                    <div>
                                        <div
                                            class="inline-flex text-sm font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2 py-0.5">
                                            $30.00
                                        </div>
                                    </div>
                                </div>
                                <button class="text-sm underline hover:no-underline">12-09-2022</button>
                            </div>
                        </div>
                    </li>
                    {{-- <!-- Cart item -->
                    <li class="sm:flex items-center py-6 border-b border-slate-200">
                        <a class="block mb-4 sm:mb-0 mr-5 md:w-32 xl:w-auto shrink-0" href="#0">
                            <img class="rounded-sm" src="../images/related-product-02.jpg" width="200" height="142"
                                alt="Product 02" />
                        </a>
                        <div class="grow">
                            <a href="#0">
                                <h3 class="text-lg font-semibold text-slate-800 mb-1">Web Development Ultimate Course 2021
                                </h3>
                            </a>
                            <div class="text-sm mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                eiusmod tempor incididunt ut.</div>
                            <!-- Product meta -->
                            <div class="flex flex-wrap justify-between items-center">
                                <!-- Rating and price -->
                                <div class="flex flex-wrap items-center space-x-2 mr-2">
                                    <!-- Rating -->
                                    <div class="flex items-center space-x-2">
                                        <!-- Stars -->
                                        <div class="flex space-x-1">
                                            <button>
                                                <span class="sr-only">1 star</span>
                                                <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                </svg>
                                            </button>
                                            <button>
                                                <span class="sr-only">2 stars</span>
                                                <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                </svg>
                                            </button>
                                            <button>
                                                <span class="sr-only">3 stars</span>
                                                <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                </svg>
                                            </button>
                                            <button>
                                                <span class="sr-only">4 stars</span>
                                                <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                </svg>
                                            </button>
                                            <button>
                                                <span class="sr-only">5 stars</span>
                                                <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Rate -->
                                        <div class="inline-flex text-sm font-medium text-amber-600">4.2</div>
                                    </div>
                                    <div class="text-slate-400">·</div>
                                    <!-- Price -->
                                    <div>
                                        <div
                                            class="inline-flex text-sm font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2 py-0.5">
                                            $89.00</div>
                                    </div>
                                </div>
                                <button class="text-sm underline hover:no-underline">Remove</button>
                            </div>
                        </div>
                    </li>
                    <!-- Cart item -->
                    <li class="sm:flex items-center py-6 border-b border-slate-200">
                        <a class="block mb-4 sm:mb-0 mr-5 md:w-32 xl:w-auto shrink-0" href="#0">
                            <img class="rounded-sm" src="../images/related-product-03.jpg" width="200" height="142"
                                alt="Product 03" />
                        </a>
                        <div class="grow">
                            <a href="#0">
                                <h3 class="text-lg font-semibold text-slate-800 mb-1">Full-Stack JavaScript Course!</h3>
                            </a>
                            <div class="text-sm mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                eiusmod tempor incididunt ut.</div>
                            <!-- Product meta -->
                            <div class="flex flex-wrap justify-between items-center">
                                <!-- Rating and price -->
                                <div class="flex flex-wrap items-center space-x-2 mr-2">
                                    <!-- Rating -->
                                    <div class="flex items-center space-x-2">
                                        <!-- Stars -->
                                        <div class="flex space-x-1">
                                            <button>
                                                <span class="sr-only">1 star</span>
                                                <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                </svg>
                                            </button>
                                            <button>
                                                <span class="sr-only">2 stars</span>
                                                <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                </svg>
                                            </button>
                                            <button>
                                                <span class="sr-only">3 stars</span>
                                                <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                </svg>
                                            </button>
                                            <button>
                                                <span class="sr-only">4 stars</span>
                                                <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                </svg>
                                            </button>
                                            <button>
                                                <span class="sr-only">5 stars</span>
                                                <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Rate -->
                                        <div class="inline-flex text-sm font-medium text-amber-600">4.2</div>
                                    </div>
                                    <div class="text-slate-400">·</div>
                                    <!-- Price -->
                                    <div>
                                        <div
                                            class="inline-flex text-sm font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2 py-0.5">
                                            $89.00</div>
                                    </div>
                                </div>
                                <button class="text-sm underline hover:no-underline">Remove</button>
                            </div>
                        </div>
                    </li> --}}
                </ul>

                <div class="mt-6 text-center lg:text-left">
                    <a class="text-sm font-medium text-indigo-500 hover:text-indigo-600"
                        href="{{ route('admin.cobros.index') }}">&lt;- Volver a la
                        lista</a>
                </div>



            </div>

            <!-- Sidebar -->
            <div class="max-w-sm mx-auto lg:max-w-none">
                <div class="bg-white p-5 shadow-lg rounded-sm border border-slate-200 lg:w-72 xl:w-80">
                    <div class="text-slate-800 font-semibold mb-2 uppercase">Detalle de Cobro</div>
                    <!-- Order details -->
                    <ul class="mb-4">
                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                            <div>Empresa: </div>
                            <div class="font-medium text-slate-800">{{ $cobro->clientes->razon_social }}</div>
                        </li>
                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                            <div>Placa: </div>
                            <div class="font-medium text-slate-800">{{ $cobro->vehiculos->placa }}</div>
                        </li>
                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">

                            <div>Estado: </div>
                            @if ($cobro->suspendido)
                                <div class="text-sm font-semibold text-white px-1.5 bg-red-500 rounded-full">Suspendido
                                </div>
                            @else
                                <div class="text-sm font-semibold text-white px-1.5 bg-emerald-500 rounded-full">Activo
                                </div>
                            @endif



                        </li>
                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                            <div>Fecha Vencimiento: </div>
                            <div class="font-medium text-emerald-600">{{ $cobro->fecha_vencimiento->format('d-m-Y') }}</div>
                        </li>

                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                            <div>Periodo: </div>
                            <div class="font-medium text-slate-800">{{ $cobro->periodo }}</div>
                        </li>
                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                            <div>Tipo Pago: </div>
                            <div class="font-medium text-slate-800">{{ $cobro->tipo_pago }}</div>
                        </li>
                    </ul>
                    <!-- observacion -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-medium mb-1" for="observacion">Observacion: </label>
                            <div class="text-sm text-slate-400 italic">opcional</div>
                        </div>
                        <textarea name="observacion" rows="5" id="observacion" class="form-input w-full mb-2" type="text">
                        </textarea>
                        <button class="btn w-full bg-red-500 hover:bg-red-600 text-white  shadow-none">
                            Suspender
                        </button>
                    </div>
                    <div class="mb-4">
                        <button class="btn w-full bg-indigo-500 hover:bg-indigo-600 text-white" href="#0">
                            Pagar - ${{ $cobro->monto_unidad }}
                        </button>
                    </div>
                    <div class="text-xs text-slate-500 italic text-center">
                        {{ $cobro->comentario }}
                    </div>
                </div>
            </div>

        </div>

    </div>

@stop

@section('js')

@stop
