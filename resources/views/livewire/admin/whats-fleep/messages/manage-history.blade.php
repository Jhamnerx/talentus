<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Historial de Mensajes</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Registro de todos los mensajes enviados</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-5">
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
            <div class="flex flex-wrap gap-3 items-center">
                <div class="w-full sm:flex-1 sm:min-w-48">
                    <x-form.input wire:model.live.debounce="search" placeholder="Buscar por numero o nota..."
                        icon="magnifying-glass" />
                </div>
                <div class="w-full sm:w-44 shrink-0">
                    <x-form.select wire:model.live="filterDevice" placeholder="Dispositivo">
                        <x-select.option value="" label="Todos los dispositivos" />
                        @foreach ($devices as $device)
                            <x-select.option value="{{ $device->id }}" label="{{ $device->body }}" />
                        @endforeach
                    </x-form.select>
                </div>
                <div class="w-full sm:w-40 shrink-0">
                    <x-form.select wire:model.live="filterStatus" placeholder="Estado">
                        <x-select.option value="all" label="Todos los estados" />
                        <x-select.option value="success" label="Exitoso" />
                        <x-select.option value="failed" label="Fallido" />
                        <x-select.option value="pending" label="Pendiente" />
                    </x-form.select>
                </div>
                <div class="w-full sm:w-36 shrink-0">
                    <x-form.select wire:model.live="filterType" placeholder="Tipo">
                        <x-select.option value="" label="Todos los tipos" />
                        <x-select.option value="text" label="Texto" />
                        <x-select.option value="image" label="Imagen" />
                        <x-select.option value="video" label="Video" />
                        <x-select.option value="audio" label="Audio" />
                        <x-select.option value="document" label="Documento" />
                    </x-form.select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl relative">
        <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">
                Total Registros
                <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $histories->total() }}</span>
            </h2>
        </header>

        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-100 dark:border-gray-700/60">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Numero</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Dispositivo</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Mensaje</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Tipo</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Estado</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Envio</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha</div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($histories as $history)
                        <tr wire:key="history-{{ $history->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-900/20">
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100 font-mono text-xs">
                                    {{ $history->number }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $history->device?->body ?? '-' }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 max-w-xs">
                                <div class="text-gray-600 dark:text-gray-300 text-xs truncate max-w-48"
                                    title="{{ $history->message }}">
                                    {{ $history->message }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                    {{ $history->type }}
                                </span>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                @php
                                    $statusMap = [
                                        'success' => [
                                            'label' => 'Exitoso',
                                            'class' =>
                                                'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        ],
                                        'failed' => [
                                            'label' => 'Fallido',
                                            'class' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                        ],
                                        'pending' => [
                                            'label' => 'Pendiente',
                                            'class' =>
                                                'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        ],
                                        'sent' => [
                                            'label' => 'Enviado',
                                            'class' =>
                                                'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        ],
                                    ];
                                    $s = $statusMap[$history->status] ?? [
                                        'label' => ucfirst($history->status),
                                        'class' => 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s['class'] }}">
                                    {{ $s['label'] }}
                                </span>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $history->send_by === 'api' ? 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400' : 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' }}">
                                    {{ strtoupper($history->send_by) }}
                                </span>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $history->created_at?->format('d/m/Y H:i') ?? '-' }}
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
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium mb-1">Sin registros
                                    </p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm">Los mensajes enviados apareceran
                                        aqui.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($histories->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/60">
                {{ $histories->links() }}
            </div>
        @endif
    </div>

</div>
