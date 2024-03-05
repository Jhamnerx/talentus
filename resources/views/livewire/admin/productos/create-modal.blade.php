<x-form.modal.card title="Crear Producto" blur wire:model.live="modalCreate" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12">

            <div class="flex flex-wrap gap-4">
                <x-form.radio md id="tipo_1" name="tipo" left-label="Producto" value="producto"
                    wire:model.live="tipo" />
                <x-form.radio md id="tipo_2" name="tipo" label="Servicio" value="servicio"
                    wire:model.live="tipo" />
            </div>

        </div>

        <div class="col-span-12">

            <x-form.textarea id="descripcion" name="descripcion" wire:model="descripcion" label="Descripción:"
                placeholder="Descripcion del producto" />
        </div>

        <div class="col-span-12 md:col-span-5">


            <x-form.select id="categoria_id" name="categoria_id" label="Selecciona una categoria"
                wire:model.live="categoria_id" placeholder="Selecciona una categoria" :async-data="[
                    'api' => route('api.categorias.index'),
                ]"
                option-label="nombre" option-value="id" />
        </div>




        <div class="col-span-12 md:col-span-3">

            <x-form.input id="codigo" name="codigo" wire:model.live="codigo" label="Codigo:"
                placeholder="Codigo del producto" />

        </div>

        <div class="col-span-12 md:col-span-4">

            <x-form.select id="unit_code" name="unit_code" label="Unidad:" wire:model.live="unit_code"
                placeholder="Selecciona una opcion" :async-data="route('api.unit.index')" option-label="name" option-value="codigo" />
        </div>


        <div class="col-span-12 md:col-span-3">

            <x-form.inputs.number id="stock" name="stock" wire:model="stock" label="Stock:" />

        </div>

        <div class="col-span-12 md:col-span-4">
            <x-form.select id="divisa_p" label="Divisa:" :options="[['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]" option-label="name" option-value="id"
                wire:model="divisa" :clearable="false" icon='currency-dollar' />
        </div>

        <div class="col-span-12 md:col-span-4">

            <x-form.inputs.currency id="valor_unitario" name="valor_unitario" label="Valor unitario:" placeholder="9.99"
                icon="currency-dollar" precision="2" wire:model.blur="valor_unitario" />
        </div>
        <div class="col-span-12">
            <x-form.checkbox id="afecto_icbper" name="afecto_icbper" md left-label="Afecto icbper?"
                wire:model="afecto_icbper" />
        </div>

        <div class="col-span-12" wire:ignore>

            <form.input name="imagen" id="imagen" type="file" class="imagen-upload" accept="image/*">

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
        const input = document.querySelector(".imagen-upload");
        const img = document.querySelector(".img");

        // Create a FilePond instance
        $(document).ready(function() {
            var imagen = FilePond.create(input, {
                name: 'producto-imagen',
                labelIdle: `Arrastra y suelta tu imagen o <span class="filepond--label-action">Selecciona</span>`,
                maxFiles: 1,
                credits: false,
            });

            // listen for events

            // 'addfile' instead of 'FilePond:addfile'
            imagen.on('addfile', (error, file) => {

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

                    //console.log(base64String);
                    @this.set('file', base64String);

                    img.SRC = base64String;
                    // Logs wL2dvYWwgbW9yZ...
                };
                reader.readAsDataURL(file.file);

            });

        });
    </script>
@endpush
