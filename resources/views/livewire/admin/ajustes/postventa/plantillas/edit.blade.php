<div>
    <x-form.modal.card title="EDITAR PLANTILLA POST-VENTA" max-width="lg" wire:model.live="openModal" align="center">
        <form autocomplete="off">
            <div class="px-5 py-4 grid grid-cols-12 gap-4">

                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">Sector</label>
                    <select wire:model.live="sector_id" class="form-select w-full">
                        <option value="">— Plantilla por defecto —</option>
                        @foreach ($sectores as $sector)
                            <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                        @endforeach
                    </select>
                    @error('sector_id')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">
                        Cuerpo del mensaje
                        <span class="text-xs font-normal text-gray-400 ml-1">Variables: {placa} {cliente} {fecha_instalacion} {fecha_cierre}</span>
                    </label>
                    <textarea wire:model.live="cuerpo" rows="5" class="form-textarea w-full"
                        placeholder="Escribe el mensaje..."></textarea>
                    @error('cuerpo')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">
                        Archivo adjunto <span class="text-xs font-normal text-gray-400">(PDF o video, máx. 16 MB)</span>
                    </label>
                    @if ($archivoActual)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                            Archivo actual: <span class="font-mono">{{ basename($archivoActual) }}</span>
                            (sube uno nuevo para reemplazarlo)
                        </p>
                    @endif
                    <input type="file" wire:model="archivo" class="form-input w-full" accept=".pdf,.mp4,.mov,.avi" />
                    <div wire:loading wire:target="archivo" class="text-xs text-gray-400 mt-1">Subiendo archivo...</div>
                    @error('archivo')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12 flex items-center gap-3">
                    <label class="block text-sm font-medium">Activo</label>
                    <input type="checkbox" wire:model.live="activo" class="form-checkbox" />
                </div>

            </div>
        </form>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click.prevent="close" />
                <x-form.button primary label="Actualizar" wire:click.prevent="update" spinner="update" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
