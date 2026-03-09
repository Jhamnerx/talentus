<div>
    <x-form.modal.card title="Actualizar contraseña" max-width="2xl" wire:model.live="modalOpen" align="center">

        <form wire:submit="updatePassword">
            <div class="px-8 py-5 bg-white sm:p-6">

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-6 sm:col-span-12">
                        <x-label for="current_password" value="{{ __('Current Password') }}" />
                        <x-input id="current_password" type="password" class="mt-1 block w-full"
                            wire:model.live="state.current_password" autocomplete="current-password" />
                        <x-input-error for="current_password" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-12">
                        <x-label for="password" value="{{ __('New Password') }}" />
                        <x-input id="password" type="password" class="mt-1 block w-full"
                            wire:model.live="state.password" autocomplete="new-password" />
                        <x-input-error for="password" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-12">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="password_confirmation" type="password" class="mt-1 block w-full"
                            wire:model.live="state.password_confirmation" autocomplete="new-password" />
                        <x-input-error for="password_confirmation" class="mt-2" />
                    </div>


                </div>

            </div>
        </form>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-action-message class="mr-3" on="saved-pass">
                    {{ __('Saved.') }}
                </x-action-message>
                <x-form.button flat label="Cerrar" wire:click="closeModal" />
                <x-form.button primary label="Guardar" type="submit" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
