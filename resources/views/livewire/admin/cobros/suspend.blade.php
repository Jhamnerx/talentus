<div class="mb-6">
    <div class="flex items-center justify-between">
        <label class="block text-sm font-medium mb-1" for="observacion">Observacion: </label>
        <div class="text-sm text-slate-400 italic">opcional</div>
    </div>
    <textarea wire:model="observacion" placeholder="Ingresa una observación" name="observacion" rows="5" id="observacion"
        class="form-input w-full mb-2"></textarea>

    @if ($cobro->suspendido)
        <button wire:click.prevent="openModalActivar"
            class="btn w-full bg-green-500 hover:bg-green-600 text-white  shadow-none">
            Activar
        </button>
    @else
        <button wire:click.prevent="openModalSuspend"
            class="btn w-full bg-red-500 hover:bg-red-600 text-white  shadow-none">
            Suspender
        </button>
    @endif

</div>
