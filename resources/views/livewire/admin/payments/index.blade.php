<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto" x-data="{ transactionOpen: @entangle('PaymentOpen').live }"
    @set-transactionopen="transactionOpen = $event.detail">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-4 md:mb-2">

        <!-- Left: Title -->
        {{-- <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">$47,347.09</h1>
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">{{ $total }}</h1>
        </div> --}}

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Eliminar button -->
            <div class="table-items-action hidden">
                <div class="flex items-center">
                    <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span
                            class="table-items-count"></span> items selected</div>
                    <button
                        class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Delete</button>
                </div>
            </div>

            <!-- buscador -->
            <form class="relative">
                <label for="action-search" class="sr-only">Search</label>
                <input id="action-search" wire:model.live="search" class="form-input pl-9 focus:border-slate-300"
                    type="search" placeholder="Buscar..." />
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

            <!-- crear button -->
            {{-- <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">Crear Pago</button> --}}

        </div>

    </div>

    <!-- filtro -->
    <div class="mb-5">
        <ul class="flex flex-wrap -m-1">
            <li class="m-1">
                <button
                    class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-transparent shadow-sm bg-indigo-500 text-white duration-150 ease-in-out">
                    Ver todos
                </button>
            </li>
            {{-- <li class="m-1">
                <button
                    class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">Completed</button>
            </li>
            <li class="m-1">
                <button
                    class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">Pending</button>
            </li>
            <li class="m-1">
                <button
                    class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">Canceled</button>
            </li> --}}
        </ul>
    </div>

    <!-- Tabla -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Pagos <span
                    class="text-slate-400 font-medium">{{ $payments->total() }}</span>
            </h2>
        </header>
        <x-admin.payments.payments-table :payments="$payments"> </x-admin.payments.payments-table>
    </div>




    <!-- Pagination -->
    <div class="mt-8">
        {{ $payments->links() }}
    </div>

    <!-- payment Panel -->

    @livewire('admin.payments.payments-panel')


</div>
