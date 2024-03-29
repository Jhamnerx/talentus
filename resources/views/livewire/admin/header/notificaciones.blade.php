<div class="relative inline-flex" x-data="{ open: false }">
    <button wire:click='resetNotificacion()'
        class="w-8 h-8 flex items-center justify-center bg-slate-100 hover:bg-slate-200 transition duration-150 rounded-full"
        :class="{ 'bg-slate-200': open }" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
        <span class="sr-only">Notificaciones</span>
        <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path class="fill-current text-slate-500"
                d="M6.5 0C2.91 0 0 2.462 0 5.5c0 1.075.37 2.074 1 2.922V12l2.699-1.542A7.454 7.454 0 006.5 11c3.59 0 6.5-2.462 6.5-5.5S10.09 0 6.5 0z" />
            <path class="fill-current text-slate-400"
                d="M16 9.5c0-.987-.429-1.897-1.147-2.639C14.124 10.348 10.66 13 6.5 13c-.103 0-.202-.018-.305-.021C7.231 13.617 8.556 14 10 14c.449 0 .886-.04 1.307-.11L15 16v-4h-.012C15.627 11.285 16 10.425 16 9.5z" />
        </svg>

        <div class="absolute top-0 right-0 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full">

        </div>
    </button>
    <div class="origin-top-right z-10 sm:max-w-md absolute top-full max-h-80 overflow-y-auto min-w-80 w-96  right-0 -mr-48 sm:mr-0 max-w-lg bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
        x-transition:enter="transition ease-out duration-200 transform"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" x-cloak>
        <div class="text-xs font-semibold text-slate-400 uppercase pt-1.5 pb-2 px-4">Notificaciones {{ $count }}
        </div>
        <ul class="">
            @foreach ($notificaciones as $notificacion)

            @if ($notificacion->data['tipo'] == 'error_import')
            <li x-show="open" x-data="{ open: true }" class="border-b border-slate-200 last:border-0 mt-0 shadow-lg">
                <div
                    class="inline-flex flex-col max-w-lg px-2 py-2 rounded-sm text-sm bg-white {{$notificacion->read_at ? 'opacity-50' : '' }}  shadow-lg w-full hover:bg-slate-50">
                    <div class="flex w-full justify-between items-start mb-1 cursor-pointer">
                        <div class="flex">

                            <svg class="w-4 h-4 shrink-0 fill-current text-emerald-500 mt-[3px] mr-3"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zM7 11.4L3.6 8 5 6.6l2 2 4-4L12.4 6 7 11.4z" />
                            </svg>
                            <div>
                                <div class="font-medium text-slate-800 mb-1">{{ $notificacion->data['asunto'] }}
                                </div>
                                <div>
                                    {{ $notificacion->data['mensaje'] }}
                                </div>
                            </div>
                        </div>
                        <button wire:click.prevent="markRead('{{$notificacion->id}}')"
                            class="opacity-70 hover:opacity-80 ml-3 mt-[3px]" @click="open = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex w-full justify-between items-start">
                        <div class="text-xs font-medium text-slate-400">
                            {{ $notificacion->created_at->diffForHumans() }}
                        </div>
                        <div class="text-right mt-1">
                            <a href="{{route('notificaciones.importes')}}"
                                class="text-md font-medium text-indigo-500 hover:text-indigo-600" href="">
                                Ver
                                -&gt;</a>
                        </div>
                    </div>

                </div>
            </li>
            @else
            <li x-show="open" x-data="{ open: true }" class="border-b border-slate-200 last:border-0 mt-0 shadow-lg">
                <div
                    class="inline-flex flex-col max-w-lg px-2 py-2 rounded-sm text-sm bg-white {{$notificacion->read_at ? 'opacity-50' : '' }}  shadow-lg w-full hover:bg-slate-50">
                    <div class="flex w-full justify-between items-start mb-1 cursor-pointer">
                        <div class="flex">
                            {{-- <svg class="w-4 h-4 shrink-0 fill-current text-amber-500 mt-[3px] mr-3"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                            </svg> --}}
                            <svg class="w-4 h-4 shrink-0 fill-current text-emerald-500 mt-[3px] mr-3"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zM7 11.4L3.6 8 5 6.6l2 2 4-4L12.4 6 7 11.4z" />
                            </svg>
                            <div>
                                <div class="font-medium text-slate-800 mb-1">{{ $notificacion->data['asunto'] }}
                                </div>
                                <div>
                                    {{ $notificacion->data['mensaje'] }}
                                </div>
                            </div>
                        </div>
                        <button wire:click.prevent="markRead('{{$notificacion->id}}')"
                            class="opacity-70 hover:opacity-80 ml-3 mt-[3px]" @click="open = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex w-full justify-between items-start">
                        <div class="text-xs font-medium text-slate-400">
                            {{ $notificacion->created_at->diffForHumans() }}
                        </div>
                        <div class="text-right mt-1">
                            <a class="text-md font-medium text-indigo-500 hover:text-indigo-600"
                                href="{{ $notificacion->data['url'] }}">
                                Ver
                                -&gt;</a>
                        </div>
                    </div>

                </div>
            </li>
            @endif


            {{-- <li x-show="open" x-data="{ open: true }" class="border-b border-slate-200 last:border-0 ">
                <div class="inline-flex flex-col max-w-lg px-2 py-2 rounded-sm text-sm bg-white shadow-lg  ">
                    <div class="flex w-full justify-between items-start">
                        <div class="flex">
                            <svg class="w-4 h-4 shrink-0 fill-current text-amber-500 mt-[3px] mr-3" viewBox="0 0 16 16">
                                <path
                                    d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                            </svg>
                            <div>
                                <div class="font-medium text-slate-800 mb-1">Merged Pull Request</div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing sed do eiusmod tempor
                                    incididunt ut labore et dolore.</div>
                            </div>
                        </div>
                        <button class="opacity-70 hover:opacity-80 ml-3 mt-[3px]" @click="open = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                    <div class="text-right mt-1">
                        <a class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">Action -&gt;</a>
                    </div>
                </div>
            </li> --}}

            <!-- Start -->
            {{-- <div x-show="open" x-data="{ open: true }">
                <div
                    class="border-b last:border-0 inline-flex flex-col w-full px-1 py-2 rounded-sm text-sm bg-white shadow-lg border border-slate-200 text-slate-600">
                    <div
                        class="flex w-full justify-between items-start hover:bg-slate-50 rounded-sm text-sm bg-white shadow-lg border border-slate-200">

                        <a class="w-full py-2 " href="#0" @click="open = false" @focus="open = true"
                            @focusout="open = false">
                            <span class="block text-sm mb-2">📣
                                <span class="font-medium text-slate-800">
                                    Edit
                                    your information in a swipe
                                </span>
                                Sint occaecat cupidatat non proident,
                                sunt in culpa qui officia deserunt mollit anim.
                            </span>

                            <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>

                        </a>
                        <button class="opacity-70 hover:opacity-80 ml-3 mt-[3px]" @click="open = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>

                </div>
                <!-- End -->
            </div> --}}


            {{-- @if ($notificacion->type == 'App\Notifications\CrearRecordatorio')
            <li class="border-b border-slate-200 last:border-0" @click="open = false" @focus="open = true"
                @focusout="open = false">
                <div class="block py-2 px-4 hover:bg-slate-50">
                    <span class="block text-sm mb-2"><img
                            src="https://tuk-cdn.s3.amazonaws.com/can-uploader/notification_1-svg7.svg" alt="icon" />
                        <span class="font-medium text-slate-800">
                            Accion</span>
                        {{ $notificacion->data['mensaje'] }}.</span>
                    <span class="block text-xs font-medium text-slate-400">{{ $notificacion->created_at->diffForHumans()
                        }}</span>
                </div>



            </li>
            @else
            <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="{{ $notificacion->data['url'] }}"
                    @click="open = false" @focus="open = true" @focusout="open = false">
                    <span class="block text-sm mb-2">📣
                        <span class="font-medium text-slate-800">
                            Accion</span>
                        {{ $notificacion->data['mensaje'] }}.</span>
                    <span class="block text-xs font-medium text-slate-400">{{ $notificacion->created_at->diffForHumans()
                        }}</span>
                </a>
            </li>
            @endif --}}
            @endforeach

            {{-- <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false" @focus="open = true"
                    @focusout="open = false">
                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim.</span>
                    <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>
                </a>
            </li>
            <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false" @focus="open = true"
                    @focusout="open = false">
                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim.</span>
                    <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>
                </a>
            </li>
            <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false" @focus="open = true"
                    @focusout="open = false">
                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim.</span>
                    <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>
                </a>
            </li>
            <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false" @focus="open = true"
                    @focusout="open = false">
                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim.</span>
                    <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>
                </a>
            </li>
            <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false" @focus="open = true"
                    @focusout="open = false">
                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim.</span>
                    <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>
                </a>
            </li>
            <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false" @focus="open = true"
                    @focusout="open = false">
                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim.</span>
                    <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>
                </a>
            </li>
            <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false" @focus="open = true"
                    @focusout="open = false">
                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim.</span>
                    <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>
                </a>
            </li>
            <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false" @focus="open = true"
                    @focusout="open = false">
                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim.</span>
                    <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>
                </a>
            </li>
            <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false" @focus="open = true"
                    @focusout="open = false">
                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim.</span>
                    <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>
                </a>
            </li>
            <li class="border-b border-slate-200 last:border-0">
                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false" @focus="open = true"
                    @focusout="open = false">
                    <span class="block text-sm mb-2">🚀<span class="font-medium text-slate-800">Say
                            goodbye to paper receipts!</span> Sint occaecat cupidatat non proident, sunt
                        in culpa qui officia deserunt mollit anim.</span>
                    <span class="block text-xs font-medium text-slate-400">Jan 24, 2020</span>
                </a>
            </li> --}}
        </ul>
    </div>
</div>
