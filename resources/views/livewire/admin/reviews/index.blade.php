<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto" :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ page: 'administracion-reviewes', sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Revisiones Clientes ✨</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <div class="table-items-action hidden">
                    <div class="flex items-center">
                        <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span
                                class="table-items-count"></span>
                            items Seleccionados</div>
                        <button
                            class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Eliminar</button>
                    </div>
                </div>

                <!-- Search form -->
                <form class="relative" autocomplete="off">
                    <label for="action-search" class="sr-only">Buscar</label>
                    <input wire:model="search" class="form-input pl-9 focus:border-slate-300" type="search"
                        placeholder="Buscar Solicitud" />

                    <button class="absolute inset-0 right-auto group" type="button" aria-label="Search">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                            viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path
                                d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                </form>



                <!-- Filter button -->
                <div class="relative inline-flex">
                    <button
                        class="btn bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600">
                        <span class="sr-only">Filtro</span><wbr>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                            <path
                                d="M9 15H7a1 1 0 010-2h2a1 1 0 010 2zM11 11H5a1 1 0 010-2h6a1 1 0 010 2zM13 7H3a1 1 0 010-2h10a1 1 0 010 2zM15 3H1a1 1 0 010-2h14a1 1 0 010 2z" />
                        </svg>
                    </button>
                </div>

            </div>

        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4">
                <h2 class="font-semibold text-slate-800">Total Solicitudes <span
                        class="text-slate-400 font-medium">{{ $reviews->total() }}</span>
                </h2>

            </header>
            <div x-data="handleSelect">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <!-- Table header -->
                        <thead
                            class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                            <tr>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-center">
                                        <label class="inline-flex">
                                            <span class="sr-only">Seleccionar Todo</span>
                                            <input id="parent-checkbox" class="form-checkbox" type="checkbox"
                                                @click="toggleAll" />
                                        </label>
                                    </div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">#</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Empresa</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nombre/Razon Social</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Cargo</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Telefono</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Fecha de Nacimiento</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Respuestas</div>
                                </th>

                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm divide-y divide-slate-200">
                            <!-- Row -->
                            @if ($reviews->count())
                                @foreach ($reviews as $review)
                                    <tr>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            <div class="flex items-center">
                                                <label class="inline-flex">
                                                    <span class="sr-only">Select</span>
                                                    <input class="table-item form-checkbox" type="checkbox"
                                                        @click="uncheckParent" />
                                                </label>
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left uppercase">{{ $review->id }}</div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left uppercase">{{ $review->empresa }}</div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3">
                                            <div class="text-left uppercase">{{ $review->nombre }}</div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left uppercase">
                                                {{ $review->cargo }}
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left uppercase">
                                                {{ $review->telefono }}
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3">
                                            <div class="text-left uppercase">{{ $review->birthday }}</div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left uppercase">
                                                <p class="d font-semibold">1.- ¿Qué tan satisfecho se siente con la
                                                    atención
                                                    brindada a sus
                                                    consultas y requerimientos?</p>
                                                <p class="a pl-4">{{ $review->question['q1'] }}</p>
                                            </div>

                                            <div class="text-left uppercase">
                                                <p class="d font-semibold">2.- ¿En qué aspecto cree Ud., que debería
                                                    mejorar nuestro servicio?</p>
                                                <p class="a pl-4"> {{ $review->question['q2'] }}</p>
                                            </div>
                                            <div class="text-left uppercase">
                                                <p class="d font-semibold">3.- ¿Tiene algún inconveniente en el manejo
                                                    de nuestras plataformas de monitoreo?</p>
                                                <p class="a pl-4">{{ $review->question['q3'] }},
                                                    {{ $review->question['q3_res'] }}</p>

                                            </div>
                                            <div class="text-left uppercase">
                                                <p class="d font-semibold">4.- ¿Tiene alguna solicitud pendiente que no
                                                    se haya atendido?</p>
                                                <p class="a pl-4">{{ $review->question['q4'] }}.</p>


                                            </div>
                                            <div class="text-left uppercase">
                                                <p class="d font-semibold">5.- ¿Recomendaría nuestro servicio a un
                                                    familiar o amigo?</p>
                                                <p class="a pl-4"> {{ $review->question['q5'] }}.
                                                    {{ $review->question['q5_why'] }}.</p>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <td colspan="11"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                    <div class="text-center">No hay Registros</div>
                                </td>
                            @endif


                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8 w-full">
            {{ $reviews->links() }}


        </div>
    </div>


</div>