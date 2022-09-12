<div class="col-span-12 mb-5">
    <label class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
        <div>Serie y Número Factura <span class="text-sm text-red-500"> * </span></div>
    </label>
    <div class="relative">

        <input required wire:model="numero" name="numero" id="numero"
            class="form-input w-full md:w-2/4 valid:border-emerald-300
                                                                required:border-rose-300 invalid:border-rose-300 peer "
            type="text" />

    </div>
    @error('numero')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
    @enderror
</div>
