<div class="mb-12 space-y-4 py-10 xl:py-2">
    <form autocomplete="off">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Buscar
            Acta</label>
        <div class="relative">
            <div class="xl:flex hidden absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="search" id="default-search" wire:model.defer="codigo"
                class="p-4 inline-block pl-10 w-full md:w-1/4 md:my-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Ingresar Numero Acta..." required>

            <input wire:model.defer="unique_hash"
                class="p-4 inline-block pl-10 my-6 w-full md:w-1/3 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                type="search" placeholder="Ingresar Codigo unico">

            <button type="button" wire:click.prevent="SearchActa()"
                class="text-white w-full md:w-1/4 bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                Buscar
            </button>

        </div>
        <div class="flex w-full">
            <div class="flex w-2/4">
                @error('codigo')

                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{$message}}
                </p>

                @enderror
            </div>

            <div class="flex w-2/4">
                @error('unique_hash')

                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{$message}}
                </p>

                @enderror
            </div>

        </div>

    </form>


</div>