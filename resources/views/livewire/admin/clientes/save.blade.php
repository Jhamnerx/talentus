<x-form.modal.card title="REGISTRAR CLIENTE" max-width="3xl" wire:model.live="modalSave" align="center">

    {{-- ── Sección 1: Datos del cliente ───────────────────────────────────────── --}}
    <div class="space-y-4">
        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
            Datos del cliente
        </h3>

        <div class="grid grid-cols-12 gap-4">

            <div class="col-span-12 sm:col-span-6">
                <x-form.select label="Tipo de documento *" wire:model.live="tipo_documento_id"
                    placeholder="Selecciona tipo" option-description="codigo" :async-data="route('api.documentos.index')"
                    option-label="descripcion" option-value="codigo" />
            </div>

            <div class="col-span-12 sm:col-span-6">
                <x-form.input label="Número de documento *" placeholder="10203040" wire:model.live='numero_documento'>
                    @if (in_array($tipo_documento_id, [1, 6]))
                        <x-slot name="append">
                            <x-form.button class="h-full" icon="magnifying-glass" rounded="rounded-r-md" primary flat
                                wire:click="buscarDocumento" wire:loading.attr="disabled" />
                        </x-slot>
                    @endif
                </x-form.input>
                @if ($errorConsulta)
                    <p class="mt-1 text-sm text-red-600">{{ $errorConsulta }}</p>
                @endif
            </div>

            <div class="col-span-12">
                <x-form.input label="Razón Social *" placeholder="INGRESA LA RAZÓN SOCIAL"
                    wire:model.live='razon_social' />
            </div>

            {{-- DNI: teléfono y email obligatorios (son también los del contacto) --}}
            @if ($tipo_documento_id == 1)
                <div class="col-span-12 sm:col-span-6">
                    <x-form.input type="tel" label="Teléfono *" placeholder="987654321"
                        wire:model.live='telefono' />
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <x-form.input type="email" label="Correo *" placeholder="cliente@correo.com"
                        wire:model.live='email' />
                </div>
            @else
                <div class="col-span-12 sm:col-span-6">
                    <x-form.input type="tel" label="Teléfono empresa" placeholder="01-2345678"
                        wire:model.live='telefono' />
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <x-form.input type="email" label="Correo empresa" placeholder="empresa@correo.com"
                        wire:model.live='email' />
                </div>
            @endif

            <div class="col-span-12">
                <x-form.input label="Dirección" wire:model.live='direccion' placeholder='Ingresa una dirección' />
            </div>

            <div class="col-span-12 sm:col-span-6">
                <x-form.select id="ubigeo" name="ubigeo" label="Ubigeo:" wire:model.live="ubigeo"
                    placeholder="Buscar departamento / provincia / distrito" :async-data="[
                        'api' => route('api.ubigeos.index'),
                    ]"
                    option-label="option_description" option-value="ubigeo_inei" />
            </div>

            <div class="col-span-12 sm:col-span-6">
                <x-form.select
                    label="Rubro de cliente"
                    wire:model.live="rubro_id"
                    placeholder="Sin rubro"
                    :options="$rubros->map(fn($r) => ['value' => $r->id, 'label' => $r->nombre])->toArray()"
                    option-label="label"
                    option-value="value"
                />
            </div>

            <div class="col-span-12 sm:col-span-6">
                <x-form.select
                    label="Sector del cliente"
                    wire:model.live="sector_id"
                    placeholder="Sin sector"
                    :options="$sectores->map(fn($s) => ['value' => $s->id, 'label' => $s->nombre])->toArray()"
                    option-label="label"
                    option-value="value"
                />
            </div>
        </div>
    </div>

    {{-- ── Sección 2: Contacto principal ──────────────────────────────────────── --}}
    @if ($tipo_documento_id == 6)
        <div class="mt-6 space-y-4 border-t border-gray-200 dark:border-gray-700 pt-5">
            <div class="flex items-center gap-2">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                    Contacto principal
                </h3>
                <span
                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                    Requerido
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Registra la persona natural responsable de la empresa (representante legal o contacto clave).
            </p>

            <div class="grid grid-cols-12 gap-4">

                <div class="col-span-12 sm:col-span-7">
                    <x-form.input label="Nombre completo *" placeholder="Juan Pérez García"
                        wire:model.live='contacto_nombre' />
                </div>

                <div class="col-span-12 sm:col-span-5">
                    <x-form.input label="DNI del contacto *" placeholder="12345678"
                        wire:model.live='contacto_numero_documento' maxlength="8">
                        <x-slot name="append">
                            <x-form.button class="h-full" icon="magnifying-glass" rounded="rounded-r-md" primary flat
                                wire:click="buscarContacto" wire:loading.attr="disabled" wire:target="buscarContacto" />
                        </x-slot>
                    </x-form.input>
                    @if ($errorContacto)
                        <p class="mt-1 text-sm text-red-600">{{ $errorContacto }}</p>
                    @endif
                </div>

                <div class="col-span-12 sm:col-span-4">
                    <x-form.input label="Cargo" placeholder="Gerente General" wire:model.live='contacto_cargo' />
                </div>

                <div class="col-span-12 sm:col-span-4">
                    <x-form.input type="tel" label="Teléfono *" placeholder="987654321"
                        wire:model.live='contacto_telefono' />
                </div>

                <div class="col-span-12 sm:col-span-4">
                    <x-form.input type="email" label="Correo" placeholder="contacto@correo.com"
                        wire:model.live='contacto_email' />
                </div>

            </div>
        </div>
    @endif

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-form.button flat label="Cancelar" x-on:click="close" />
            <x-form.button primary label="Guardar cliente" wire:click="save" wire:loading.attr="disabled" />
        </div>
    </x-slot>
</x-form.modal.card>
