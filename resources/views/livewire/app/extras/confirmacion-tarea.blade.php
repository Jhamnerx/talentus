<div class="overflow-y-auto sm:p-0 pt-4 pr-4 pb-20 pl-4 bg-gray-800">
    <div class="flex justify-center items-center text-center min-h-screen sm:block">
        <div class="bg-gray-500 transition-opacity bg-opacity-75"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>

        {{-- confirmar --}}
        @if (!$tarea->respuesta)


        <div class="inline-block text-left bg-gray-900 rounded-lg overflow-hidden align-middle transition-all transform
        shadow-2xl sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
            <div class="items-center w-full mr-auto ml-auto relative max-w-7xl md:px-10 lg:px-16">
                <div class="grid grid-cols-1">
                    <div class="mt-4 mr-auto mb-4 ml-auto bg-gray-900 max-w-lg">
                        <div class="flex flex-col items-center pt-6 pr-6 pb-6 pl-6">
                            <img src="https://images.pexels.com/photos/2379005/pexels-photo-2379005.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;w=500"
                                class="flex-shrink-0 object-cover object-center btn- flex w-16 h-16 mr-auto -mb-8 ml-auto rounded-full shadow-xl">
                            <p class="mt-8 text-2xl font-semibold leading-none text-white tracking-tighter lg:text-3xl">
                                HOLA {{$tarea->vehiculo->cliente->razon_social}}!
                            </p>
                            <p class="mt-3 text-base leading-relaxed text-center text-gray-200">
                                Se ha finalizado la visita tecnico, por favor confirmar la correcta finalizacíon de
                                nuestro tecnico.

                            </p>
                            <div class="w-full mt-6">

                                <button wire:loading.remove wire:click="confirmar({{$tarea}})"
                                    class="flex text-center items-center justify-center w-full pt-4 pr-10 pb-4 pl-10 text-base font-medium text-white bg-indigo-600 rounded-xl transition duration-500 ease-in-out transform hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Confirmar
                                </button>

                                <button wire:loading wire:target="confirmar" type="button"
                                    class="bg-indigo-500 flex text-center items-center justify-center w-full pt-4 pr-10 pb-4 pl-10 text-base font-medium text-white rounded-xl transition duration-500 ease-in-out transform hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    disabled>
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Procesando Solicitud...
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else


        {{-- confirmada --}}
        <div class="inline-block text-left bg-gray-900 rounded-lg overflow-hidden align-middle transition-all transform
        shadow-2xl sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
            <div
                class="w-96 md:w-auto align-middle dark:bg-gray-800 relative flex flex-col justify-center items-center bg-white py-16 px-4 md:px-24 xl:px-36">
                <div role="banner">

                    <svg class="w-20 md:w-24 lg:w-28" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4.91988 12.257C4.2856 12.257 3.65131 12.5199 3.19988 13.0342C2.79417 13.4913 2.59417 14.0799 2.63417 14.6913C2.67417 15.3027 2.94846 15.857 3.4056 16.2627L7.51417 19.8684C7.93131 20.2342 8.46846 20.4399 9.02274 20.4399C9.0856 20.4399 9.14846 20.4399 9.21131 20.4342C9.82846 20.3827 10.4056 20.0799 10.7942 19.5999L20.857 7.27986C21.657 6.30272 21.5085 4.85701 20.5313 4.05701C20.057 3.67415 19.4627 3.49129 18.857 3.55415C18.2513 3.61701 17.7027 3.90844 17.3142 4.38272L8.74846 14.8627L6.42274 12.8227C5.99417 12.4456 5.45131 12.257 4.91988 12.257Z"
                            fill="url(#paint0_linear)" />
                        <path
                            d="M9.02279 20.0284C8.56565 20.0284 8.12565 19.8627 7.78279 19.5598L3.67422 15.9541C2.89708 15.2684 2.81708 14.0798 3.50279 13.3027C4.18851 12.5255 5.37708 12.4455 6.15422 13.1313L8.79994 15.4513L17.6285 4.63983C18.2856 3.83412 19.4685 3.71983 20.2742 4.37126C21.0799 5.0284 21.1942 6.21126 20.5428 7.01697L10.4742 19.337C10.1542 19.7313 9.67993 19.977 9.17708 20.0227C9.12565 20.0227 9.07422 20.0284 9.02279 20.0284Z"
                            fill="url(#paint1_linear)" />
                        <path opacity="0.75"
                            d="M9.02279 20.0284C8.56565 20.0284 8.12565 19.8627 7.78279 19.5598L3.67422 15.9541C2.89708 15.2684 2.81708 14.0798 3.50279 13.3027C4.18851 12.5255 5.37708 12.4455 6.15422 13.1313L8.79994 15.4513L17.6285 4.63983C18.2856 3.83412 19.4685 3.71983 20.2742 4.37126C21.0799 5.0284 21.1942 6.21126 20.5428 7.01697L10.4742 19.337C10.1542 19.7313 9.67993 19.977 9.17708 20.0227C9.12565 20.0227 9.07422 20.0284 9.02279 20.0284Z"
                            fill="url(#paint2_radial)" />
                        <path opacity="0.5"
                            d="M9.02279 20.0284C8.56565 20.0284 8.12565 19.8627 7.78279 19.5598L3.67422 15.9541C2.89708 15.2684 2.81708 14.0798 3.50279 13.3027C4.18851 12.5255 5.37708 12.4455 6.15422 13.1313L8.79994 15.4513L17.6285 4.63983C18.2856 3.83412 19.4685 3.71983 20.2742 4.37126C21.0799 5.0284 21.1942 6.21126 20.5428 7.01697L10.4742 19.337C10.1542 19.7313 9.67993 19.977 9.17708 20.0227C9.12565 20.0227 9.07422 20.0284 9.02279 20.0284Z"
                            fill="url(#paint3_radial)" />
                        <defs>
                            <linearGradient id="paint0_linear" x1="15.825" y1="-13.9667" x2="9.82533" y2="23.9171"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#00CC00" />
                                <stop offset="0.1878" stop-color="#06C102" />
                                <stop offset="0.5185" stop-color="#17A306" />
                                <stop offset="0.9507" stop-color="#33740C" />
                                <stop offset="1" stop-color="#366E0D" />
                            </linearGradient>
                            <linearGradient id="paint1_linear" x1="15.2501" y1="0.625426" x2="7.43443" y2="23.6215"
                                gradientUnits="userSpaceOnUse">
                                <stop offset="0.2544" stop-color="#90D856" />
                                <stop offset="0.736" stop-color="#00CC00" />
                                <stop offset="0.7716" stop-color="#0BCD07" />
                                <stop offset="0.8342" stop-color="#29CF18" />
                                <stop offset="0.9166" stop-color="#59D335" />
                                <stop offset="1" stop-color="#90D856" />
                            </linearGradient>
                            <radialGradient id="paint2_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse"
                                gradientTransform="translate(15.452 8.95803) rotate(116.129) scale(8.35776 4.28316)">
                                <stop stop-color="#FBE07A" stop-opacity="0.75" />
                                <stop offset="0.0803394" stop-color="#FBE387" stop-opacity="0.6897" />
                                <stop offset="0.5173" stop-color="#FDF2C7" stop-opacity="0.362" />
                                <stop offset="0.8357" stop-color="#FFFBF0" stop-opacity="0.1233" />
                                <stop offset="1" stop-color="white" stop-opacity="0" />
                            </radialGradient>
                            <radialGradient id="paint3_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse"
                                gradientTransform="translate(11.6442 17.0245) rotate(155.316) scale(9.80163 4.14906)">
                                <stop stop-color="#440063" stop-opacity="0.25" />
                                <stop offset="1" stop-color="#420061" stop-opacity="0" />
                            </radialGradient>
                        </defs>
                    </svg>
                </div>
                <div class="mt-12">
                    <h1 role="main"
                        class="text-3xl dark:text-white lg:text-4xl font-semibold leading-7 lg:leading-9 text-center text-gray-800">
                        TAREA CONFIRMADA
                    </h1>
                </div>
                <div class="mt">
                    <p class="mt-6 sm:w-80 text-base dark:text-white leading-7 text-center text-gray-800">
                        La tarea ha sido confirmada con éxito!
                    </p>
                </div>
                <button wire:click="back"
                    class="w-full dark:text-gray-800 dark:hover:bg-gray-100 dark:bg-white sm:w-auto mt-14 text-base leading-4 text-center text-white py-6 px-16 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 bg-gray-800 hover:bg-black">
                    VOLVER ATRAS
                </button>
                <a href="javascript:void(0)"
                    class="mt-6 dark:text-white dark:hover:border-white text-base leading-none focus:outline-none hover:border-gray-800 focus:border-gray-800 border-b border-transparent text-center text-gray-800">
                    Solicita el reporte de la tarea si la necesitas.
                </a>
                <button onclick="showMenu(true)"
                    class="text-gray-800 dark:text-gray-400 absolute top-8 right-8 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800"
                    aria-label="close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M6 6L18 18" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>
