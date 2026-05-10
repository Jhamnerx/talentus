<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Historial de Mensajes</h1>
        </div>
    </div>

    <!-- Filters -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <x-form.input wire:model.live.debounce="search" placeholder="Buscar..." icon="magnifying-glass" class="w-56" />
            <x-native-select wire:model.live="filterDevice" class="btn">
                <option value="">Todos los dispositivos</option>
                @foreach ($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->body }}</option>
                @endforeach
            </x-native-select>
            <x-native-select wire:model.live="filterStatus" class="btn">
                <option value="all">Todos los estados</option>
                <option value="sent">Enviado</option>
                <option value="failed">Fallido</option>
                <option value="pending">Pendiente</option>
            </x-native-select>
            <x-native-select wire:model.live="filterType" class="btn">
                <option value="">Todos los tipos</option>
                <option value="text">Texto</option>
                <option value="image">Imagen</option>
                <option value="video">Video</option>
                <option value="audio">Audio</option>
                <option value="document">Documento</option>
            </x-native-select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-slate-200 dark:border-gray-700">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800 dark:text-gray-100">Total Registros
                <span class="text-slate-400 dark:text-gray-400 font-medium">{{ $histories->total() }}</span>
            </h2>
        </header>
        <div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="text-xs font-semibold uppercase text-slate-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-900/20 border-t border-b border-slate-200 dark:border-gray-700">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">DISPOSITIVO</div></th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">TIPO</div></th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-center">ESTADO</div></th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">NOTA</div></th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">FECHA</div></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-gray-700">
                        @forelse($histories as $history)
                            <tr wire:key="history-{{ $history->id }}">
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-slate-500 dark:text-gray-400">{{ $history->device?->body ?? 'â€”' }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                        {{ $history->type }}
                                    </span>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                    @php
                                        $colors = [
                                            'sent'    => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'failed'  => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                            'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$history->status] ?? 'bg-slate-100 text-slate-500' }}">
                                        {{ ucfirst($history->status) }}
                                    </span>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 max-w-xs">
                                    <div class="text-slate-500 dark:text-gray-400 text-xs truncate">{{ $history->note }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-slate-500 dark:text-gray-400 text-xs">{{ $history->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-2 first:pl-5 last:pr-5 py-10 text-center">
                                    <div class="text-slate-500 dark:text-gray-400">No hay registros en el historial</div>
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
        {{ $histories->links() }}
    </div>
</div>