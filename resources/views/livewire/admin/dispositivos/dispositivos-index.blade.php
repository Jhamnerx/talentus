<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Dispositivos ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <form class="relative">
                <label class="sr-only">Buscar</label>
                <input wire:model.live="search" class="form-input pl-9 focus:border-slate-300" type="search"
                    placeholder="Buscar Dispositivo" />

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

            <!-- Add  button -->
            @can('crear-dispositivo')
                <button wire:click.prevent="openModalCreate" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Añadir Dispositivo</span>
                </button>
            @endcan

            @can('ver.modelos-dispositivo')
                <a href="{{ route('admin.almacen.modelos-dispositivos') }}"
                    class="btn bg-emerald-500 hover:bg-emerald-600 text-white btn border-slate-200 hover:border-slate-300"
                    aria-controls="basic-modal">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">VER MODELOS GPS</span>
                </a>
            @endcan


        </div>

    </div>
    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Right side -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Export button -->
                @can('exportar-dispositivo')
                    <div class="relative inline-flex">
                        <a href="{{ route('admin.export.dispositivos') }}">
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
                @endcan


                <!-- Import button -->
                @can('importar-dispositivo')
                    {{-- @livewire('admin.dispositivos.import') --}}
                    <button wire:click.prevent="OpenModalImport()" aria-controls="basic-modal"
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
                @endcan

                <div class="relative inline-flex">

                    <button wire:click.prevent="consultaFota()" wire:loading.attr="disabled"
                        wire:loading.class="bg-[#62abf3]" wire:loading.class.remove="hover:bg-[#0054A6] bg-[#477dd8]"
                        class="btn bg-[#4790d8] hover:bg-[#0054A6] text-white btn border-slate-200 hover:border-slate-300">
                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                            <g fill="currentColor" class="nc-icon-wrapper">
                                <path
                                    d="M22.707,8.293A1,1,0,0,0,21,9v6H17a17,17,0,0,0,0,34h9a2,2,0,0,0,0-4H17a13,13,0,0,1,0-26H31a1,1,0,0,0,.707-1.707Z">
                                </path>
                                <path data-color="color-2"
                                    d="M47,15H38a2,2,0,0,0,0,4h9a13,13,0,0,1,0,26H33a1,1,0,0,0-.707,1.707l9,9A1,1,0,0,0,42,56a.987.987,0,0,0,.383-.076A1,1,0,0,0,43,55V49h4a17,17,0,0,0,0-34Z">
                                </path>
                            </g>
                        </svg>
                        <span class="hidden xs:block ml-2">Consultar Fota</span>
                    </button>

                </div>
                <div class="relative inline-flex" wire:loading wire:target="consultaFota">
                    Consultando a fota web...
                </div>

            </div>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Total dispositivos <span
                    class="text-slate-400 font-medium">{{ $dispositivos->total() }}</span>
            </h2>

        </header>
        <div>
            <!-- Table -->
            <div class="overflow-x-auto min-h-screen">

                <table class="table-auto w-full">
                    <!-- Table header -->
                    <thead
                        class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">IMEI</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">MODELO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">MARCA</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">FOTA</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">VEHICULO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Registrado por:</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha registro:</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">ACCIONES</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->
                        @foreach ($dispositivos as $dispositivo)
                            <tr wire:key="device-{{ $dispositivo->id }}">

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 shrink-0 flex items-center justify-center bg-slate-100 rounded-full mr-2 sm:mr-3">
                                            @if ($dispositivo->modelo->image)
                                                <img class="ml-1"
                                                    src="{{ Storage::url($dispositivo->modelo->image->url) }}.webp"
                                                    width="20" height="20" alt="Icon 01" />
                                            @else
                                                {{-- <img class="ml-1"
                                            src="{{ Storage::url($dispositivo->modelo->image->url) }}.webp" width="20"
                                            height="20" alt="Icon 01" /> --}}
                                            @endif

                                        </div>
                                        @if ($dispositivo->of_client)
                                            <div class="font-medium text-blue-400">{{ $dispositivo->imei }}</div>
                                        @else
                                            <div class="font-medium text-slate-800">{{ $dispositivo->imei }}</div>
                                        @endif

                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ $dispositivo->modelo->modelo }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ $dispositivo->modelo->marca }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @if ($dispositivo->in_fota)
                                        <div class="text-left">

                                            <svg width="222" height="24" viewBox="0 0 222 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" class="css-4g6ai3">
                                                <g clip-path="url(#clip0_9678_2200)">
                                                    <path d="M133.543 7.21173H132.332V18.2822H133.543V7.21173Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M23.2224 19.8643L15.3188 11.9988L23.2224 4.13684L26.0587 6.95864L29.5558 3.47932L26.0587 0L22.5615 3.48167L19.0619 0L15.5624 3.48167L12.064 0L0 11.9976L12.064 24L15.5635 20.5195L19.0607 24L22.5603 20.5195L26.0575 24L29.5547 20.5207L26.0575 17.0414L23.2212 19.8632L23.2224 19.8643ZM9.2277 19.8643L1.32534 11.9976L9.2277 4.13684L12.0652 6.95864L6.99674 11.9976L12.0652 17.0414L9.2277 19.8632V19.8643ZM16.2256 19.8643L8.32208 11.9988L16.2256 4.13684L19.0631 6.95864L14.0018 11.9976L19.0631 17.0414L16.2256 19.8632V19.8643Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M47.1482 13.8161L47.9734 11.3201H43.2963L43.7657 9.86983H49.3153L50.1713 7.26917H41.0914L37.5103 18.1435H46.8184L47.6861 15.4946H41.9202L42.4687 13.8161H47.1482Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M39.7932 7.26917H29.1503L28.208 10.1263H31.8187L29.1751 18.1435H32.709L35.3466 10.1263H38.8485L39.7932 7.26917Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M55.6723 7.26917H52.1443L48.562 18.1435H57.2128L58.1621 15.2547H53.0417L55.6723 7.26917Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M97.8516 7.26917L94.2681 18.1435H97.8776L101.461 7.26917H97.8516Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M124 18.1435L123.378 7.26917H119.801L112.13 18.0071L109.585 11.2766L115.212 7.27034H110.964L106.025 10.8685L107.208 7.27034H103.718L100.138 18.1447H103.621L104.764 14.6807L106.234 13.7879L107.84 18.1447H115.485L116.423 16.7073H120.518L120.498 18.1447H123.999L124 18.1435ZM117.89 14.4195L120.473 10.6556L120.583 14.4195H117.891H117.89Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M92.2369 7.26917L90.1998 13.8785L88.3744 7.26917H85.0238L81.4438 18.1435H84.7909L86.8114 11.5648L88.6569 18.1435H92.004L95.5875 7.26917H92.2369Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M71.0056 7.26917H60.3674L59.4204 10.1263H63.0311L60.3899 18.1435H63.9237L66.5614 10.1263H70.0609L71.0056 7.26917Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M81.7561 12.0929C81.7892 11.9506 81.8329 11.7189 81.8826 11.3954C82.0954 10.0157 81.8329 8.93356 81.0881 8.15489C80.3503 7.37387 79.2095 6.98218 77.6713 6.98218C75.9097 6.98218 74.3337 7.50678 72.954 8.5454C71.5684 9.59225 70.5871 10.9802 70.0054 12.714C69.8458 13.1963 69.7394 13.6221 69.6862 13.9855C69.4734 15.3664 69.7358 16.4533 70.4771 17.2402C71.2149 18.0341 72.3558 18.4293 73.8915 18.4293C75.6863 18.4293 77.2622 17.9189 78.6219 16.8967C79.9815 15.8734 80.9651 14.4795 81.5575 12.7152C81.6532 12.4458 81.7171 12.2388 81.7573 12.0953L81.7561 12.0929ZM78.2825 11.653C78.24 11.9377 78.1501 12.2905 78.0094 12.7128C77.7068 13.6209 77.3308 14.3172 76.8792 14.803C76.3176 15.4064 75.626 15.7063 74.8019 15.7063C74.141 15.7063 73.6882 15.5146 73.4517 15.1347C73.2519 14.8206 73.2023 14.3678 73.2957 13.7726C73.3193 13.6021 73.3595 13.4256 73.4056 13.2433C73.4517 13.061 73.5049 12.8857 73.5617 12.714C73.8679 11.8059 74.2403 11.112 74.679 10.6285C75.2441 10.0204 75.9393 9.71929 76.7763 9.71929C77.4372 9.71929 77.8865 9.91219 78.1229 10.2933C78.3227 10.6073 78.3724 11.059 78.2825 11.6542V11.653Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M142.511 18.3927V7.32916H150.096V9.20216H144.744V11.8197H149.363V13.6927H144.744V18.3927H142.511Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M151.492 12.9365C151.492 11.8081 151.655 10.8657 151.992 10.0979C152.248 9.53952 152.585 9.02764 153.027 8.58556C153.469 8.14349 153.935 7.80612 154.458 7.58508C155.145 7.29424 155.947 7.14301 156.843 7.14301C158.472 7.14301 159.775 7.64325 160.752 8.65537C161.729 9.66748 162.218 11.0751 162.218 12.8783C162.218 14.6699 161.729 16.0659 160.764 17.0664C159.798 18.0785 158.495 18.5788 156.866 18.5788C155.226 18.5788 153.911 18.0785 152.946 17.0781C151.969 16.0776 151.492 14.6932 151.492 12.9365ZM153.784 12.8551C153.784 14.1115 154.074 15.0538 154.656 15.7053C155.238 16.3568 155.971 16.6709 156.855 16.6709C157.739 16.6709 158.472 16.3451 159.042 15.7053C159.612 15.0654 159.903 14.0999 159.903 12.8202C159.903 11.5521 159.624 10.6098 159.065 9.98159C158.507 9.35338 157.774 9.05091 156.855 9.05091C155.936 9.05091 155.191 9.36501 154.633 9.99322C154.074 10.6331 153.784 11.587 153.784 12.8551Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M166.453 18.3927V9.20216H163.172V7.32916H171.967V9.20216H168.698V18.3927H166.453Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M182.228 18.3927H179.796L178.831 15.8798H174.41L173.503 18.3927H171.129L175.434 7.32916H177.795L182.228 18.3927ZM178.11 14.0185L176.586 9.91181L175.096 14.0185H178.11Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M188.696 18.3927L186.055 7.32916H188.347L190.011 14.9259L192.035 7.32916H194.687L196.63 15.0538L198.329 7.32916H200.574L197.886 18.3927H195.513L193.315 10.1212L191.116 18.3927H188.696Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M201.714 18.3927V7.32916H209.916V9.20216H203.948V11.6568H209.497V13.5182H203.948V16.5313H210.125V18.3927H201.714Z"
                                                        fill="#001A77"></path>
                                                    <path
                                                        d="M212.033 7.32916H216.453C217.326 7.32916 217.977 7.36406 218.408 7.43386C218.838 7.50367 219.222 7.6549 219.56 7.88757C219.897 8.12024 220.188 8.42272 220.409 8.80662C220.63 9.19053 220.746 9.62097 220.746 10.0979C220.746 10.6215 220.607 11.0868 220.327 11.5289C220.048 11.9593 219.664 12.2851 219.187 12.5061C219.862 12.7039 220.374 13.0412 220.746 13.5066C221.107 13.9836 221.293 14.5303 221.293 15.1702C221.293 15.6704 221.177 16.159 220.944 16.636C220.711 17.113 220.386 17.4969 219.99 17.7761C219.583 18.0553 219.083 18.2298 218.489 18.2996C218.117 18.3345 217.221 18.3694 215.79 18.3694H212.021V7.32916H212.033ZM214.266 9.1789V11.7383H215.732C216.605 11.7383 217.14 11.7266 217.349 11.7034C217.733 11.6568 218.036 11.5289 218.257 11.3078C218.478 11.0868 218.582 10.796 218.582 10.447C218.582 10.1096 218.489 9.83037 218.303 9.60934C218.117 9.39993 217.838 9.26033 217.465 9.22543C217.244 9.20216 216.605 9.19053 215.558 9.19053H214.266V9.1789ZM214.266 13.5764V16.5313H216.337C217.14 16.5313 217.652 16.508 217.873 16.4615C218.21 16.4033 218.478 16.2521 218.687 16.0194C218.896 15.7867 219.001 15.4726 219.001 15.0771C219.001 14.7397 218.92 14.4605 218.757 14.2279C218.594 13.9952 218.361 13.8323 218.059 13.7276C217.756 13.6229 217.093 13.5647 216.081 13.5647H214.266V13.5764Z"
                                                        fill="#001A77"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_9678_2200">
                                                        <rect width="222" height="24" fill="white">
                                                        </rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                        </div>
                                    @endif

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                    @if (!empty($dispositivo->vehiculos))
                                        <div class="font-medium text-sky-500">
                                            {{ $dispositivo->vehiculos->placa }}
                                        </div>
                                    @else
                                        <div class="font-medium text-emerald-500">
                                            Equipo Disponible
                                        </div>
                                    @endif

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 text-sm">
                                        {{ $dispositivo->user ? $dispositivo->user->name : '' }}

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 text-sm">
                                        {{ $dispositivo->created_at->format('d-m-Y h:m') }}

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="relative inline-flex" x-data="{ open: false }">
                                        <div class="relative inline-block h-full text-left">
                                            <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                :class="{ 'bg-slate-100 text-slate-500': open }" aria-haspopup="true"
                                                @click.prevent="open = !open" :aria-expanded="open">
                                                <span class="sr-only">Menu</span>
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="2" />
                                                    <circle cx="10" cy="16" r="2" />
                                                    <circle cx="22" cy="16" r="2" />
                                                </svg>
                                            </button>
                                            <div class="origin-top-right  z-10 absolute transform  -translate-x-3/4  top-full left-0 min-w-36 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1  ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
                                                @click.outside="open = false" @keydown.escape.window="open = false"
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200 transform"
                                                x-transition:enter-start="opacity-0 -translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>
                                                <ul>

                                                    <li>
                                                        <a href="javascript: void(0)"
                                                            wire:click.prevent='openModalEdit({{ $dispositivo->id }})'
                                                            class="text-gray-700 cursor-pointer group flex items-center px-4 py-2 text-sm font-normal"
                                                            disabled="false" id="headlessui-menu-item-27"
                                                            role="menuitem" tabindex="-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                </path>
                                                            </svg> Editar

                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="javascript: void(0)"
                                                            wire:click.prevent="verInfoDispositivo({{ $dispositivo }}) "class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                            disabled="false" id="headlessui-menu-item-29"
                                                            role="menuitem" tabindex="-1"><svg
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                class="h-5 w-5  mr-3 text-gray-400 group-hover:text-violet-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg>
                                                            Ver Información
                                                        </a>
                                                    </li>

                                                </ul>


                                            </div>
                                        </div>

                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        @if ($dispositivos->count() < 1)
                            <tr>
                                <td colspan="8"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                    <div class="text-center">No hay Registros</div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $dispositivos->links() }}

    </div>
</div>
