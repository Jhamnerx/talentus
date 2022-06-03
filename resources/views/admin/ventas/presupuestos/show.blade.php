@extends('layouts.admin')
@section('ruta', 'ventas-presupuestos')


@section('contenido')


<!-- Code block starts -->

<div class="bg-white dark:bg-gray-800">
    <div class="2xl:container 2xl:mx-auto py-5 lg:px-7 sm:px-6  px-4">
        <nav class="">
            <div class=" flex flex-row justify-between">
                <div class=" flex space-x-3 items-center">

                    <h1 class="  font-bold text-2xl leading-6 text-gray-800 dark:text-white ">PRESUPUESTO</h1>
                </div>

                <!-- For large (i.e. desktop and laptop sized screen) -->
                <div class="lg:flex hidden flex-auto justify-between flex-row">
                    <div class=" xl:pl-16 lg:pl-4">
                        <div class=" flex space-x-1 items-center">
                            <div
                                class=" focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 cursor-pointer w-3 h-3 rounded-full bg-white flex justify-center items-center">
                                <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg2.svg"
                                    alt="left arrow" />
                            </div>
                            <a class="focus:text-gray-700 hover:text-gray-700 duration-100 border-b border-gray-600 dark:border-gray-200 font-normal text-xs leading-3 text-gray-600 dark:text-gray-200 pb-1"
                                href="{{route('admin.ventas.presupuestos.index')}}">Volver a Presupuestos</a>
                        </div>
                        <h2 class=" font-bold text-xl leading-5 text-gray-800 dark:text-white ">Detalle del presupuesto
                        </h2>
                    </div>
                    <div class="flex flex-row lg:space-x-3 xl:space-x-4">

                        <button
                            class="rounded-md flex space-x-2 w-24 h-10 font-normal text-sm leading-3 text-gray-800 bg-white focus:outline-none focus:bg-gray-200 hover:bg-gray-200 duration-150 justify-center items-center">
                            <p>Compartir</p>
                            <img class="mt-1" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg3.svg"
                                alt="share" />
                        </button>

                        <!-- Vertical Line -->
                        <div class=" h-full w-0 border-l border-gray-300"></div>
                    </div>
                </div>
                <div
                    class=" hidden sm:flex xl:pl-4 lg:pl-3 justify-end flex-row sm:space-x-4 md:space-x-6 lg:space-x-3 xl:space-x-4">
                    <button
                        class="rounded-md flex space-x-2 w-24 h-10 font-normal text-sm leading-3 text-gray-800 bg-white focus:outline-none focus:bg-gray-200 hover:bg-gray-200 duration-150 justify-center items-center">
                        <p>Ver</p>
                        <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg4.svg" alt="preview" />
                    </button>

                    <!-- Save button -->
                    <button
                        class="rounded-md flex space-x-2 w-24 h-10 font-normal text-sm leading-3 text-white bg-indigo-700 focus:outline-none focus:bg-indigo-600 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 hover:bg-indigo-600 duration-150 justify-center items-center">
                        <p>Guardar</p>
                        <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg6.svg" alt="save" />
                    </button>
                </div>

                <!-- Burger Icon -->
                <div id="bgIcon" onclick="toggleMenu()"
                    class="  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800  block sm:hidden cursor-pointer">
                    <img class="dark:bg-white" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg7.svg"
                        alt="burger" />
                    <img class="dark:bg-white hidden"
                        src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg8.svg" alt="cross" />
                </div>
            </div>

            <!-- for medium-sized devices -->
            <div class="lg:hidden flex flex-auto justify-between flex-row mt-4">
                <div id="heading" class=" sm:block xl:pl-16 lg:pl-4">
                    <div class=" flex space-x-1 items-center">
                        <div class="cursor-pointer w-3 h-3 rounded-full bg-white flex justify-center items-center">
                            <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg2.svg"
                                alt="left arrow" />
                        </div>
                        <a class="focus:outline-none focus:text-gray-700 hover:text-gray-700 duration-100 dark:border-gray-200 dark:text-gray-200 border-b border-gray-600 font-normal text-xs leading-3 text-gray-600 pb-1"
                            href="{{route('admin.ventas.presupuestos.index')}}">Volver a presupuestos</a>
                    </div>
                    <h2 class=" font-bold text-xl leading-5 text-gray-800 dark:tet-white">Detalle del presupuesto</h2>
                </div>
                <div class="hidden sm:flex flex-row space-x-6 ">

                    <button
                        class="rounded-md flex space-x-2 w-24 h-10 font-normal text-sm leading-3 text-gray-800 bg-white focus:outline focus:bg-gray-200 hover:bg-gray-200 duration-150 justify-center items-center">
                        <p>Compartir</p>
                        <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg3.svg" alt="share" />
                    </button>
                </div>
            </div>


            <!-- Mobile and Small devices Navigation -->

            <div id="MobileNavigation" class="transform duration-150 sm:hidden mt-4 h-0 overflow-y-hidden">
                <hr class=" w-full bg-gray-300">
                <div class="flex flex-col gap-4 mt-4 w-72 mx-auto ">
                    <button
                        class=" rounded-md flex space-x-2 w-full h-10 font-normal text-sm leading-3 text-gray-800 bg-white focus:outline-none focus:bg-gray-200 hover:bg-gray-200 duration-150 justify-center items-center">
                        <p>Compartir</p>
                        <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg3.svg" alt="share" />
                    </button>
                    <hr class=" w-full bg-gray-300">
                    <button
                        class="rounded-md flex space-x-2 w-full h-10 font-normal text-sm leading-3 text-gray-800 bg-white focus:outline-none focus:bg-gray-200 hover:bg-gray-200 duration-150 justify-center items-center">
                        <p>Ver</p>
                        <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg4.svg" alt="preview" />
                    </button>


                    <!-- Save button -->
                    <button
                        class="rounded-md flex space-x-2 w-full h-10 font-normal text-sm leading-3 text-white bg-indigo-700 focus:outline-none focus:bg-indigo-600 hover:bg-indigo-600 duration-150 justify-center items-center">
                        <p>Guardar</p>
                        <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/header-2-svg6.svg" alt="save" />
                    </button>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Code block ends -->

<section class="bg-gray-100 py-20">
    <div class="max-w-2xl mx-auto py-0 md:py-16">
        <article class="shadow-none md:shadow-md md:rounded-md overflow-hidden">
            <div class="md:rounded-b-md  bg-white"> {{--aqui inicia --}}
                <div class="p-9 border-b border-gray-200">
                    <div class="space-y-6">
                        <div class="flex justify-between items-top">
                            <div class="space-y-4">
                                <div>
                                    <img class="h-6 object-cover mb-4" src="{{asset('images/'.$plantilla->img_icono)}}">
                                    <p class="font-bold text-lg uppercase"> Presupuesto </p>
                                    <p> {{$plantilla->razon_social}} </p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <p class="font-medium text-sm text-gray-400"> Número de Presupuesto </p>
                                    <p> PRE-{{$presupuesto->numero}} </p>
                                </div>
                                <div>
                                    <p class="font-medium text-sm text-gray-400"> Fecha presupuesto </p>
                                    <p> {{$presupuesto->fecha->format('Y/m/d')}} </p>
                                </div>
                                <div>
                                    <p class="font-medium text-sm text-gray-400"> Fecha de caducidad </p>
                                    <p> {{$presupuesto->fecha_caducidad->format('Y/m/d')}} </p>
                                </div>
                                <div>
                                    <a href="{{route('admin.pdf.presupuesto', $presupuesto)}}" target="_blank"
                                        class="inline-flex items-center text-sm font-medium text-blue-500 hover:opacity-75 ">
                                        Descargar <svg class="ml-0.5 h-4 w-4 fill-current"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path
                                                d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z">
                                            </path>
                                            <path
                                                d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-9 border-b border-gray-200">
                    <p class="font-medium text-sm text-gray-400"> Nota: </p>
                    <p class="text-sm"> {{$presupuesto->nota}}. </p>
                </div>
                <table class="w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr>
                            <th scope="col" class="px-9 py-4 text-left font-semibold text-gray-400"> Producto/Servicio
                            </th>

                            <th scope="col" class="py-3 text-left font-semibold text-gray-400"> Cantidad </th>
                            <th scope="col" class="py-3 text-left font-semibold text-gray-400"> Precio </th>
                            <th scope="col" class="py-3 text-left font-semibold text-gray-400"> </th>
                            <th scope="col" class="py-3 text-left font-semibold text-gray-400"> Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                        @foreach ($presupuesto->detalles as $detalle)
                        <tr>
                            <td class="px-6 py-5 whitespace-nowrap space-x-1 flex items-center">
                                <div>
                                    <p> {{$detalle->producto}} </p>
                                    {{-- <p class="text-sm text-gray-400"> Nuclear-armed ICBM </p> --}}
                                </div>
                            </td>

                            <td class="whitespace-nowrap text-gray-600 truncate"> {{$detalle->cantidad}} </td>
                            <td class="whitespace-nowrap text-gray-600 truncate">{{$detalle->precio}}</td>
                            <td class="whitespace-nowrap text-gray-600 truncate"></td>
                            <td class="whitespace-nowrap text-gray-600 truncate"> {{$detalle->importe}} </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="p-9 border-b border-gray-200 py-2 ml-auto mt-5 w-full sm:w-2/4 mr-2">
                    <div class="space-y-3">
                        <div class="flex justify-between mb-3">
                            <div>
                                <p class="text-gray-900 text-right flex-1 font-medium text-sm"> Subtotal </p>
                            </div>
                            <div class="text-right w-40">
                                <div class="text-gray-800 text-sm total">{{$presupuesto->subtotal}}</div>

                            </div>

                        </div>
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-900 text-right flex-1 font-medium text-sm"> IGV/18% </p>
                            </div>

                            <div class="text-right w-40">
                                <div class="text-gray-800 text-sm total">{{$presupuesto->impuesto}}</div>

                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-900 text-right flex-1 font-medium text-sm"> Total </p>
                            </div>
                            <div class="text-right w-40">
                                <div class="text-gray-800 text-sm total">{{$presupuesto->total}}</div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-9 border-b border-gray-200">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <div>
                                <p class="font-bold text-black text-lg"> Monto Total </p>
                            </div>
                            <p class="font-bold text-black text-lg"> {{$presupuesto->total}} </p>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

@stop

@section('js')
<script>
    function toggleMenu(){

        var icon = document.getElementById('bgIcon');
        const childEle = icon.children;

        childEle[0].classList.toggle('hidden');
        childEle[1].classList.toggle('hidden');

        var mobileNav = document.getElementById('MobileNavigation').classList.toggle('hidden');
        $('#MobileNavigation').removeClass('h-0');
        
    }
    
</script>
@endsection