@props(['titulo', 'id', 'maxWidth'])

@php
    $id = $id ?? md5($attributes->wire('model'));

    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
    ][$maxWidth ?? '2xl'];
@endphp
<div>
    <div x-data="{ showModal: @entangle($attributes->wire('model')).live }" id="{{ $id }}">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="showModal"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="showModal" x-transition:enter="transition ease-in-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 {{ $maxWidth }} 2xl:w-6/12 max-h-full"
                @keydown.escape.window="showModal = false">
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">{{ $titulo }}</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="showModal = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <form autocomplete="off">
                    <div class="px-8 py-5 bg-white sm:p-6">

                        <div class="grid grid-cols-12 gap-6 items-center overflow-x-auto">

                            {{ $slot }}

                        </div>

                    </div>
                </form>

                <div class="px-5 py-4 border-t border-slate-200 text-center">
                    <div class="flex flex-wrap justify-center space-x-2 gap-2">
                        <button wire:loading.attr="disabled" wire:click.prevent="addProducto()"
                            class="btn border-slate-200 hover:border-slate-300 text-slate-600">
                            <svg class="w-5 h-5 fill-current text-green-500 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <g fill="none" class="nc-icon-wrapper">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"
                                        fill="currentColor"></path>
                                </g>
                            </svg>
                            <span class="ml-2">Aceptar</span>
                        </button>


                        <button wire:click.prevent="closeModal"
                            class="btn border-slate-200 hover:border-slate-300 text-rose-500">

                            <svg class="w-4 h-4 fill-current shrink-0" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <g fill="none" class="nc-icon-wrapper">
                                    <path
                                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"
                                        fill="currentColor"></path>
                                </g>
                            </svg>
                            <span class="ml-2">Cancelar</span>
                        </button>
                    </div>
                </div>



            </div>

        </div>
    </div>

</div>
