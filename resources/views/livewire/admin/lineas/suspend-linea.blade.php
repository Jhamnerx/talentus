<x-form.modal.card title="⏸️ SUSPENDER LÍNEAS" wire:model.live="openModal" align="center" max-width="3xl">

    <!-- Lista de líneas a suspender -->
    <div
        class="mb-6 p-4 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-lg border border-amber-200 dark:border-amber-700">
        <div class="flex items-start gap-3">
            <div class="shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-amber-900 dark:text-amber-100 mb-2">
                    Líneas seleccionadas ({{ count($items) }})
                </h4>
                <div class="flex flex-wrap gap-2">
                    @if ($items)
                        @foreach ($items as $item)
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-white dark:bg-gray-800 text-amber-700 dark:text-amber-300 border border-amber-300 dark:border-amber-600">
                                📱 {{ $item }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4">
        <!-- Fecha de Suspensión -->
        <div class="col-span-12 md:col-span-6">
            <x-form.datetime.picker without-time display-format="DD-MM-YYYY" :min="now()->subDays(7)"
                label="📅 Fecha de Suspensión:" placeholder="Selecciona fecha" parse-format="YYYY-MM-DD"
                wire:model.live="fecha_suspencion" hint="Se guardará con la hora actual del sistema" />
        </div>

        <!-- Fecha de Reactivación -->
        <div class="col-span-12 md:col-span-6">
            <x-form.datetime.picker without-time display-format="DD-MM-YYYY" :min="now()"
                label="🔄 Fecha límite de Reactivación:" placeholder="Fecha límite para reactivar"
                parse-format="YYYY-MM-DD" wire:model.defer="date_to_suspend"
                hint="~60 días desde la suspensión (recomendado)" />
        </div>

        <!-- Baja definitiva -->
        <div class="col-span-12">
            <div
                class="p-4 rounded-lg border {{ $baja ? 'bg-rose-50 dark:bg-rose-900/20 border-rose-300 dark:border-rose-700' : 'bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700' }}">
                <div class="flex items-start gap-3">
                    <div class="flex-1">
                        <label for="baja"
                            class="block text-sm font-semibold {{ $baja ? 'text-rose-900 dark:text-rose-100' : 'text-gray-700 dark:text-gray-300' }} mb-1">
                            ⛔ Baja definitiva
                        </label>
                        <p
                            class="text-xs {{ $baja ? 'text-rose-700 dark:text-rose-300' : 'text-gray-500 dark:text-gray-400' }}">
                            {{ $baja ? '⚠️ La línea NO podrá reactivarse automáticamente' : 'La línea podrá reactivarse dentro del período establecido' }}
                        </p>
                    </div>
                    <div class="form-switch shrink-0">
                        <input wire:model.live="baja" type="checkbox" id="baja-1" class="sr-only" />
                        <label class="{{ $baja ? 'bg-rose-500' : 'bg-slate-400' }}" for="baja-1">
                            <span class="bg-white shadow-sm" aria-hidden="true"></span>
                            <span class="sr-only">baja switch</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

@push('scripts')
    <script></script>
@endpush
