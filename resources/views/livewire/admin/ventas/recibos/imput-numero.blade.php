<div class="col-span-12 mb-2">
    <label class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
        <div>Serie y Número Recibo <span class="text-sm text-red-500"> * </span></div>
    </label>
    <div class="relative">

        <input required wire:model.live="numero" name="numero" id="numero"
            class="form-input w-full sm:w-2/4 valid:border-emerald-300
                                                                required:border-rose-300 invalid:border-rose-300 peer pl-3"
            type="text" />

    </div>
    @error('numero')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
    @enderror
</div>
