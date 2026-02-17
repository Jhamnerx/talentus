<x-form.modal.card title="📜 HISTORIAL DE CAMBIOS" width="5xl" wire:model.live="modalOpen">

    @if ($sim_card)
        <!-- Info del SIM Card -->
        <div
            class="mb-6 p-4 bg-linear-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-lg border border-indigo-200 dark:border-indigo-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="shrink-0 bg-white dark:bg-gray-800 p-2 rounded-lg">
                        <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold">SIM Card</p>
                        <p class="text-lg font-bold text-indigo-900 dark:text-indigo-100">{{ $sim_card->sim_card }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $sim_card->operador }}</p>
                    </div>
                </div>
                @if ($sim_card->linea)
                    <div class="text-right">
                        <p class="text-xs text-gray-600 dark:text-gray-400">Número actual:</p>
                        <p class="text-lg font-bold text-green-600 dark:text-green-400">{{ $sim_card->linea->numero }}
                        </p>
                    </div>
                @else
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">Sin número asignado</p>
                    </div>
                @endif
            </div>
        </div>

        @if ($cambios && $cambios->count() > 0)
            <!-- Timeline de cambios -->
            <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                @foreach ($cambios as $index => $cambio)
                    @php
                        $data = $this->getCambioData($cambio);
                        $colorClasses = [
                            'red' => 'bg-red-100 dark:bg-red-900/30 border-red-300 dark:border-red-700',
                            'green' => 'bg-green-100 dark:bg-green-900/30 border-green-300 dark:border-green-700',
                            'blue' => 'bg-blue-100 dark:bg-blue-900/30 border-blue-300 dark:border-blue-700',
                            'indigo' => 'bg-indigo-100 dark:bg-indigo-900/30 border-indigo-300 dark:border-indigo-700',
                            'amber' => 'bg-amber-100 dark:bg-amber-900/30 border-amber-300 dark:border-amber-700',
                        ];
                        $textColorClasses = [
                            'red' => 'text-red-800 dark:text-red-200',
                            'green' => 'text-green-800 dark:text-green-200',
                            'blue' => 'text-blue-800 dark:text-blue-200',
                            'indigo' => 'text-indigo-800 dark:text-indigo-200',
                            'amber' => 'text-amber-800 dark:text-amber-200',
                        ];
                    @endphp

                    <div class="relative">
                        <!-- Timeline line -->
                        @if (!$loop->last)
                            <div class="absolute left-6 top-12 bottom-0 w-0.5 bg-gray-300 dark:bg-gray-600"></div>
                        @endif

                        <!-- Cambio card -->
                        <div class="flex gap-4">
                            <!-- Icon -->
                            <div
                                class="shrink-0 w-12 h-12 rounded-full {{ $colorClasses[$data['color']] }} border-2 flex items-center justify-center text-2xl z-10">
                                {{ $data['icon'] }}
                            </div>

                            <!-- Content -->
                            <div class="flex-1 pb-6">
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow">
                                    <!-- Header -->
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h4 class="font-semibold {{ $textColorClasses[$data['color']] }} mb-1">
                                                {{ $data['titulo'] }}
                                            </h4>
                                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                                {{ $data['descripcion'] }}
                                            </p>
                                        </div>
                                        <span
                                            class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded">
                                            #{{ $cambios->count() - $index }}
                                        </span>
                                    </div>

                                    <!-- Motivo si existe -->
                                    @if ($cambio->motivo)
                                        <div
                                            class="mt-2 p-2 bg-gray-50 dark:bg-gray-900/50 rounded text-xs text-gray-600 dark:text-gray-400 border-l-2 border-gray-300 dark:border-gray-600">
                                            <span class="font-semibold">Motivo:</span> {{ $cambio->motivo }}
                                        </div>
                                    @endif

                                    <!-- Footer con metadata -->
                                    <div
                                        class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span>{{ $cambio->user ? $cambio->user->name : 'Usuario desconocido' }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $cambio->created_at->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{{ $cambio->created_at->format('H:i') }}</span>
                                            </div>
                                        </div>
                                        <span class="text-gray-400 dark:text-gray-500">
                                            {{ $cambio->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Sin cambios -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">No hay cambios registrados</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Este SIM card aún no tiene historial de cambios
                </p>
            </div>
        @endif
    @endif

    <x-slot name="footer">
        <div class="flex justify-between items-center w-full">
            <div class="text-xs text-gray-500 dark:text-gray-400">
                📊 Total de cambios: <span class="font-bold">{{ $cambios ? $cambios->count() : 0 }}</span>
            </div>
            <x-form.button flat label="Cerrar" wire:click="closeModal" />
        </div>
    </x-slot>
</x-form.modal.card>
