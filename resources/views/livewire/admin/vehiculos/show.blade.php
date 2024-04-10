<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Informacion Detallada Vehiculo ✨</h1>
        </div>

    </div>

    <!-- Filters -->
    <div class="mb-4 border-b border-slate-200">
        <ul class="text-sm font-medium flex flex-nowrap -mx-4 sm:-mx-6 lg:-mx-8 overflow-x-scroll no-scrollbar">
            <li class="pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                <a class="text-indigo-500 whitespace-nowrap" href="#0">Ver Todo</a>
            </li>
        </ul>
    </div>

    <!-- Cards -->
    <div class="grid grid-cols-12 gap-x-4 gap-y-8">



        <!-- Column 4 -->
        <div class="col-span-full sm:col-span-6 xl:col-span-4">

            <!-- Column header -->
            <header>
                <div class="flex items-center justify-between mb-2">
                    <h2 class="grow font-semibold text-slate-800 truncate">Datos Vehiculos 🚍 </h2>
                    <button class="shrink-0 text-indigo-500 hover:text-indigo-600 ml-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                    </button>
                </div>

                <!-- Cards -->
                <div class="grid gap-2">

                    <!-- Card 1 -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <div class="flex items-center mb-2">
                                <div class="flex shrink-0 -space-x-3 -ml-px mr-2">
                                    <a class="block" href="javascript: void(0)">
                                        <img class="rounded-full border-2 border-white box-content"
                                            src="{{ asset('images/camioneta.png') }}" width="64" height="64" />
                                    </a>
                                </div>
                                <div class="grow">
                                    <a class="inline-flex text-slate-800 hover:text-slate-900"
                                        href="javascript: void(0)">
                                        <h2
                                            class="font-semibold {{ $vehiculo->estado == 1 ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ $vehiculo->placa }}</h2>
                                    </a>
                                    <div class="text-xs font-medium text-slate-500">
                                        {{ $vehiculo->created_at->format('h:m a, d-m-Y') }}</div>
                                </div>
                            </div>
                            <!-- Content -->
                            <div>

                                <div
                                    class="hidden 2xl:flex flex-col col-span-full xl:col-span-4 bg-gradient-to-b from-slate-700 to-slate-800 shadow-lg rounded-sm border border-slate-800">
                                    <header class="px-5 py-4 border-b border-slate-600 flex items-center">
                                        <h2 class="font-semibold text-slate-200">TARJETA</h2>
                                    </header>
                                    <div class="h-full flex flex-col px-5 py-6">

                                        <div class="relative w-full max-w-sm mx-auto bg-slate-800 p-3 rounded-2xl">

                                            <div
                                                class="relative aspect-[7/4] bg-gradient-to-tr from-indigo-500 to-indigo-400 p-5 rounded-xl overflow-hidden">

                                                <div class="absolute left-0 -bottom-1/3 w-[398px] aspect-square"
                                                    aria-hidden="true">
                                                    <svg class="w-full h-full" width="398" height="392"
                                                        viewBox="0 0 398 392" xmlns="http://www.w3.org/2000/svg">
                                                        <defs>
                                                            <filter x="-88.2%" y="-88.2%" width="276.5%" height="276.5%"
                                                                filterUnits="objectBoundingBox" id="glow-a">
                                                                <feGaussianBlur stdDeviation="50" in="SourceGraphic" />
                                                            </filter>
                                                        </defs>
                                                        <circle class="fill-indigo-100 opacity-60" filter="url(#glow-a)"
                                                            cx="85" cy="85" r="85"
                                                            transform="translate(0 216)" />
                                                    </svg>
                                                </div>
                                                <div class="absolute right-0 -top-1/3 w-[398px] aspect-square"
                                                    aria-hidden="true">
                                                    <svg class="w-full h-full" width="398" height="392"
                                                        viewBox="0 0 398 392" xmlns="http://www.w3.org/2000/svg">
                                                        <defs>
                                                            <filter x="-88.2%" y="-88.2%" width="276.5%" height="276.5%"
                                                                filterUnits="objectBoundingBox" id="glow-b">
                                                                <feGaussianBlur stdDeviation="50" in="SourceGraphic" />
                                                            </filter>
                                                        </defs>
                                                        <circle class="fill-sky-400 opacity-60" filter="url(#glow-b)"
                                                            cx="85" cy="85" r="85"
                                                            transform="translate(228 0)" />
                                                    </svg>
                                                </div>
                                                <div class="relative h-full flex flex-col justify-between">

                                                    <svg width="32" height="32" viewBox="0 0 32 32"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                        <defs>
                                                            <linearGradient x1="50%" y1="0%" x2="50%"
                                                                y2="100%" id="icon1-b">
                                                                <stop stop-color="#A5B4FC" offset="0%" />
                                                                <stop stop-color="#E0E7FF" offset="100%" />
                                                            </linearGradient>
                                                            <linearGradient x1="50%" y1="24.537%" x2="50%"
                                                                y2="100%" id="icon1-c">
                                                                <stop stop-color="#4338CA" offset="0%" />
                                                                <stop stop-color="#6366F1" stop-opacity="0"
                                                                    offset="100%" />
                                                            </linearGradient>
                                                            <path id="icon1-a" d="M16 0l16 32-16-5-16 5z" />
                                                        </defs>
                                                        <g transform="rotate(90 16 16)" fill="none"
                                                            fill-rule="evenodd">
                                                            <mask id="icon1-d" fill="#fff">
                                                                <use xlink:href="#icon1-a" />
                                                            </mask>
                                                            <use fill="url(#icon1-b)" xlink:href="#icon1-a" />
                                                            <path fill="url(#icon1-c)" mask="url(#icon1-d)"
                                                                d="M16-6h20v38H16z" />
                                                        </g>
                                                    </svg>


                                                    <div
                                                        class="flex justify-between text-lg font-bold gap-8 text-slate-200 tracking-widest drop-shadow-sm">
                                                        <span class="text-xs">{{ $vehiculo->marca }}</span>
                                                        <span class="text-xs">{{ $vehiculo->modelo }}</span>
                                                        <span class="text-xs">{{ $vehiculo->tipo }}</span>
                                                    </div>

                                                    <div
                                                        class="relative flex gap-2 justify-between items-center z-10 mb-0.5">

                                                        <div
                                                            class="text-sm font-bold text-slate-200 tracking-widest drop-shadow-sm space-x-3">
                                                            <span>{{ $vehiculo->color }}</span>
                                                            |
                                                            <span>
                                                                {{ $vehiculo->dispositivos
                                                                    ? $vehiculo->dispositivos->modelo->modelo
                                                                    : 'SIN
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                GPS' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- Mastercard logo -->
                                                    <svg class="absolute bottom-0 right-0" width="48"
                                                        height="28" viewBox="0 0 48 28">
                                                        <circle fill="#590BDD" cx="34" cy="14" r="14"
                                                            fill-opacity=".8" />
                                                        <circle fill="#F4DF33" cx="14" cy="14" r="14"
                                                            fill-opacity=".8" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="flex items-center mb-2 mx-4">
                                    <div class="text-sm">

                                        <ul class="list-disc">
                                            <li> <span class="font-medium text-slate-800 hover:underline">Marca:
                                                </span>{{ $vehiculo->marca }}</li>
                                            <li> <span class="font-medium text-slate-800 hover:underline">Tipo:
                                                </span>{{ $vehiculo->tipo }}</li>
                                            <li> <span class="font-medium text-slate-800 hover:underline">Año:
                                                </span>{{ $vehiculo->year }}</li>
                                            <li> <span class="font-medium text-slate-800 hover:underline">Color:
                                                </span>{{ $vehiculo->color }}</li>
                                            <li> <span class="font-medium text-slate-800 hover:underline">Motor:
                                                </span>{{ $vehiculo->motor }}</li>
                                            <li> <span class="font-medium text-slate-800 hover:underline">Serie:
                                                </span>{{ $vehiculo->serie }}</li>
                                        </ul>




                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <div class="flex items-center mb-2">
                                <div class="flex shrink-0 -space-x-3 -ml-px mr-2">
                                    <a class="block" href="javascript: void(0)">
                                        <img class="rounded-full border-2 border-white box-content"
                                            src="{{ asset('images/logo.png') }}" width="28" height="28"
                                            alt="User 12" />
                                    </a>
                                </div>
                                <div class="grow">
                                    <a class="inline-flex text-slate-800 hover:text-slate-900"
                                        href="javascript: void(0)">
                                        <h2 class="font-semibold text-slate-800">
                                            {{ $vehiculo->cliente ? $vehiculo->cliente->razon_social : 'REGISTRAR CLIENTE' }}
                                        </h2>
                                    </a>
                                    <div class="text-xs font-medium text-slate-500">
                                        {{ $vehiculo->cliente ? $vehiculo->cliente->created_at->format('h:m a, d-m-Y') : '' }}
                                    </div>
                                </div>
                            </div>
                            <!-- Content -->
                            @can('editar-cliente')
                                <div>
                                    <div class="text-sm">
                                        {{ $vehiculo->cliente ? $vehiculo->cliente->direccion : '' }}
                                    </div>
                                </div>
                            @endcan

                        </div>

                    </div>

                </div>
            </header>
        </div>

        <!-- Column 1 -->
        <div class="col-span-full sm:col-span-6 xl:col-span-4">

            <!-- Column header -->
            <header>
                <div class="flex items-center justify-between mb-2">
                    <h2 class="grow font-semibold text-slate-800 truncate">Datos Linea y Sim Card 🖋️</h2>
                    <button class="shrink-0 text-indigo-500 hover:text-indigo-600 ml-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                    </button>
                </div>

                <!-- Cards -->
                <div class="grid gap-2">

                    <!-- Card 1 -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <h2 class="font-semibold text-slate-800 mb-1">
                                @if ($vehiculo->sim_card)
                                    {{ $vehiculo->sim_card->linea ? $vehiculo->sim_card->linea->numero : 'Sim card sin numero' }}
                                @else
                                    SIN LINEA ACTIVA
                                @endif


                            </h2>
                            <!-- Content -->
                            <div>
                                <div class="text-sm">

                                    <span class="font-medium text-slate-800 hover:underline">Operador: </span>
                                    @if ($vehiculo->sim_card)
                                        {{ $vehiculo->sim_card->operador }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="flex items-center justify-between">
                            <!-- Left side -->
                            <div class="flex shrink-0 -space-x-3 -ml-px">


                                <svg class="rounded-full border-2 border-white box-content"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g fill="none" class="nc-icon-wrapper">
                                        <path
                                            d="M18 2h-8L4 8v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 2v16H6V8.83L10.83 4H18zM7 17h2v2H7v-2zm8 0h2v2h-2v-2zm-8-6h2v4H7v-4zm4 4h2v4h-2v-4zm0-4h2v2h-2v-2zm4 0h2v4h-2v-4z"
                                            fill="currentColor"></path>
                                    </g>
                                </svg>

                            </div>

                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <h2 class="font-semibold text-slate-800 mb-1">
                                @if ($vehiculo->sim_card)
                                    {{ $vehiculo->sim_card->sim_card }}
                                @else
                                    SIN SIN CARD ASIGNADO
                                @endif


                            </h2>
                            <!-- Content -->
                            <div>
                                <div class="text-sm">

                                    <span class="font-medium text-slate-800 hover:underline">Operador: </span>
                                    @if ($vehiculo->sim_card)
                                        {{ $vehiculo->sim_card->operador }}
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Card 3 -->
                    <div class="bg-rose-200 shadow-lg rounded-sm border border-rose-300 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <div class="flex items-center mb-2">
                                <div class="flex shrink-0 -space-x-3 -ml-px mr-2">
                                    <a class="block" href="javascript: void(0)">

                                        <svg class="rounded-full border-2 w-6 h-6 border-white box-content"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <g fill="none" class="nc-icon-wrapper">
                                                <path
                                                    d="M18 2h-8L4 8v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 2v16H6V8.83L10.83 4H18zM7 17h2v2H7v-2zm8 0h2v2h-2v-2zm-8-6h2v4H7v-4zm4 4h2v4h-2v-4zm0-4h2v2h-2v-2zm4 0h2v4h-2v-4z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>

                                    </a>
                                </div>
                                <div class="grow">
                                    <a class="inline-flex text-slate-800 hover:text-slate-900"
                                        href="javascript: void(0)">
                                        <h2 class="font-semibold text-slate-800">
                                            DATOS ANTERIOR SIM CARD Y GPS
                                        </h2>
                                    </a>

                                </div>
                            </div>
                            <!-- Content -->

                            <div class="flex items-center mb-2 mx-4 gap-2">
                                <div class="text-sm">

                                    <ul class="list-disc">
                                        <li> <span class="font-medium text-slate-800 hover:underline">ANTERIOR SIM
                                                CARD:
                                            </span>{{ $vehiculo->old_sim_card }}</li>
                                        <li> <span class="font-medium text-slate-800 hover:underline">ANTERIOR NÚMERO:
                                            </span>{{ $vehiculo->old_numero }}</li>
                                        <li> <span class="font-medium text-slate-800 hover:underline">IMEI GPS
                                                ANTERIOR:
                                            </span>{{ $vehiculo->old_imei }}</li>

                                    </ul>




                                </div>
                            </div>


                        </div>

                    </div>
                </div>



            </header>
        </div>

        <!-- Column 2 -->
        <div class="col-span-full sm:col-span-6 xl:col-span-4">

            <!-- Column header -->
            <header>
                <div class="flex items-center justify-between mb-2">
                    <h2 class="grow font-semibold text-slate-800 truncate">Detalles Adicionales ✌️</h2>
                    <button class="shrink-0 text-indigo-500 hover:text-indigo-600 ml-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                    </button>
                </div>

                <!-- Cards -->
                <div class="grid gap-2">

                    <!-- Card 1 -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <h2 class="font-semibold text-slate-800 mb-1">Dispositivo</h2>
                        </div>
                        <!-- Meta -->
                        <div class="flex items-center justify-between">
                            <!-- Left side -->
                            @if ($vehiculo->dispositivos)
                                <div class="flex shrink-0 -space-x-3 -ml-px">
                                    @if ($vehiculo->dispositivos->modelo->image)
                                        <a class="block" href="javascript: void(0)">
                                            <img class="rounded-full border-2 border-white box-content"
                                                src="{{ Storage::url($vehiculo->dispositivos->modelo->image->url) }}.webp"
                                                width="82" height="82" />
                                        @else
                                    @endif

                                    </a>
                                </div>
                            @endif
                        </div>
                        @if ($dispositivo['status'] == 'ok')
                            <div class="max-w-sm w-full mx-auto lg:max-w-none">
                                <h2 class="text-2xl text-slate-800 font-bold mb-6">{{ $dispositivo['imei'] }}
                                </h2>
                                <div class="space-y-6">

                                    <!-- Details -->
                                    <div>
                                        <div class="text-slate-800 font-semibold mb-2">Detalles Dispositivo
                                        </div>

                                        <ul>
                                            <li
                                                class="flex items-center justify-between py-3 border-b border-slate-200">
                                                <div class="text-sm">Imei:</div>
                                                <div class="text-sm font-medium text-slate-800 ml-2">
                                                    {{ $dispositivo['imei'] }}</div>
                                            </li>
                                            <li
                                                class="flex items-center justify-between py-3 border-b border-slate-200">
                                                <div class="text-sm">Modelo:</div>
                                                <div class="text-sm font-medium text-slate-800 ml-2">
                                                    {{ $dispositivo['model'] }}</div>
                                            </li>
                                            <li
                                                class="flex items-center justify-between py-3 border-b border-slate-200">
                                                <div class="flex items-center">
                                                    <span class="text-sm mr-2">Configuración actual:</span>

                                                </div>
                                                <div class="text-sm font-medium text-slate-800 ml-2">

                                                    <span
                                                        class="text-xs inline-flex whitespace-nowrap font-medium uppercase bg-slate-200 text-slate-500 rounded-full text-center px-2.5 py-1">
                                                        {{ $dispositivo['current_configuration'] }}
                                                    </span>
                                                </div>

                                            </li>
                                            <li
                                                class="flex items-center justify-between py-3 border-b border-slate-200">
                                                <div class="flex items-center">
                                                    <span class="text-sm mr-2">Firmware:</span>

                                                </div>
                                                <div class="text-sm font-medium text-slate-800 ml-2">

                                                    <span
                                                        class="text-xs inline-flex whitespace-nowrap font-medium uppercase bg-slate-200 text-slate-500 rounded-full text-center px-2.5 py-1">
                                                        {{ $dispositivo['current_firmware'] }}
                                                    </span>
                                                </div>

                                            </li>
                                            <li
                                                class="flex items-center justify-between py-3 border-b border-slate-200">
                                                <div class="text-sm">Descripción:</div>
                                                <div class="text-sm font-medium text-emerald-600 ml-2">
                                                    {{ $dispositivo['description'] }}</div>
                                            </li>
                                            <li
                                                class="flex items-center justify-between py-3 border-b border-slate-200">
                                                <div class="text-sm">Company:</div>
                                                <div class="text-sm font-medium text-emerald-600 ml-2">
                                                    {{ $dispositivo['company_name'] }}</div>
                                            </li>
                                            <li
                                                class="flex items-center justify-between py-3 border-b border-slate-200">
                                                <div class="text-sm">Grupo:</div>
                                                <div class="text-sm font-medium text-emerald-600 ml-2">
                                                    {{ $dispositivo['group_name'] }}</div>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Details -->
                                    <div>
                                        <div class="text-slate-800 font-semibold mb-4">Visto a las</div>
                                        <div class="text-sm rounded border border-slate-200 p-3">
                                            <div class="flex items-center justify-between space-x-2">

                                                <!-- Expiry -->
                                                <div class=" ml-2">{{ $dispositivo['seen_at'] }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <div class="mb-4">
                                            <a target="_blank"
                                                href="https://fm.teltonika.lt/devices?query={{ $dispositivo['imei'] }}"
                                                class="btn w-full bg-indigo-500 hover:bg-indigo-600 text-white">

                                                Ver en Fota Web
                                            </a>
                                        </div>
                                        <div class="text-xs text-slate-500 italic text-center">Estos datos son
                                            obtenidos de la Api de fota web.
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @else
                            <div class="max-w-sm w-full mx-auto lg:max-w-none">

                                @if ($vehiculo->dispositivos)
                                    <h2 class="text-2xl text-slate-800 font-bold mb-6">
                                        {{ $vehiculo->dispositivos->imei }} -
                                        {{ $vehiculo->dispositivos->modelo->modelo }}
                                    </h2>
                                @endif

                            </div>
                        @endif


                    </div>


                </div>
            </header>
        </div>
    </div>

</div>
