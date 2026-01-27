<div>
    <x-form.modal.card title="{{ $incomeId ? 'Editar Ingreso' : 'Nuevo Ingreso' }}" wire:model="showModal" blur
        max-width="3xl">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-form.native.select label="Tipo de Comprobante *" wire:model.live="tipo_comprobante">
                <option value="INGRESOS VARIOS">Ingresos Varios</option>
                <option value="INGRESOS FINANCIEROS">Ingresos Financieros</option>
            </x-form.native.select>

            <x-form.datetime.picker label="Fecha de Emisión *" wire:model.live="fecha_emision" without-time />

            <x-form.native.select label="Cliente (Opcional)" wire:model.live="cliente_id">
                <option value="">Seleccione un cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre_completo }} -
                        {{ $cliente->numero_documento }}</option>
                @endforeach
            </x-form.native.select>

            <x-form.input label="Nombre Cliente" placeholder="Nombre del cliente" wire:model.live="cliente_nombre" />

            <x-form.input label="Documento Cliente" placeholder="DNI/RUC" wire:model.live="cliente_documento" />

            <x-form.native.select label="Método de Ingreso *" wire:model.live="metodo_ingreso">
                <option value="EFECTIVO">Efectivo</option>
                <option value="TRANSFERENCIA">Transferencia</option>
                <option value="DEPOSITO">Depósito</option>
                <option value="CHEQUE">Cheque</option>
                <option value="TARJETA">Tarjeta</option>
            </x-form.native.select>

            <x-form.input label="Destino" placeholder="Banco o destino del ingreso" wire:model.live="destino" />

            <x-form.input label="Referencia" placeholder="Número de operación" wire:model.live="referencia" />

            <x-form.currency label="Monto *" placeholder="0.00" wire:model.live="monto" prefix="S/" precision="2"
                thousands="," decimal="." />

            <x-form.native.select label="Moneda *" wire:model.live="moneda">
                <option value="PEN">Soles (PEN)</option>
                <option value="USD">Dólares (USD)</option>
            </x-form.native.select>

            <div class="sm:col-span-2">
                <x-form.textarea label="Motivo *" placeholder="Motivo o concepto del ingreso" wire:model.live="motivo"
                    rows="3" />
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary label="Guardar" wire:click="save" spinner="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
