<div class="mb-6">
    <div class="flex items-center justify-between">
        <label class="block text-sm font-medium mb-1" for="observacion">Observacion: </label>
        <div class="text-sm text-slate-400 italic">opcional</div>
    </div>
    <textarea wire:model.live="observacion" placeholder="Ingresa una observación" name="observacion" rows="5"
        id="observacion" class="form-input w-full mb-2"></textarea>

    <div class="flex justify-center mb-4">
        <x-form.button full="true" wire:click.prevent="guardarObservacion" spinner="guardarObservacion"
            rounded="2xl" info label="Guardar" />
    </div>

    @if ($detalle->estado == 0)
        <div class="flex justify-center">

            <x-form.button full="true" wire:click.prevent="openModalActivar({{ $detalle->id }})"
                spinner="openModalActivar({{ $detalle->id }})" positive label="Activar" />
        </div>
    @else
        <div class="flex justify-center">
            <x-form.button full="true" wire:click.prevent="openModalSuspend({{ $detalle->id }})"
                spinner="openModalSuspend({{ $detalle->id }})" negative label="Suspender" />
        </div>
    @endif
</div>
