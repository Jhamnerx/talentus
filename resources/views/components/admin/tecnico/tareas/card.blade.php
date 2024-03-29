<div
    class="flex flex-col col-span-full sm:col-span-6 xl:col-span-3 bg-white shadow-lg rounded-xl border border-slate-200">
    <div class="px-2 py-2">
        <header class="flex justify-between items-start mb-2">
            <div class="flex flex-col w-full rounded-sm">
                <div class="px-1 mt-6">
                    <div class="w-full bg-white rounded-xl overflow-hdden shadow-md p-4 undefined">
                        <div class="flex flex-wrap border-b border-gray-200 undefined">
                            <div {{ $attributes }}
                                class="bg-gradient-to-tr {{ $colorInitial }} {{ $colorFinal }} hover:scale-75 ease-in duration-500 cursor-pointer -mt-10 rounded-xl text-white grid items-center w-24 h-24 py-4 px-4 justify-center shadow-lg-blue mb-0">
                                <svg class="w-full fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                    <g stroke-linecap="square" stroke-width="2" fill="none" stroke="currentColor"
                                        stroke-linejoin="miter" class="nc-icon-wrapper" stroke-miterlimit="10">
                                        <path
                                            d="M47.75,37.458,56.352,45a8.034,8.034,0,0,1,.575,11.347c-.091.1-.184.2-.28.3h0a8.035,8.035,0,0,1-11.363,0c-.1-.1-.189-.2-.28-.3L35.667,46.167">
                                        </path>
                                        <polyline data-cap="butt"
                                            points="29.439 25.439 20 16 20 12 13 5 5 13 12 20 16 20 25.234 29.234"
                                            stroke-linecap="butt"></polyline>
                                        <path
                                            d="M58.376,14.5,51,21.879l-8.872-8.872L49.5,5.629a15.142,15.142,0,0,0-5.266-.586,13.9,13.9,0,0,0-12.7,12.7,15.124,15.124,0,0,0,.588,5.271L6.283,46.344a3.89,3.89,0,0,0-.277,5.495c.044.049.089.1.135.142l5.882,5.882a3.891,3.891,0,0,0,5.5-.009c.044-.045.088-.09.13-.137L41,31.881a15.127,15.127,0,0,0,5.272.588,13.9,13.9,0,0,0,12.7-12.7A15.145,15.145,0,0,0,58.376,14.5Z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            <div class="w-full pl-4 max-w-full flex-grow flex-1 mb-2 text-right undefined">
                                <h5 class="text-gray-900 font-normal tracking-wide text-base xl:text-lg mb-1">
                                    {{ $slot }}
                                </h5>
                                <span class="text-base xl:text-lg text-gray-600">{{ $cantidad }} Tareas</span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </header>
    </div>
</div>
