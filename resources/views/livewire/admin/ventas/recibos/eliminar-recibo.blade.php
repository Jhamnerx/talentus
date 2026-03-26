<div>
    <x-form.modal.card title="Eliminar Recibo" wire:model="mostrarModal" width="lg">
        <div class="flex gap-4">
            <div class="shrink-0">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="flex-1 space-y-3">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    ¿Estás seguro de eliminar este recibo? Esta acción no se puede deshacer.
                </p>

                {{-- Cobro vinculado --}}
                @if ($notificacion)
                    <div
                        class="rounded-lg border border-amber-200 bg-amber-50 dark:bg-amber-900/20 dark:border-amber-700 p-3">
                        <p
                            class="text-xs font-semibold text-amber-700 dark:text-amber-400 mb-1 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Cobro vinculado — se desvinculará y volverá a PENDIENTE
                        </p>
                        <p class="text-xs text-amber-800 dark:text-amber-300">
                            {{ $notificacion['descripcion'] }} &bull;
                            {{ $notificacion['moneda'] }} {{ $notificacion['monto'] }} &bull;
                            Vence: {{ $notificacion['vencimiento'] }}
                        </p>
                    </div>
                @endif

                {{-- Pagos asociados --}}
                @if (count($pagosAsociados) > 0)
                    <div class="rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/20 dark:border-red-700 p-3">
                        <p class="text-xs font-semibold text-red-700 dark:text-red-400 mb-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Los siguientes pagos serán eliminados y deberán recrearse:
                        </p>
                        <div class="space-y-1">
                            @foreach ($pagosAsociados as $pago)
                                <div class="flex items-center justify-between text-xs text-red-800 dark:text-red-300">
                                    <span class="font-mono">{{ $pago['numero'] }}</span>
                                    <span>{{ $pago['metodo'] }}</span>
                                    <span class="font-semibold">{{ $pago['divisa'] }} {{ $pago['monto'] }}</span>
                                    <span class="text-red-600 dark:text-red-400">{{ $pago['fecha'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-2">
                <x-form.button flat label="Cancelar" wire:click="cerrarModal" />
                <x-form.button negative label="Sí, Eliminar" wire:click="eliminar" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
