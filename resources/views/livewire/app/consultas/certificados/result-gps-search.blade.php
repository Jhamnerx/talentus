<div class="md:flex w-full items-start justify-center py-12 2xl:px-12 md:px-6 px-4">

    @if ($certificado)
        <div class="xl:w-2/3 md:w-1/2 lg:ml-8 md:ml-6 md:mt-0 mt-6 w-full">
            <div class="border-b border-gray-200 pb-6">

                <h1 class="lg:text-2xl text-xl font-semibold lg:leading-6 leading-7 text-gray-800 ">
                    DATOS DEL CERTIFICADO CONSULTADO</h1>
            </div>
            <div class="py-4 border-b border-gray-200 flex items-center justify-between">
                <p class="text-base leading-4 text-gray-800 ">Codigo:</p>
                <div class="flex items-center justify-center">
                    <p class="text-sm leading-none text-gray-600  mr-3">{{ $certificado->codigo }}</p>

                    <img class="" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/productDetail3-svg2.svg"
                        alt="next">
                    <img class="hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/productDetail3-svg2dark.svg"
                        alt="next">
                </div>
            </div>
            <div class="py-4 border-b border-gray-200 flex items-center justify-between">
                <p class="text-base leading-4 text-gray-800 ">Placa:</p>
                <div class="flex items-center justify-center">
                    <p class="text-sm leading-none text-gray-600 ">{{ $certificado->vehiculo->placa }}
                    </p>
                    <div class="w-6 h-6 bg-gradient-to-b from-gray-900 to-indigo-500 ml-3 mr-4 cursor-pointer"></div>
                    <img class="" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/productDetail3-svg2.svg"
                        alt="next">
                    <img class="hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/productDetail3-svg2dark.svg"
                        alt="next">
                </div>
            </div>

            <button
                class="  focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 text-base flex items-center justify-center leading-none text-white bg-gray-800 w-full py-4 hover:bg-gray-700 focus:outline-none">
                <img class="mr-3 " src="https://tuk-cdn.s3.amazonaws.com/can-uploader/svg1.svg" alt="location">
                <img class="mr-3 hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/svg1dark.svg"
                    alt="location">
                {{ $certificado->vehiculo->cliente->razon_social }}
            </button>
            <div>
                <p class="text-base leading-4 mt-7 text-gray-600 ">Fecha Inicio:
                    {{ $certificado->fin_cobertura->format('d-m-Y') }}</p>
                <p class="text-base leading-4 mt-4 text-gray-600 ">Valida Fecha Instalación:
                    {{ $certificado->fecha_instalacion->format('d-m-Y') }}
                </p>
                <p class="text-base leading-4 mt-4 text-gray-600 ">Codigo Único:
                    {{ $certificado->unique_hash }}
                </p>
                <p class="text-base leading-4 mt-4 text-gray-600 ">Emitido: {{ $certificado->fecha }}
                </p>


            </div>
            <div>
                <p class="text-base leading-4 mt-4 text-red-600 ">El codigo único debe coincidir con
                    el
                    certificado impreso</p>
            </div>
    @endif
    @if ($is_search == true && $certificado == null)
        <div class="relative px-4 py-3 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
            <span class="absolute inset-y-0 left-0 flex items-center ml-4">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                    <path
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </span>
            <p class="ml-6">ESTE CERTIFICADO NO ESTA EMITIDO!</p>
        </div>
    @endif
</div>



</div>

@push('scripts')
    <script>
        let elements = document.querySelectorAll("[data-menu]");
        for (let i = 0; i < elements.length; i++) {
            let main = elements[i];
            main.addEventListener("click", function() {
                let element = main.parentElement.parentElement;
                let andicators = main.querySelectorAll("img");
                let child = element.querySelector("#sect");
                child.classList.toggle("hidden");
                andicators[0].classList.toggle("rotate-180");
            });
        }
    </script>
@endpush
