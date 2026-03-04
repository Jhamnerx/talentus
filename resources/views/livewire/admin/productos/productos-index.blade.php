<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                {{ $tipo ? ($tipo === 'producto' ? 'Productos' : 'Servicios') : 'Productos' }} ✨
            </h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <x-search-form
                placeholder="{{ $tipo ? ($tipo === 'producto' ? 'Buscar productos' : 'Buscar servicios') : 'Buscar productos' }}" />
            <!-- Add customer button -->
            @can('crear-producto')
                <button wire:click.prevent="openModalCreate"
                    class="btn cursor-pointer bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">
                        {{ $tipo ? ($tipo === 'producto' ? 'Añadir Producto' : 'Añadir Servicio') : 'Añadir Producto' }}
                    </span>
                </button>
            @endcan

        </div>

    </div>

    <!-- Filters -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Filter by categoria -->
            <x-form.select wire:model.live="categoriaFilter" placeholder="Todas las categorías">
                <x-select.option value="" label="Todas las categorías" />
                @foreach ($categorias as $categoria)
                    <x-select.option value="{{ $categoria->id }}" label="{{ $categoria->nombre }}" />
                @endforeach
            </x-form.select>

            <!-- Filter by tipo -->
            @if (!$tipo)
                <x-form.select wire:model.live="tipoFilter" placeholder="Todos los tipos">
                    <x-select.option value="" label="Todos los tipos" />
                    <x-select.option value="producto" label="Producto" />
                    <x-select.option value="servicio" label="Servicio" />
                </x-form.select>
            @endif

            <!-- Filter by status -->
            <x-form.select wire:model.live="estadoFilter" placeholder="Todos los estados">
                <x-select.option value="" label="Todos los estados" />
                <x-select.option value="1" label="Activo" />
                <x-select.option value="0" label="Desactivado" />
            </x-form.select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-slate-200 dark:border-gray-700">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800 dark:text-gray-100">
                Total {{ $tipo ? ($tipo === 'producto' ? 'Productos' : 'Servicios') : 'Productos' }}
                <span class="text-slate-400 dark:text-gray-400 font-medium">{{ $productos->total() }}</span>
            </h2>
        </header>
        <div>
            <!-- Table -->
            <div class="overflow-x-auto min-h-screen">
                <table class="table-auto w-full">
                    <!-- Table header -->
                    <thead
                        class="text-xs font-semibold uppercase text-slate-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-900/20 border-t border-b border-slate-200 dark:border-gray-700">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">CÓDIGO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">IMAGEN</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">DESCRIPCIÓN</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">CATEGORÍA</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">VALOR UNITARIO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">STOCK</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">COBROS</div>
                            </th>
                            @can('cambiar.estado-producto')
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">ESTADO</div>
                                </th>
                            @endcan
                            @if (auth()->user()->can('editar-producto') || auth()->user()->can('eliminar-producto'))
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">ACCIONES</div>
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-gray-700">
                        @forelse($productos as $producto)
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left font-medium text-slate-800 dark:text-gray-100">
                                        {{ $producto->codigo }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="w-12 h-12">
                                        <img class="h-full w-full shrink-0 grow-0 rounded-full"
                                            src="{{ $producto->image ? Storage::url($producto->image->url) : Storage::url('productos/default.jpg') }}"
                                            alt="{{ $producto->descripcion }}">
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3">
                                    <div class="text-left text-slate-800 dark:text-gray-100">
                                        {{ $producto->descripcion }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 dark:text-gray-100">
                                        {{ $producto->categoria->nombre }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 dark:text-gray-100">
                                        {{ $producto->divisa == 'USD' ? '$ ' . $producto->valor_unitario : 'S/ ' . $producto->valor_unitario }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 dark:text-gray-100">
                                        {{ $producto->tipo == 'producto' ? $producto->stock . ' ' . $producto->unit->name : 'servicio' }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @if ($producto->es_servicio_cobro)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 ring-1 ring-inset ring-emerald-500/30">
                                            💳 Facturación
                                        </span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600 text-xs">&mdash;</span>
                                    @endif
                                </td>
                                @can('cambiar.estado-producto')
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="form-switch">
                                            <input type="checkbox" id="toggle-{{ $producto->id }}" class="sr-only"
                                                wire:click="toggleStatus({{ $producto->id }})"
                                                {{ $producto->estado ? 'checked' : '' }} />
                                            <label class="bg-slate-400 dark:bg-slate-600" for="toggle-{{ $producto->id }}">
                                                <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                                <span
                                                    class="sr-only">{{ $producto->estado ? 'Activo' : 'Desactivado' }}</span>
                                            </label>
                                        </div>
                                    </td>
                                @endcan
                                @if (auth()->user()->can('editar-producto') || auth()->user()->can('eliminar-producto'))
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            @can('editar-producto')
                                                <button wire:click="openModalEdit({{ $producto->id }})"
                                                    class="text-slate-400 hover:text-slate-500 dark:text-gray-400 dark:hover:text-gray-300 cursor-pointer">
                                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                        <path
                                                            d="M19.7 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 22H10v-2.6l6-6 2.6 2.6-6 6zm7.4-7.4L17.4 12l1.6-1.6 2.6 2.6-1.6 1.6z" />
                                                    </svg>
                                                </button>
                                            @endcan
                                            @can('eliminar-producto')
                                                <button wire:click="openModalDelete({{ $producto->id }})"
                                                    class="text-rose-500 hover:text-rose-600 cursor-pointer">
                                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                        <path
                                                            d="M13 15h2v6h-2zM17 15h2v6h-2zM20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                                    </svg>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-2 first:pl-5 last:pr-5 py-3 text-center">
                                    <div class="text-slate-500 dark:text-gray-400">No se encontraron productos</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $productos->links() }}
    </div>

</div>

@push('scripts')
@endpush
