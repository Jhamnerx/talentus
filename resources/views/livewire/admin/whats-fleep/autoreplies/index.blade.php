<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Auto-Respuestas</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                @if (session()->has('selectedDevice'))
                    Respuestas para
                    <span class="font-semibold text-gray-700 dark:text-gray-200">
                        {{ session('selectedDevice.device_body') }}
                    </span>
                @else
                    Responde automáticamente según la palabra clave recibida.
                @endif
            </p>
        </div>
        <div class="flex flex-wrap justify-start sm:justify-end gap-2 mt-3 sm:mt-0">
            <div class="w-full sm:w-52">
                <x-form.input wire:model.live.debounce="search" placeholder="Buscar keyword..." icon="magnifying-glass" />
            </div>
            @if ($devices->count() > 1)
                <div class="w-full sm:w-48">
                    <x-form.select wire:model.live="filterDevice" placeholder="Todos los dispositivos">
                        @foreach ($devices as $device)
                            <x-select.option value="{{ $device->body }}" label="{{ $device->body }}" />
                        @endforeach
                    </x-form.select>
                </div>
            @endif
            <x-form.button wire:click="openCreateModal" primary icon="plus" label="Nueva regla" />
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl">
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-gray-100 dark:divide-gray-700/60">
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20">
                    <tr>
                        <th class="px-4 py-3 text-left whitespace-nowrap w-40">Keyword</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Detalles</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Estado</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Citar</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Tipo</th>
                        <th class="px-4 py-3 text-right whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($autoreplies as $ar)
                        @php
                            $reply = is_array($ar->reply) ? $ar->reply : json_decode($ar->reply, true) ?? [];
                        @endphp
                        <tr wire:key="ar-{{ $ar->id }}"
                            class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition">

                            {{-- Keyword + Dispositivo --}}
                            <td class="px-4 py-3">
                                <span
                                    class="font-semibold text-gray-800 dark:text-gray-100 block">{{ $ar->keyword }}</span>
                                <span
                                    class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 block">{{ $ar->device }}</span>
                            </td>

                            {{-- Detalles --}}
                            <td class="px-4 py-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 flex-wrap">
                                    Responderá si la keyword es
                                    <span @class([
                                        'inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold',
                                        'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' =>
                                            $ar->type_keyword === 'Equal',
                                        'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' =>
                                            $ar->type_keyword === 'Contain',
                                    ])>
                                        {{ $ar->type_keyword === 'Equal' ? 'Exacta' : 'Contenida' }}
                                    </span>
                                </p>
                                <p
                                    class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 flex-wrap mt-0.5">
                                    &amp; cuando el remitente sea
                                    <span @class([
                                        'inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold',
                                        'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' =>
                                            $ar->reply_when === 'All',
                                        'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' =>
                                            $ar->reply_when === 'Group',
                                        'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' =>
                                            $ar->reply_when === 'Personal',
                                    ])>
                                        {{ match ($ar->reply_when) {'Group' => 'Grupo','Personal' => 'Personal',default => 'Todos'} }}
                                    </span>
                                </p>
                                @if ($ar->type === 'text')
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 italic truncate max-w-xs">
                                        &quot;{{ Str::limit($reply['text'] ?? '', 60) }}&quot;
                                    </p>
                                @else
                                    @php
                                        $imgData = $reply['image'] ?? [];
                                        $imgUrl = is_array($imgData) ? $imgData['url'] ?? '' : (string) $imgData;
                                        $caption = $reply['caption'] ?? '';
                                    @endphp
                                    <div class="flex items-center gap-2 mt-1">
                                        @if ($imgUrl)
                                            <img src="{{ $imgUrl }}" alt="preview"
                                                class="w-10 h-10 rounded object-cover border border-gray-200 dark:border-gray-600"
                                                onerror="this.style.display='none'">
                                        @endif
                                        @if ($caption)
                                            <span
                                                class="text-xs text-gray-400 dark:text-gray-500 italic truncate max-w-xs">
                                                &quot;{{ Str::limit($caption, 40) }}&quot;
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>

                            {{-- Status toggle --}}
                            <td class="px-4 py-3 text-center">
                                <button wire:click="toggleStatus({{ $ar->id }})" title="Cambiar estado"
                                    class="relative inline-flex items-center h-5 w-9 rounded-full transition-colors focus:outline-none
                                        {{ $ar->status ? 'bg-violet-500' : 'bg-gray-300 dark:bg-gray-600' }}">
                                    <span
                                        class="inline-block w-3.5 h-3.5 bg-white rounded-full shadow transition-transform
                                        {{ $ar->status ? 'translate-x-4' : 'translate-x-1' }}"></span>
                                </button>
                                <span
                                    class="block text-xs mt-0.5 {{ $ar->status ? 'text-violet-500' : 'text-gray-400' }}">
                                    {{ $ar->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>

                            {{-- Quoted toggle --}}
                            <td class="px-4 py-3 text-center">
                                <button wire:click="toggleQuoted({{ $ar->id }})" title="Cambiar citar"
                                    class="relative inline-flex items-center h-5 w-9 rounded-full transition-colors focus:outline-none
                                        {{ $ar->is_quoted ? 'bg-teal-500' : 'bg-gray-300 dark:bg-gray-600' }}">
                                    <span
                                        class="inline-block w-3.5 h-3.5 bg-white rounded-full shadow transition-transform
                                        {{ $ar->is_quoted ? 'translate-x-4' : 'translate-x-1' }}"></span>
                                </button>
                                <span
                                    class="block text-xs mt-0.5 {{ $ar->is_quoted ? 'text-teal-500' : 'text-gray-400' }}">
                                    {{ $ar->is_quoted ? 'Sí' : 'No' }}
                                </span>
                            </td>

                            {{-- Type badge --}}
                            <td class="px-4 py-3 text-center">
                                <span @class([
                                    'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium',
                                    'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' =>
                                        $ar->type === 'text',
                                    'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400' =>
                                        $ar->type === 'image',
                                ])>
                                    {{ $ar->type === 'text' ? 'Texto' : 'Imagen' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button wire:click="openEditModal({{ $ar->id }})"
                                        class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-300 transition"
                                        title="Editar">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $ar->id }})"
                                        class="text-red-500 hover:text-red-700 dark:hover:text-red-300 transition"
                                        title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3z" />
                                    </svg>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm">No hay auto-respuestas
                                        configuradas.</p>
                                    <x-form.button wire:click="openCreateModal" primary sm icon="plus"
                                        label="Crear la primera" />
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($autoreplies->hasPages())
            <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700/60">
                {{ $autoreplies->links() }}
            </div>
        @endif
    </div>

    @livewire('admin.whats-fleep.autoreplies.create')
    @livewire('admin.whats-fleep.autoreplies.edit')
    @livewire('admin.whats-fleep.autoreplies.delete')
</div>
