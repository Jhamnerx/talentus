<div class="grid grid-cols-12 gap-2 mt-4 pt-4 pb-4px-3 mb-2">
    {{-- left SIM CARD --}}


    <div
        class="col-span-12 sm:col-span-6 mb-2 shadow-lg border min-h-screen max-h-screen border-slate-200 mx-2 containerList">
        <x-laravel-blade-sortable::sortable name="sim_list" group="lista_sim" class="bg-white h-full overflow-y-scroll"
            animation="1000" ghost-class="opacity-25" drag-handle="drag-handle"
            wire:onSortOrderChange="handleOnSortOrderChangedSim">
            {{ count($sim_list) }}
            @foreach ($sim_list as $sim_card)
                <x-laravel-blade-sortable::sortable-item wire:key="{{ $sim_card }}" sort-key="{{ $sim_card }}"
                    class="bg-white shadow-lg mx-3 my-2 rounded-md border-2 border-slate-200 p-4 space-y-2">

                    <div class="sm:flex sm:justify-between sm:items-start">
                        <div class="grow mt-0.5 mb-3 sm:mb-0 space-y-3">
                            <div class="flex items-center">

                                <button type="button" class="cursor-move mr-2 drag-handle">
                                    <span class="sr-only">Drag</span>
                                    <svg class="w-3 h-3 fill-slate-500" viexBox="0 0 12 12"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 1h12v2H0V1Zm0 4h12v2H0V5Zm0 4h12v2H0V9Z" fill="#CBD5E1"
                                            fill-rule="evenodd" />
                                    </svg>
                                </button>

                                <label class="flex items-center">
                                    <span class="font-medium text-slate-800  ml-2">
                                        {{ $sim_card }}
                                    </span>
                                </label>
                            </div>
                        </div>

                    </div>
                </x-laravel-blade-sortable::sortable-item>
            @endforeach
        </x-laravel-blade-sortable::sortable>
    </div>

    {{-- items para asignar --}}
    <div
        class="col-span-12 sm:col-span-6 mb-2 shadow-lg shadow-talentus-200 border min-h-screen max-h-screen border-slate-200 mx-2 containerList">
        {{ count($sim_add) }}
        <x-laravel-blade-sortable::sortable group="lista_sim" name="sim_add" class="bg-white h-full overflow-y-scroll"
            animation="1000" ghost-class="opacity-25" drag-handle="drag-handle" style="min-height:20rem;"
            wire:onSortOrderChange="handleOnSortOrderChangedSim">
            @if ($errors->has('sim_add'))
                <p class="mt-2  text-pink-600 text-sm">
                    {{ $errors->first('sim_add') }}
                </p>
            @endif
            @if ($sim_add)
                @foreach ($sim_add as $sim_card)
                    <x-laravel-blade-sortable::sortable-item sort-key="{{ $sim_card }}"
                        class="bg-white shadow-lg mx-3 my-2 rounded-md border-2 border-slate-200 p-4 space-y-2">
                        <div class="sm:flex sm:justify-between sm:items-start">
                            <div class="grow mt-0.5 mb-3 sm:mb-0 space-y-3">
                                <div class="flex items-center">
                                    <button type="button" class="cursor-move mr-2 drag-handle">
                                        <span class="sr-only">Drag</span>
                                        <svg class="w-3 h-3 fill-slate-500" viexBox="0 0 12 12"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 1h12v2H0V1Zm0 4h12v2H0V5Zm0 4h12v2H0V9Z" fill="#CBD5E1"
                                                fill-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <label class="flex items-center">
                                        <span class="font-medium text-slate-800 ml-2">
                                            {{ $sim_card }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </x-laravel-blade-sortable::sortable-item>
                @endforeach
            @else
                <span class="font-medium text-slate-800 ml-2">
                    Arrastra un elemento de la lista <= </span>

            @endif

        </x-laravel-blade-sortable::sortable>
    </div>

</div>
