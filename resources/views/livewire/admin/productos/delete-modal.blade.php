<div x-data="{ show: false, productoId: null, productoNombre: '' }"
    x-on:open-delete-modal.window="show = true; productoId = $event.detail.id; productoNombre = $event.detail.nombre">
    <div x-show="show" x-on:keydown.escape.window="show = false" style="display:none"
        class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black/50 dark:bg-black/70" x-on:click="show = false"></div>

        {{-- Panel --}}
        <div class="relative flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Eliminar Producto</h3>
                    <button type="button" x-on:click="show = false"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-4">
                    <div class="flex gap-4">
                        <div class="shrink-0">
                            <div
                                class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                ¿Estás seguro de eliminar <strong x-text="productoNombre"></strong>?
                                Esta acción no se puede deshacer.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" x-on:click="show = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">
                        Cancelar
                    </button>
                    <button type="button" x-on:click="$wire.delete(productoId); show = false"
                        wire:loading.attr="disabled" wire:target="delete"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg disabled:opacity-50 cursor-pointer">
                        <span wire:loading.remove wire:target="delete">Sí, Eliminar</span>
                        <span wire:loading wire:target="delete">Eliminando...</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
