<div>
    <x-form.modal.card title="Crear Nuevo Ticket" wire:model="showModal" blur max-width="3xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <x-form.input label="Asunto" placeholder="Ingrese el asunto del ticket" wire:model="subject" />
            </div>

            <div class="md:col-span-2">
                <x-form.textarea label="Descripción" placeholder="Describa el problema o solicitud"
                    wire:model="description" rows="4" />
            </div>

            <div>
                <x-form.select label="Cliente" placeholder="Seleccione un cliente" autocomplete="off"
                    wire:model="customer_id" option-description="numero_documento" :async-data="route('api.clientes.index')"
                    option-label="razon_social" option-value="id" />
            </div>

            <div>
                <x-form.select label="Categoría" placeholder="Seleccione una categoría" wire:model="category_id">
                    <x-select.option label="Sin categoría" value="" />
                    @foreach ($categories as $category)
                        <x-select.option label="{{ $category->name }}" value="{{ $category->id }}" />
                    @endforeach
                </x-form.select>
            </div>

            <div>
                <x-form.select label="Prioridad" wire:model="priority">
                    <x-select.option label="Baja" value="low" />
                    <x-select.option label="Media" value="medium" />
                    <x-select.option label="Alta" value="high" />
                    <x-select.option label="Urgente" value="urgent" />
                </x-form.select>
            </div>

            <div>
                <x-form.select label="Asignar a" placeholder="Asignar a un usuario (opcional)" wire:model="assigned_to">
                    <x-select.option label="Sin asignar" value="" />
                    @foreach ($users as $user)
                        <x-select.option label="{{ $user->name }}" value="{{ $user->id }}" />
                    @endforeach
                </x-form.select>
            </div>

            <div class="md:col-span-2">
                <x-form.select label="Vehículo asociado (opcional)" placeholder="Buscar por placa..." autocomplete="off"
                    wire:model="vehiculo_id" :async-data="route('api.vehiculos.index')" option-label="placa" option-value="id"
                    option-description="option_description" />
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-2">
                <x-form.button flat label="Cancelar" wire:click="$set('showModal', false)" />
                <x-form.button primary label="Crear Ticket" wire:click="save" spinner="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
