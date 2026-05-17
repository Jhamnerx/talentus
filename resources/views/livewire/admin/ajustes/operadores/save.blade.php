<x-form.modal.card title="AÑADIR OPERADOR" max-width="lg" wire:model.live="openModalSave" align="center">

    <form autocomplete="off">
        <div class="px-6 py-5 space-y-5">

            <div>
                <label class="block text-sm font-medium mb-1" for="op-name">
                    Nombre <span class="text-rose-500">*</span>
                </label>
                <input wire:model.live="name" id="op-name" name="name" type="text"
                    placeholder="Ej: CLARO, MOVISTAR, M2M…" class="form-input w-full" />
                @error('name')
                    <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <input wire:model.live="have_api" id="op-have-api" type="checkbox"
                    class="form-checkbox rounded text-indigo-500" />
                <label for="op-have-api" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Tiene integración API
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="op-api-slug">
                    API Slug
                    <span class="text-slate-400 font-normal">(opcional)</span>
                </label>
                <input wire:model.live="api_slug" id="op-api-slug" name="api_slug" type="text"
                    placeholder="Ej: m2m_dataglobal" class="form-input w-full" />
                @error('api_slug')
                    <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                @enderror
                <div
                    class="mt-2 p-3 rounded-md bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">
                        Slugs disponibles</p>
                    <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1">
                        <li>
                            <code
                                class="bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-300 px-1.5 py-0.5 rounded font-mono">m2m_dataglobal</code>
                            — M2M Dataglobal (sincronización de SIM cards)
                        </li>
                    </ul>
                    <p class="mt-1.5 text-xs text-slate-400">Dejar vacío si el operador no usa API externa.</p>
                </div>
            </div>

        </div>
    </form>

    <x-slot name="footer">
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            <x-form.button label="Cancelar" wire:click="closeModal" flat />
            <x-form.button label="Guardar" wire:click="save" primary spinner="save" />
        </div>
    </x-slot>

</x-form.modal.card>
