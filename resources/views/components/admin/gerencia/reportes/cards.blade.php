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
                                {{ $icono }}
                            </div>
                            <div class="w-full pl-4 max-w-full flex-grow flex-1 mb-2 text-right undefined">
                                <h6 class="text-gray-900 font-normal tracking-wide text-base mb-1">
                                    {{ $slot }}
                                </h6>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </header>
    </div>
</div>
