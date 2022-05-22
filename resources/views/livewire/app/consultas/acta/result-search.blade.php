<div>
    <h6>INGRESA LOS DATOS Y HAZ CLICK EN BUSCAR</h6>
    <div tabindex="0" class="focus:outline-none">
        <!-- Remove py-8 -->
        <div class="mx-auto container">

            @if ($acta)
            <div class="flex flex-wrap items-center justify-center">
                <!-- Card 1 -->
                <div tabindex="0" class="focus:outline-none mx-2 w-3/4 xl:mb-0 mb-8">
                    <div>
                        <img alt="person capturing an image"
                            src="https://cdn.tuk.dev/assets/templates/classified/Bitmap (1).png" tabindex="0"
                            class="focus:outline-none w-full h-44" />
                    </div>
                    <div class="bg-white dark:bg-gray-800">
                        <div class="flex items-center justify-between px-4 pt-4">
                            <div>
                                <img class="dark:bg-white focus:outline-none"
                                    src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-2-col-grid-svg1.svg"
                                    alt="bookmark" />
                            </div>
                            <div
                                class="vtext-white w-full md:w-1/4 bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                <p tabindex="0" class="focus:outline-none text-xs text-white">VENCIDO</p>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center">
                                <h2 tabindex="0" class="focus:outline-none text-lg dark:text-white font-semibold">ACTA
                                    REGISTRADA
                                </h2>
                                <p tabindex="0"
                                    class="focus:outline-none text-xs text-gray-600 dark:text-gray-200 pl-5">Hace 3 dias
                                </p>
                            </div>
                            <p tabindex="0" class="focus:outline-none text-xs text-gray-600 dark:text-gray-200 mt-2">
                                Esta Acta fue emitida para el vehiculo detallado</p>
                            <div class="flex mt-4">
                                <div>
                                    <p tabindex="0"
                                        class="focus:outline-none text-xs text-gray-600 dark:text-gray-200 px-2 bg-gray-200 dark:bg-gray-700 py-1">
                                        {{$acta->vehiculos->placa}}
                                    </p>
                                </div>
                                <div class="pl-2">
                                    <p tabindex="0"
                                        class="focus:outline-none text-xs text-gray-600 dark:text-gray-200 px-2 bg-gray-200 dark:bg-gray-700 py-1">
                                        {{$acta->vehiculos->flotas->clientes->razon_social}}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Card 1 Ends -->



            </div>
            @endif

            @if($is_search && !$acta)
            <div class="relative px-4 py-3 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                <span class="absolute inset-y-0 left-0 flex items-center ml-4">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                        <path
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </span>
                <p class="ml-6">ESTA ACTA NO ESTA EMITIDA!</p>
            </div>

            @endif

        </div>
    </div>
</div>