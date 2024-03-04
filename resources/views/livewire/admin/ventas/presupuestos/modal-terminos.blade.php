<x-form.modal.card title="Añadir Terminos" blur wire:model.live="modalTerminos" align="center">

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="flex">
                <div class="flex-auto w-11/12"></div>
                <div class="flex-auto w-full">

                    <x-form.button wire:click.debounce.250ms="add()" label="+" emerald md />
                </div>
            </div>
        </div>

        <div class="col-span-12 shadow-lg px-2">
            <label class="block text-sm font-medium mb-1">Terminos:
            </label>
            @if ($terminos->isEmpty())
                <div class="col-span-12">
                    <span class="w-full text-red-500">Agregar terminos</span>
                </div>
            @else
                @foreach ($terminos as $clave => $termino)
                    <div class="col-span-12 py-2">

                        <table>
                            <tbody>
                                <tr>
                                    <td class="w-11/12 mx-6">
                                        <x-form.textarea wire:model.live="terminos.{{ $clave }}"
                                            placeholder="Añadir Termino" />
                                    </td>
                                    <td class="mx-2">
                                        <x-form.button wire:click="eliminar('{{ $clave }}')" label="Eliminar"
                                            outline red xs icon="trash" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif

        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cerrar" wire:click="close" x-on:click="close" />
                <x-form.button primary label="Aplicar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
