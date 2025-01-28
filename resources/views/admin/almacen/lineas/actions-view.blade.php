<div class="relative inline-flex" x-data="{ open: false }">
    <div class="relative inline-block h-full text-left">
        <button class="text-slate-400 hover:text-slate-500 rounded-full" :class="{ 'bg-slate-100 text-slate-500': open }"
            aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
            <span class="sr-only">Menu</span>
            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                <circle cx="16" cy="16" r="2" />
                <circle cx="10" cy="16" r="2" />
                <circle cx="22" cy="16" r="2" />
            </svg>
        </button>
        <div class="origin-top-right  z-10 absolute transform  -translate-x-3/4  top-full left-0 min-w-36 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1  ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
            @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
            x-transition:enter="transition ease-out duration-200 transform"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak>
            <ul>
                @if ($linea->fecha_suspencion)
                    <li>
                        <a href="javascript: void(0)"
                            class="text-gray-300 cursor-not-allowed group flex items-center px-4 py-2 text-sm font-normal"
                            disabled="true" id="headlessui-menu-item-28" role="menuitem" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Suspender
                        </a>
                    </li>
                    @if (!$linea->baja)
                        <li>
                            <a href="javascript: void(0)" wire:click.prevent="activar({{ $linea->id }})"
                                class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                disabled="false" id="headlessui-menu-item-33" role="menuitem" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    class="h-5 w-5  mr-3 text-gray-400 group-hover:text-green-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                Activar
                            </a>
                        </li>
                    @endif
                @else
                    <li>
                        <a href="javascript: void(0)" wire:click.prevent="suspender({{ $linea->id }})"
                            class="text-gray-700 disabled group flex items-center px-4 py-2 text-sm font-normal"
                            disabled="true" id="headlessui-menu-item-28" role="menuitem" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Suspender
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0)" wire:click.prevent="activar({{ $linea->id }})"
                            class="text-gray-300 cursor-not-allowed group flex items-center px-4 py-2 text-sm font-normal"
                            disabled="false" id="headlessui-menu-item-33" role="menuitem" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="h-5 w-5  mr-3 text-gray-400 group-hover:text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Activar
                        </a>
                    </li>
                @endif
                @if ($linea->sim_card)
                    <li>
                        <a href="javascript: void(0)" wire:click.prevent="asignToPlaca({{ $linea->id }})"
                            class="text-gray-700  group flex items-center px-4 py-2 text-sm font-normal"
                            id="headlessui-menu-item-33" role="menuitem" tabindex="-1">
                            <svg class="h-5 w-5  mr-3 text-gray-400 group-hover:text-green-500"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                <g stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"
                                    stroke-linejoin="round" class="nc-icon-wrapper">
                                    <line data-cap="butt" x1="32" y1="29" x2="41"
                                        y2="19"></line>
                                    <path data-cap="butt"
                                        d="M57,29,52.829,8.98A5,5,0,0,0,47.934,5H16.066a5,5,0,0,0-4.895,3.98L7,29">
                                    </path>
                                    <polyline points="16 54 16 58 6 58 6 54">
                                    </polyline>
                                    <path
                                        d="M62,49H2V36.066a4.99,4.99,0,0,1,1.465-3.532L7,29H57l3.535,3.535A5,5,0,0,1,62,36.071Z">
                                    </path>
                                    <circle cx="11" cy="40" r="3">
                                    </circle>
                                    <polyline points="58 54 58 58 48 58 48 54">
                                    </polyline>
                                    <circle cx="53" cy="40" r="3">
                                    </circle>
                                    <line x1="25" y1="40" x2="39" y2="40"></line>
                                </g>
                            </svg>
                            Asignar a placa
                        </a>
                    </li>
                @endif
                <li>
                    <a href="javascript: void(0)" wire:click.prevent="openModalEdit({{ $linea->id }})"
                        class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal" disabled="false"
                        id="headlessui-menu-item-27" role="menuitem" tabindex="-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                            </path>
                        </svg> Editar
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>
