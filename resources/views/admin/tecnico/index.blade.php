@extends('layouts.admin')
@section('ruta', 'tecnico-index')
@section('contenido')

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">TAREAS ✨</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <!-- Search form -->
                <form class="relative">
                    <label for="action-search" class="sr-only">Buscar</label>
                    <input wire:model="search" class="form-input pl-9 focus:border-slate-300" type="search"
                        placeholder="Buscar Clientes" />

                    <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                            viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path
                                d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                </form>

                <!-- Add customer button -->
                <a href="{{ route('admin.clientes.create') }}">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Agregar Cliente</span>
                    </button>
                </a>


            </div>

        </div>
        <!-- More actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">

            <!-- Right side -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <div class="table-items-action hidden">
                    <div class="flex items-center">
                        <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span
                                class="table-items-count"></span> items seleccionado</div>
                        <button
                            class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Eliminar</button>
                    </div>
                </div>

                <!-- Export button -->
                <div class="relative inline-flex">
                    <a href="{{ route('admin.export.clientes') }}">
                        <button
                            class="btn bg-emerald-600 hover:bg-emerald-700 text-white btn border-slate-200 hover:border-slate-300">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 32 32">
                                <path
                                    d="M16 20c.3 0 .5-.1.7-.3l5.7-5.7-1.4-1.4-4 4V8h-2v8.6l-4-4L9.6 14l5.7 5.7c.2.2.4.3.7.3zM9 22h14v2H9z" />
                            </svg>
                            <span class="hidden xs:block ml-2">Exportar</span>
                        </button>
                    </a>
                </div>

                <!-- Import button -->
                <div class="relative inline-flex">
                    <button wire:click="openModalImport()" aria-controls="basic-modal"
                        class="btn bg-blue-600 hover:bg-blue-700 text-white btn border-slate-200 hover:border-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 icon icon-tabler icon-tabler-upload"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <polyline points="7 9 12 4 17 9" />
                            <line x1="12" y1="4" x2="12" y2="16" />
                        </svg>
                        <span class="hidden xs:block ml-2">Importar</span>
                    </button>
                </div>
                <!-- contact button -->
                <div class="relative inline-flex">
                    <a href="{{ route('admin.clientes.contactos.index') }}">
                        <button
                            class="btn bg-blue-500 hover:bg-blue-600 text-white btn border-slate-200 hover:border-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-user w-6 h-6 fill-current" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="7" r="4" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                            <span class="hidden xs:block ml-2">Contactos</span>
                        </button>
                    </a>
                </div>
            </div>

        </div>



    </div>


@stop

@section('js')

@stop
