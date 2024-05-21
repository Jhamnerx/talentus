@extends('layouts.admin')
@section('ruta', 'administracion-ajustes')
@section('panel', "settingsPanel: 'plantilla',")
@section('contenido')

    <!-- Table -->

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

        <!-- Page header -->
        <div class="mb-8">

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"> Plantilla ✨</h1>

        </div>

        <div class="bg-white shadow-lg rounded-sm mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">

                <!-- Sidebar -->

                <x-admin.settings.navigation></x-admin.settings.navigation>
                <div class="grow">
                    <div>
                        <!-- Profile background -->
                        <div class="h-56 bg-slate-200">
                            <img class="object-cover h-full w-full" src="{{ asset('storage/' . $plantilla->banner) }}"
                                width="2560" height="440" alt="Company background" />
                        </div>

                        <!-- Header -->
                        <header class="text-center bg-slate-50 pb-6 border-b border-slate-200">
                            <div class="px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-3xl mx-auto">

                                    <!-- Avatar -->
                                    <div class="-mt-12 mb-2">
                                        <div class="inline-flex -ml-1 -mt-1 sm:mb-0">
                                            <img class="rounded-full border-4 border-white"
                                                src="{{ asset('storage/' . $plantilla->logo) }}" width="104"
                                                height="104" alt="Avatar" />
                                        </div>
                                    </div>

                                    <!-- Company name and info -->
                                    <div class="mb-4">
                                        <h2 class="text-2xl text-slate-800 font-bold mb-2">{{ $plantilla->razon_social }}
                                        </h2>

                                    </div>
                                    <!-- Meta -->
                                    <div class="inline-flex flex-wrap justify-center sm:justify-start space-x-4">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 fill-current shrink-0 text-slate-400" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 8.992a2 2 0 1 1-.002-3.998A2 2 0 0 1 8 8.992Zm-.7 6.694c-.1-.1-4.2-3.696-4.2-3.796C1.7 10.69 1 8.892 1 6.994 1 3.097 4.1 0 8 0s7 3.097 7 6.994c0 1.898-.7 3.697-2.1 4.996-.1.1-4.1 3.696-4.2 3.796-.4.3-1 .3-1.4-.1Zm-2.7-4.995L8 13.688l3.4-2.997c1-1 1.6-2.198 1.6-3.597 0-2.798-2.2-4.996-5-4.996S3 4.196 3 6.994c0 1.399.6 2.698 1.6 3.697 0-.1 0-.1 0 0Z" />
                                            </svg>
                                            <span
                                                class="text-sm font-medium whitespace-nowrap text-slate-500 ml-2">{{ $plantilla->direccion['departamento'] }},
                                                PERÚ</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 fill-current shrink-0 text-slate-400" viewBox="0 0 16 16">
                                                <path
                                                    d="M11 0c1.3 0 2.6.5 3.5 1.5 1 .9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.4 3.5l-1.2 1.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l1.1-1.2c.6-.5.9-1.3.9-2.1s-.3-1.6-.9-2.2C12 1.7 10 1.7 8.9 2.8L7.7 4c-.4.4-1 .4-1.4 0-.4-.4-.4-1 0-1.4l1.2-1.1C8.4.5 9.7 0 11 0ZM8.3 12c.4-.4 1-.5 1.4-.1.4.4.4 1 0 1.4l-1.2 1.2C7.6 15.5 6.3 16 5 16c-1.3 0-2.6-.5-3.5-1.5C.5 13.6 0 12.3 0 11c0-1.3.5-2.6 1.5-3.5l1.1-1.2c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4L2.9 8.9c-.6.5-.9 1.3-.9 2.1s.3 1.6.9 2.2c1.1 1.1 3.1 1.1 4.2 0L8.3 12Zm1.1-6.8c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-4.2 4.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l4.2-4.2Z" />
                                            </svg>
                                            <a class="text-sm font-medium whitespace-nowrap text-indigo-500 hover:text-indigo-600 ml-2"
                                                href="#0">{{ $plantilla->razon_social }}</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </header>

                        <!-- Page content -->
                        <div class="px-4 sm:px-6 lg:px-8 py-8 w-full bg-slate-50">



                            @livewire('admin.ajustes.plantilla.datos-empresa', ['plantilla' => $plantilla])


                            {{-- FORMULARIOS DE IMAGENES --}}
                            <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 bg-white px-3 mb-2">

                                @livewire('admin.ajustes.plantilla.images.documentos', ['plantilla' => $plantilla], key('doc' . $plantilla->id))
                                @livewire('admin.ajustes.plantilla.images.contrato', ['plantilla' => $plantilla], key('contrato' . $plantilla->id))
                                @livewire('admin.ajustes.plantilla.images.logo', ['plantilla' => $plantilla], key('logo' . $plantilla->id))
                                @livewire('admin.ajustes.plantilla.images.fav-icon', ['plantilla' => $plantilla], key('fav-icon' . $plantilla->id))
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 bg-white px-3 mb-2">

                                @livewire('admin.ajustes.plantilla.images.banner', ['plantilla' => $plantilla], key('banner' . $plantilla->id))
                                @livewire('admin.ajustes.plantilla.images.firma', ['plantilla' => $plantilla], key('firma' . $plantilla->id))


                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>


@stop

@push('modals')
    @livewire('admin.ajustes.plantilla.del-images')
@endpush

@section('js')

@endsection
