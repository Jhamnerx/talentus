<x-form.modal.card title="Registrar Asignación CUY" blur wire:model.live="openModal" align="center" max-width="xl">

    <div class="space-y-4 p-2">

        <div>
            <x-label value="Operador" />
            <x-form.select wire:model.live="operadorId" placeholder="— Seleccionar operador —">
                @foreach ($operadores as $op)
                    <x-select.option value="{{ $op->id }}" label="{{ strtoupper($op->name) }}" />
                @endforeach
            </x-form.select>
            @error('operadorId')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-label value="Texto de respuesta del proveedor" />
            <textarea
                wire:model.live="textoRespuesta"
                rows="5"
                placeholder="Pega aquí la respuesta. Ejemplo: 1.- El número: Se ha creado la alta correctamente. | Número: 51919091828 | cardPackageID: 895120100300171585"
                class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-y"
            ></textarea>
            @error('textoRespuesta')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <x-form.button flat label="Extraer datos" wire:click="parsear" />
        </div>

        @if ($parsed)
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 dark:bg-emerald-900/20 dark:border-emerald-700 p-4 space-y-2">
                <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-400">Datos extraídos:</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-slate-600 dark:text-slate-300">Número:</span>
                    <span class="font-mono font-bold text-slate-800 dark:text-slate-100">{{ $numeroParsed }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-slate-600 dark:text-slate-300">SIM Card (ICCID):</span>
                    <span class="font-mono font-bold text-slate-800 dark:text-slate-100">{{ $simCardParsed }}</span>
                    @if ($simCardYaExiste)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                            SIM ya existe — se asignará
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                            SIM nuevo — se creará
                        </span>
                    @endif
                </div>
            </div>
        @endif

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-form.button flat label="Cancelar" wire:click="closeModal" />
            <x-form.button primary label="Registrar" wire:click="save" wire:loading.attr="disabled" />
        </div>
    </x-slot>

</x-form.modal.card>
