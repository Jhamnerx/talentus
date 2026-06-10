<div>
    <x-form.modal.card title="PROGRAMAR SIGUIENTE MANTENIMIENTO" max-width="2xl" wire:model.live="modalOpen" align="center">

        <div class="px-6 py-4">
            {{-- Banner informativo --}}
            <div class="flex items-start gap-3 p-3 mb-5 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-emerald-700 dark:text-emerald-300">
                    El mantenimiento fue marcado como <strong>completado</strong>. Registra aquí el próximo mantenimiento programado.
                </p>
            </div>

            <div class="grid grid-cols-12 gap-4">
                {{-- Fecha --}}
                <div class="col-span-12">
                    <x-form.datetime.picker
                        label="Fecha del próximo mantenimiento:"
                        id="sig_fecha_hora_mantenimiento"
                        name="sig_fecha_hora_mantenimiento"
                        wire:model.live="fecha_hora_mantenimiento"
                        without-time
                        parse-format="YYYY-MM-DD"
                        display-format="DD-MM-YYYY"
                        :clearable="false" />
                    @error('fecha_hora_mantenimiento')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Detalle --}}
                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">Detalle del trabajo:</label>
                    <textarea wire:model.live="detalle_trabajo"
                        class="form-input w-full" rows="2"
                        placeholder="Descripción del trabajo a realizar"></textarea>
                </div>

                {{-- Nota --}}
                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">Nota:</label>
                    <textarea wire:model.live="nota"
                        class="form-input w-full" rows="2"
                        placeholder="Observaciones adicionales"></textarea>
                </div>

                {{-- Notificaciones --}}
                <div class="col-span-12 sm:col-span-6">
                    <label class="block text-sm font-medium mb-2">Notificar Cliente:</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="sig_notify_client" value="1" class="form-radio"
                                wire:model.live="notify_client" />
                            <span class="text-sm">Sí</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="sig_notify_client" value="0" class="form-radio"
                                wire:model.live="notify_client" />
                            <span class="text-sm">No</span>
                        </label>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label class="block text-sm font-medium mb-2">Notificar Admin:</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="sig_notify_admin" value="1" class="form-radio"
                                wire:model.live="notify_admin" />
                            <span class="text-sm">Sí</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="sig_notify_admin" value="0" class="form-radio"
                                wire:model.live="notify_admin" />
                            <span class="text-sm">No</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-between items-center w-full">
                <button type="button" wire:click.prevent="cerrar"
                    class="text-sm text-slate-500 hover:text-slate-700 dark:text-gray-400 dark:hover:text-gray-200 underline cursor-pointer">
                    Omitir por ahora
                </button>
                <div class="flex gap-3">
                    <x-form.button flat label="Cancelar" wire:click.prevent="cerrar" />
                    <x-form.button primary label="Guardar mantenimiento" wire:click.prevent="guardar()" wire:loading.attr="disabled" />
                </div>
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
