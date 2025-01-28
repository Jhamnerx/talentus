@if (count($linea->old_sim_cards) > 0)
    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
        <button class="btn border-slate-200 hover:border-slate-300 text-slate-600" aria-haspopup="true"
            :aria-expanded="open" @focus="open = true" @focusout="open = false" @click.prevent>
            <span class="mr-2">
                {{ $linea->old_sim_card }}
            </span>
            <svg class="w-4 h-4 fill-current text-slate-400" viewBox="0 0 16 16">
                <path
                    d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
            </svg>
        </button>
        <div class="z-10 absolute top-3/4 left-1/2 transform -translate-x-1/2 h-[calc(100vh-64px)]">
            <div class="min-w-72 p-3 z-10 rounded-2xl mb-2 bg-slate-100 shadow-2xl shadow-gray-800 overflow-auto max-h-full overflow-y-auto"
                x-show="open" x-transition:enter="transition ease-out duration-200 transform"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" x-cloak>
                <div class="">
                    <div class="font-medium text-slate-800 mb-0.5 pb-2  text-base text-center">
                        <b> {{ $linea->numero }}</b>
                    </div>
                    <div class="relative overflow-y-auto overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs  text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        SIM ANTERIOR
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        FECHA CAMBIO
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="a overflow-y-auto">

                                @foreach ($linea->old_sim_cards()->orderBy('created_at', 'desc')->get() as $old)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $old->old_sim_card }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $old->created_at->format('d-m-Y') }}
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
