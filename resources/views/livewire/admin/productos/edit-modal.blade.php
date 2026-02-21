<x-form.modal.card title="Editar Producto" blur wire:model.live="modalEdit" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12">

            <x-form.textarea name="descripcion" wire:model="descripcion" label="Descripción:"
                placeholder="Descripcion del producto" />

        </div>

        <div class="col-span-12 md:col-span-5">


            <x-form.select id="categoria_id" name="categoria_id" label="Selecciona una categoria"
                wire:model.live="categoria_id" placeholder="Selecciona una categoria" :async-data="[
                    'api' => route('api.categorias.index'),
                ]"
                option-label="nombre" option-value="id" />
        </div>


        <div class="col-span-12 md:col-span-4 {{ $es_dispositivo ? '' : 'hidden' }}">

            <x-form.select label="Modelo Vinculado:" name="modelo_id" wire:model.live="modelo_id"
                placeholder="Selecciona un modelo" :async-data="[
                    'api' => route('api.dispositivos.modelos.index'),
                ]" option-label="modelo" option-value="id"
                option-description="marca" />
        </div>

        <div class="col-span-12 md:col-span-3">

            <x-form.input name="codigo" wire:model.live="codigo" label="Codigo:" placeholder="Codigo del producto" />

        </div>

        <div class="col-span-12 md:col-span-4">

            <x-form.select name="unit_code" label="Unidad:" wire:model.live="unit_code"
                placeholder="Selecciona una opcion" :async-data="route('api.unit.index')" option-label="name" option-value="codigo" />
        </div>


        <div class="col-span-12 md:col-span-3">

            <x-form.number name="stock" wire:model="stock" label="Stock:" />

        </div>

        <div class="col-span-12 md:col-span-3">
            <x-form.select label="Divisa:" :options="[['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]" option-label="name" option-value="id"
                wire:model.live="divisa" :clearable="false" icon='currency-dollar' />
        </div>

        <div class="col-span-12 md:col-span-3">

            <x-form.currency id="valor_unitario" name="valor_unitario" label="Valor unitario:" placeholder="9.99"
                icon="currency-dollar" precision="4" wire:model.blur="valor_unitario" />
        </div>

        <div class="col-span-12 md:col-span-3">

            <x-form.currency id="precio_unitario" name="precio_unitario" label="Precio unitario:" placeholder="9.99"
                icon="currency-dollar" precision="4" wire:model.blur="precio_unitario" />
        </div>

        <div class="col-span-12">
            <x-form.checkbox id="es_dispositivo" name="es_dispositivo" md left-label="¿Es un Dispositivo?"
                wire:model.live="es_dispositivo" />
        </div>

        @if ($tipo === 'servicio')
            <div class="col-span-12">
                @if ($yaExisteServicioCobro && !$es_servicio_cobro)
                    <div
                        class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-3 mb-2">
                        <p class="text-sm text-amber-800 dark:text-amber-200">
                            <svg class="inline w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Ya existe otro servicio marcado como servicio de cobro. Solo puede haber uno por empresa.
                        </p>
                    </div>
                @endif
                <x-form.checkbox id="es_servicio_cobro" name="es_servicio_cobro" md
                    left-label="¿Servicio para Facturación de Cobros?" wire:model="es_servicio_cobro"
                    :disabled="$yaExisteServicioCobro && !$es_servicio_cobro" />
            </div>
        @endif

        <div class="col-span-12">
            <x-form.checkbox id="afecto_icbper" md left-label="Afecto icbper?" wire:model="afecto_icbper" />
        </div>

        <div class="col-span-12" wire:ignore>

            <input name="imagen" id="imagen" type="file" class="imagen-upload-edit" accept="image/*">

        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

@push('scripts')
    <script>
        // Get a file input reference
        const inputEdit = document.querySelector(".imagen-upload-edit");
        //const img = document.querySelector(".img");

        // Create a FilePond instance
        $(document).ready(function() {
            var imagenEdit = FilePond.create(inputEdit, {
                name: 'producto-imagen',
                labelIdle: `Arrastra y suelta tu imagen o <span class="filepond--label-action">Selecciona</span>`,
                maxFiles: 1,
                credits: false,
            });

            // listen for events

            // 'addfile' instead of 'FilePond:addfile'
            imagenEdit.on('addfile', (error, file) => {

                if (error) {
                    console.log('Oh no');
                    return;
                }
                // Encode the file using the FileReader API
                const reader = new FileReader();
                reader.onloadend = () => {
                    // Use a regex to remove data url part
                    const base64String = reader.result
                        .replace('data:', '')
                        .replace(/^.+,/, '');

                    @this.set('file', base64String);
                    @this.set('file_name', file.file.name);

                };
                reader.readAsDataURL(file.file);

            });


            Livewire.on('set-imagen-file', (event) => {

                imagenEdit.addFile(event.imagen);

            });

            imagenEdit.on('removefile', (error, file) => {

                @this.set('file', null);
                @this.set('file_name', null);

            });

        });
    </script>
@endpush
