<div>
    <x-form.modal.card title="Eliminar Plan" wire:model.live="modalDelete" width="md" align="center">

        @if ($plan)
            <div class="space-y-4">
                <div class="text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/20 mx-auto flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        ¿Estás seguro?
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Estás a punto de eliminar el plan:
                    </p>
                    <p class="text-base font-semibold text-gray-900 dark:text-gray-100 mt-2">
                        {{ $plan->name['es'] }} - {{ $plan->currency }} {{ number_format($plan->price, 2) }}
                    </p>

                    @php
                        $activeSubscriptions = $plan
                            ->subscriptions()
                            ->whereNull('ends_at')
                            ->orWhere('ends_at', '>', now())
                            ->count();
                    @endphp

                    @if ($activeSubscriptions > 0)
                        <div
                            class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                ⚠️ Este plan tiene {{ $activeSubscriptions }} suscripciones activas. No se puede
                                eliminar.
                            </p>
                        </div>
                    @else
                        <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-900/20 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Esta acción no se puede deshacer. El plan será eliminado permanentemente.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button label="Cancelar" wire:click="closeModal" flat />
                <x-form.button label="Sí, Eliminar" wire:click="delete" negative spinner="delete" icon="trash" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
