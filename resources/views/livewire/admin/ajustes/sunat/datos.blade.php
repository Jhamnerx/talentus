<div class="col-span-12 mx-3 rounded bg-white overflow-hidden shadow-2xl">
    <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 px-3 mb-2">

        <div class="max-w-3xl col-span-12">

            <h3 class="text-base leading-snug text-slate-800 font-bold mb-6">DATOS SUNAT
            </h3>

        </div>

        <div class="col-span-12 sm:col-span-3 md:col-span-6">

            <x-form.input label="USUARIO SOL SUNAT:" placeholder="USUARIO SOL SUNAT"
                wire:model.live='sunat.usuario_sol_sunat' />

        </div>

        <div class="col-span-12 sm:col-span-3 md:col-span-6">
            <x-form.input label="CLAVE SOL SUNAT:" wire:model.live='sunat.clave_sol_sunat' />

        </div>

        <div class="col-span-12 sm:col-span-3 md:col-span-6">
            <x-form.input label="CLAVE CERTIFICADO CDT:" wire:model.live='sunat.clave_certificado_cdt' />
        </div>

        <div class="px-4 py-3 col-span-12 bg-white text-right sm:px-6">
            @can('admin.settings.plantilla.sunat.edit')
                <x-form.button wire:click="saveSunat" spinner="saveSunat" loading-delay="short" positive label="GUARDAR" />
            @endcan

        </div>

    </div>
</div>
