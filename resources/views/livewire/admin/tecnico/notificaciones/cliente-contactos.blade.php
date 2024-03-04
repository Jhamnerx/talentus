<div x-data="{ openModal: @entangle('modalNotificacion').live }">

    <div x-show="openModal"
        class="fixed z-60 bottom-0 sm:bottom-2 right-0 w-full sm:max-w-[340px] mx-auto sm:mx-5 bg-white rounded-lg  border-t-2 border-r-2 border-gray-200 shadow-2xl"
        x-show="openModal" x-transition:enter="transition ease-in-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
        <!-- Cabecera del modal -->
        <div class="flex justify-between items-center p-4 border-b-2 border-gray-200">
            <h2 class="font-bold text-lg">Lista de contactos</h2>
            <button type="button" @click="openModal = false" wire:click="closeModal"
                class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times fa-lg"></i>
            </button>
        </div>
        <header class="pt-6 pb-4 px-5 border-b border-gray-200">
            <div class="flex justify-between items-center mb-3">
                <!-- Image + name -->
                <div class="flex items-center">
                    <a class="inline-flex items-start mr-3" href="#0">
                        <img class="rounded-full" src="{{asset('images/logo.png')}}" width="48" height="48"
                            alt="Lauren Marsano" />
                    </a>
                    <div class="pr-1 whitespace-nowrap">
                        <a class="inline-flex text-gray-800 hover:text-gray-900" href="#0">
                            <h2 class="text-xl leading-snug font-bold">{{$tarea ? $tarea->cliente->razon_social :
                                'Selecciona'}}</h2>
                        </a>
                    </div>
                </div>
                <!-- Settings button -->
                <div class="relative inline-flex flex-shrink-0">
                    <button
                        class="text-gray-400 hover:text-gray-500 rounded-full focus:ring-0 outline-none focus:outline-none">
                        <span class="sr-only">Ajustes</span>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                            <path
                                d="m15.621 7.015-1.8-.451A5.992 5.992 0 0 0 13.13 4.9l.956-1.593a.5.5 0 0 0-.075-.611l-.711-.707a.5.5 0 0 0-.611-.075L11.1 2.87a5.99 5.99 0 0 0-1.664-.69L8.985.379A.5.5 0 0 0 8.5 0h-1a.5.5 0 0 0-.485.379l-.451 1.8A5.992 5.992 0 0 0 4.9 2.87l-1.593-.956a.5.5 0 0 0-.611.075l-.707.711a.5.5 0 0 0-.075.611L2.87 4.9a5.99 5.99 0 0 0-.69 1.664l-1.8.451A.5.5 0 0 0 0 7.5v1a.5.5 0 0 0 .379.485l1.8.451c.145.586.378 1.147.691 1.664l-.956 1.593a.5.5 0 0 0 .075.611l.707.707a.5.5 0 0 0 .611.075L4.9 13.13a5.99 5.99 0 0 0 1.664.69l.451 1.8A.5.5 0 0 0 7.5 16h1a.5.5 0 0 0 .485-.379l.451-1.8a5.99 5.99 0 0 0 1.664-.69l1.593.956a.5.5 0 0 0 .611-.075l.707-.707a.5.5 0 0 0 .075-.611L13.13 11.1a5.99 5.99 0 0 0 .69-1.664l1.8-.451A.5.5 0 0 0 16 8.5v-1a.5.5 0 0 0-.379-.485ZM8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Meta -->
            <div class="flex flex-wrap justify-center sm:justify-start space-x-4">
                <div class="flex items-center w-full">
                    <svg class="w-4 h-4 fill-current flex-shrink-0 text-gray-400" viewBox="0 0 16 16">
                        <path
                            d="M8 8.992a2 2 0 1 1-.002-3.998A2 2 0 0 1 8 8.992Zm-.7 6.694c-.1-.1-4.2-3.696-4.2-3.796C1.7 10.69 1 8.892 1 6.994 1 3.097 4.1 0 8 0s7 3.097 7 6.994c0 1.898-.7 3.697-2.1 4.996-.1.1-4.1 3.696-4.2 3.796-.4.3-1 .3-1.4-.1Zm-2.7-4.995L8 13.688l3.4-2.997c1-1 1.6-2.198 1.6-3.597 0-2.798-2.2-4.996-5-4.996S3 4.196 3 6.994c0 1.399.6 2.698 1.6 3.697 0-.1 0-.1 0 0Z" />
                    </svg>
                    <span class="text-sm ml-2 w-full">
                        @if ($tarea)
                        {{$tarea->cliente->direccion ? $tarea->cliente->direccion : 'Sin dirección'}}
                        @endif

                    </span>
                </div>
                <div class="flex items-center w-full">
                    <svg class="w-4 h-4 fill-current flex-shrink-0 text-gray-400" viewBox="0 0 16 16">
                        <path
                            d="M11 0c1.3 0 2.6.5 3.5 1.5 1 .9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.4 3.5l-1.2 1.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l1.1-1.2c.6-.5.9-1.3.9-2.1s-.3-1.6-.9-2.2C12 1.7 10 1.7 8.9 2.8L7.7 4c-.4.4-1 .4-1.4 0-.4-.4-.4-1 0-1.4l1.2-1.1C8.4.5 9.7 0 11 0ZM8.3 12c.4-.4 1-.5 1.4-.1.4.4.4 1 0 1.4l-1.2 1.2C7.6 15.5 6.3 16 5 16c-1.3 0-2.6-.5-3.5-1.5C.5 13.6 0 12.3 0 11c0-1.3.5-2.6 1.5-3.5l1.1-1.2c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4L2.9 8.9c-.6.5-.9 1.3-.9 2.1s.3 1.6.9 2.2c1.1 1.1 3.1 1.1 4.2 0L8.3 12Zm1.1-6.8c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-4.2 4.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l4.2-4.2Z" />
                    </svg>
                    <a class="text-sm font-medium whitespace-nowrap text-indigo-500 hover:text-indigo-600 ml-2 w-full"
                        href="#0">
                        @if ($tarea)
                        {{$tarea->cliente->email ? $tarea->cliente->email : 'notiene@.com'}}
                        @endif
                    </a>
                </div>
            </div>
        </header>
        <!-- Contenido del chat -->
        <div class="overflow-y-auto p-4 pb-8 h-72">
            <!-- Mensajes del chat -->
            <h3 class="text-xs font-semibold uppercase text-gray-400 mb-1">Contactos</h3>
            <!-- Chat list -->
            <div class="divide-y divide-gray-200">
                <!-- User -->
                @if ($tarea)

                @foreach ($tarea->cliente->contactos as $contacto)
                <button wire:click="setSelected({{$contacto->id}})"
                    class="w-full text-left py-2 px-1 focus:outline-none {{$contacto->id == $selected ? 'bg-indigo-100': '' }} hover:bg-indigo-50 focus-visible:bg-indigo-50">
                    <div class="flex items-center">
                        <img class="rounded-full items-start flex-shrink-0 mr-3"
                            src="{{asset('images/auth-decoration.png')}}" width="32" height="32" alt="Marie Zulfikar" />
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">{{$contacto->nombre}}</h4>
                            <div class="text-[13px]">{{$contacto->telefono}}</div>
                        </div>
                    </div>
                </button>
                @endforeach

                @else

                @endif

            </div>
            <div>
                @if ($selected)
                <a wire:click="setSelectedNull"
                    class="mt-2 w-full hover:cursor-pointer peer-invalid:visible text-pink-600 text-sm">
                    Deseleccionar
                </a>
                @else
                <p class="mt-2 w-full peer-invalid:visible text-pink-600 text-sm">
                    Selecciona un contacto para enviar el mensaje
                </p>
                @endif

            </div>


        </div>
        <button wire:click.prevent="sendConfirmationClient"
            class="absolute bottom-2 right-3 inline-flex items-center text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-full text-center px-3 py-2 shadow-lg focus:outline-none focus-visible:ring-2">
            <svg class="w-3 h-3 fill-current text-indigo-300 flex-shrink-0 mr-2" viewBox="0 0 12 12">
                <path
                    d="M11.866.146a.5.5 0 0 0-.437-.139c-.26.044-6.393 1.1-8.2 2.913a4.145 4.145 0 0 0-.617 5.062L.305 10.293a1 1 0 1 0 1.414 1.414L7.426 6l-2 3.923c.242.048.487.074.733.077a4.122 4.122 0 0 0 2.933-1.215c1.81-1.809 2.87-7.94 2.913-8.2a.5.5 0 0 0-.139-.439Z" />
            </svg>
            <span>Enviar Mensaje</span>
        </button>
    </div>
</div>
