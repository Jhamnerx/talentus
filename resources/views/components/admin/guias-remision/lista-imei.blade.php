<div class="grid grid-cols-12 gap-2 mt-4 pt-4 pb-4px-3 mb-2">
    {{-- left imeis --}}
    <div
        class="col-span-12 sm:col-span-6 mb-2 shadow-lg border min-h-screen max-h-screen border-slate-200 mx-2 containerList">
        <x-laravel-blade-sortable::sortable name="imei_list" wire:onSortOrderChange="handleOnSortOrderChanged"
            group="lista_imei" class="bg-white h-full overflow-y-scroll" animation="1000" ghost-class="opacity-25"
            drag-handle="drag-handle">
            @foreach ($imei_list as $imei)
                <x-laravel-blade-sortable::sortable-item wire:key="{{ $imei }}" sort-key="{{ $imei }}"
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
                                        {{ $imei }}
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
        <x-laravel-blade-sortable::sortable group="lista_imei" name="imeis_add"
            wire:onSortOrderChange="handleOnSortOrderChanged" class="bg-white h-full overflow-y-scroll" animation="1000"
            ghost-class="opacity-25" drag-handle="drag-handle" style="min-height:20rem;">
            @if ($errors->has('imeis_add'))
                <p class="mt-2  text-pink-600 text-sm">
                    {{ $errors->first('imeis_add') }}
                </p>
            @endif
            @if ($imeis_add)
                @foreach ($imeis_add as $imei)
                    <x-laravel-blade-sortable::sortable-item sort-key="{{ $imei }}"
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
                                            {{ $imei }}
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
