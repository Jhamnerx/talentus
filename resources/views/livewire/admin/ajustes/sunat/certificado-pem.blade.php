<div class="col-span-12 md:col-span-6 xl:col-span-5">
    <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full">
        <div class="px-5 py-3 border-b border-slate-200">
            <div class="flex justify-between items-center">
                <div class="font-semibold text-slate-800 uppercase">CERTIFICADO FORMATO PEM</div>
            </div>
        </div>

        <div class="relative justify-center px-6 pt-2 pb-6 xl:pb-11 cursor-pointer rounded-md">
            <x-form.textarea class="px-5 mx-2 w-full" wire:model.text="data" label="Inserta el certificado"
                placeholder="Pega el certificado" />
        </div>
        <!-- Modal footer -->
        <div class="px-5 py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">

                <x-form.button @click="files = null" wire:click='uploadCertificado' spinner="uploadCertificado"
                    label="Crear Archivo PEM" primary icon="upload" />
            </div>
        </div>
    </div>
</div>
