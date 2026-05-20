<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Campa&ntilde;as</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gestiona tus campa&ntilde;as de mensajes masivos</p>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <x-form.button href="{{ route('admin.whats-fleep.campaign.create') }}" primary icon="plus"
                label="Nueva Campa&ntilde;a" />
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-5">
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-center">
                <x-form.select wire:model.live="filterStatus" placeholder="Filtrar por estado">
                    <x-select.option value="" label="Todos los estados" />
                    <x-select.option value="waiting" label="En espera" />
                    <x-select.option value="processing" label="Procesando" />
                    <x-select.option value="done" label="Completado" />
                    <x-select.option value="failed" label="Fallido" />
                </x-form.select>
                <x-form.select wire:model.live="filterDevice" placeholder="Filtrar por dispositivo">
                    <x-select.option value="" label="Todos los dispositivos" />
                    @foreach ($devices as $device)
                        <x-select.option value="{{ $device->body }}" label="{{ $device->body }}" />
                    @endforeach
                </x-form.select>
                <div>
                    <x-form.button wire:click="$set('filterStatus', ''); $set('filterDevice', '')" flat
                        label="Limpiar filtros" />
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl relative">
        <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">
                Total Campa&ntilde;as
                <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $campaigns->total() }}</span>
            </h2>
        </header>
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-100 dark:border-gray-700/60">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Nombre</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Dispositivo</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Lista</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Tipo</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Estado</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Programado</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Acciones</div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($campaigns as $campaign)
                        <tr wire:key="campaign-{{ $campaign->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-900/20">
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">{{ $campaign->name }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-gray-500 dark:text-gray-400 text-xs font-mono">{{ $campaign->sender }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-gray-500 dark:text-gray-400">
                                    {{ $campaign->phonebook?->name ?? '&mdash;' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                    {{ $campaign->type }}
                                </span>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                @php
                                    $statusMap = [
                                        'waiting' => [
                                            'label' => 'En espera',
                                            'class' =>
                                                'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        ],
                                        'processing' => [
                                            'label' => 'Procesando',
                                            'class' =>
                                                'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        ],
                                        'done' => [
                                            'label' => 'Completado',
                                            'class' =>
                                                'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        ],
                                        'failed' => [
                                            'label' => 'Fallido',
                                            'class' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                        ],
                                        'paused' => [
                                            'label' => 'Pausado',
                                            'class' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                        ],
                                    ];
                                    $s = $statusMap[$campaign->status] ?? [
                                        'label' => ucfirst($campaign->status),
                                        'class' => 'bg-gray-100 text-gray-500',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s['class'] }}">
                                    {{ $s['label'] }}
                                </span>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $campaign->schedule ? \Carbon\Carbon::parse($campaign->schedule)->format('d/m/Y H:i') : 'Inmediato' }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($campaign->status === 'waiting')
                                        <button wire:click="deleteCampaign({{ $campaign->id }})"
                                            wire:confirm="&iquest;Eliminar esta campa&ntilde;a?"
                                            class="text-gray-400 hover:text-red-500 dark:hover:text-red-400">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600 text-xs">&mdash;</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium mb-1">No hay
                                        campa&ntilde;as</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mb-4">Comienza creando tu primera
                                        campa&ntilde;a de mensajes.</p>
                                    <x-form.button href="{{ route('admin.whats-fleep.campaign.create') }}" primary
                                        icon="plus" label="Nueva Campa&ntilde;a" />
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($campaigns->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/60">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>

</div>
