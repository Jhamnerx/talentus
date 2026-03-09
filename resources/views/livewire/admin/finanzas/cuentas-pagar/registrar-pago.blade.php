<x-form.modal.card title="Registrar Pago a Proveedor" wire:model="showModal" blur max-width="md">
    @if ($cuenta)
        <div class="space-y-4">
            <!-- Información de la cuenta -->
            <div class="bg-gray-50 dark:bg-gray-900/20 p-4 rounded-lg space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Proveedor:</span>
                    <span
                        class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $cuenta->proveedor->nombre }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Documento:</span>
                    <span
                        class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $cuenta->numero_documento }}</span>
                </div>
                <div class="flex justify-between border-t pt-2 mt-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Monto Total:</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">S/
                        {{ number_format($cuenta->monto_total, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Pagado:</span>
                    <span class="text-sm text-emerald-600 dark:text-emerald-400">S/
                        {{ number_format($cuenta->monto_pagado, 2) }}</span>
                </div>
                <div class="flex justify-between border-t pt-2">
                    <span class="text-base font-semibold text-gray-700 dark:text-gray-300">Saldo Pendiente:</span>
                    <span class="text-base font-bold text-rose-600 dark:text-rose-400">S/
                        {{ number_format($cuenta->saldo_pendiente, 2) }}</span>
                </div>
            </div>

            <!-- Formulario de pago -->
            <div class="space-y-4">
                <x-form.currency label="Monto a Pagar" placeholder="0.00" wire:model="monto_pago" prefix="S/"
                    thousands="," decimal="." precision="2" />

                <x-form.native.select label="Método de Pago" wire:model="metodo_pago">
                    <option value="EFECTIVO">Efectivo</option>
                    <option value="TRANSFERENCIA">Transferencia Bancaria</option>
                    <option value="DEPOSITO">Depósito</option>
                    <option value="CHEQUE">Cheque</option>
                    <option value="TARJETA">Tarjeta</option>
                </x-form.native.select>

                <x-form.datetime.picker label="Fecha de Pago" wire:model="fecha_pago" without-time />

                <x-form.textarea label="Referencia / Observaciones" placeholder="Nº de operación, notas adicionales..."
                    wire:model="referencia" rows="2" />
            </div>
        </div>
    @endif

    <x-slot name="footer">
        <div class="flex justify-end gap-x-3">
            <x-form.button flat label="Cancelar" wire:click="closeModal" />
            <x-form.button primary label="Registrar Pago" wire:click="registrar" spinner="registrar" />
        </div>
    </x-slot>
</x-form.modal.card>
