<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Notificaciones Fallidas importes ✨</h1>
        </div>

    </div>
    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <div class="relative inline-flex">

                <button wire:click="deleteAll" {{$notificaciones->total() < 0 ? 'disabled' : '' }}
                        wire:loading.class="bg-rose-300" wire:wire:loading.attr="disabled"
                        class="btn bg-rose-600 hover:bg-rose-700 text-white btn border-slate-200 hover:border-slate-300">

                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                            <g stroke-linecap="square" stroke-width="2" fill="none" stroke="currentColor"
                                stroke-linejoin="miter" class="nc-icon-wrapper" stroke-miterlimit="10">
                                <path d="M22,13V3H42V13"></path>
                                <line x1="59" y1="13" x2="5" y2="13"></line>
                                <path d="M53,19,50.332,56.356A5,5,0,0,1,45.345,61H18.655a5,5,0,0,1-4.987-4.644L11,19">
                                </path>
                            </g>
                        </svg>
                        <span class="hidden xs:block ml-2">Eliminar todas</span>
                </button>

            </div>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Notificaciones <span class="text-slate-400 font-medium">{{
                    $notificaciones->total() }}</span>
            </h2>
        </header>



        <div>

            @if ($notificaciones->total() > 0)
            @foreach ($notificaciones as $notificacion)
            <div class="space-y-3">

                <!-- Start -->
                <div x-show="open" x-data="{ open: true }">
                    <div
                        class="inline-flex flex-col w-max my-2 mt-2 px-4 py-4 mx-3 mr-3 rounded-sm text-sm bg-white shadow-lg border border-slate-200 text-slate-600">
                        <div class="flex w-full justify-between items-start">
                            <div class="flex">
                                <svg class="w-4 h-4 shrink-0 fill-current text-red-500 mt-[3px] mr-3"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                                </svg>
                                <div>
                                    <div class="font-medium text-slate-800 mb-1">{{$notificacion->data['asunto']}}</div>
                                    <div>
                                        {{$notificacion->data['mensaje']}}
                                    </div>
                                </div>
                            </div>
                            <button wire:click="delete('{{$notificacion->id}}')"
                                class="opacity-70 hover:opacity-80 ml-3 mt-[3px]" @click="open = false">
                                <div class="sr-only">Close</div>
                                <svg class="w-4 h-4 fill-current">
                                    <path
                                        d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- End -->
                </div>

            </div>
            @endforeach
            @else
            <div class="space-y-3">

                <div>No hay notificaciones de importes</div>
            </div>


            @endif



        </div>

    </div>
    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $notificaciones->links() }}

    </div>
</div>
