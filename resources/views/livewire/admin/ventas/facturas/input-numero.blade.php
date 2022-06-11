<div class="col-span-12 mb-5">
    <label class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
        <div>Serie y Número Factura <span class="text-sm text-red-500"> * </span></div>
    </label>
    <div class="relative">

        <input required wire:model="numero" name="numero" id="numero"
            class="form-input w-2/4 valid:border-emerald-300
                                                                required:border-rose-300 invalid:border-rose-300 peer pl-14" type="text" />
        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
            <span class="text-sm text-slate-400 font-medium px-3">{{$serie}}</span>
        </div>
    </div>
    @error('numero')

    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
        {{$message}}
    </p>

    @enderror
</div>