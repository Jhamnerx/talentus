<div>
    <x-form.modal.card title="USUARIOS TECNICOS" max-width="5xl" wire:model.live="openModal">
        <path
            d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
        </svg>
        </button>


        <!-- Modal content -->
        <div class="px-8 py-5 bg-white sm:p-6">
            <!-- Table -->
            <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
                <header class="px-5 py-4">
                    <h2 class="font-semibold text-slate-800">Usuarios <span
                            class="text-slate-400 font-medium">{{ $usuarios->total() }}</span>
                    </h2>
                </header>
                <div>

                    <!-- Table -->
                    <div class="overflow-x-auto min-h-screen">>
                        <table class="table-auto w-full">
                            <!-- Table header -->
                            <thead
                                class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                                <tr>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center">
                                            <label class="inline-flex">
                                                <span class="sr-only">Seleccionar todo</span>
                                                <input id="parent-checkbox" class="form-checkbox" type="checkbox"
                                                    @click="toggleAll" />
                                            </label>
                                        </div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Nombres</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Email</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Roles</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Estado</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">Acciones</div>
                                    </th>
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="text-sm divide-y divide-slate-200">
                                <!-- Row -->
                                @if ($usuarios->count())
                                    @foreach ($usuarios as $usuario)
                                        @if ($usuario->email !== 'jhamnerx1x@gmail.com')
                                            <tr>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                                    <div class="flex items-center">
                                                        <label class="inline-flex">
                                                            <span class="sr-only">Select</span>
                                                            <input class="table-item form-checkbox" type="checkbox"
                                                                @click="uncheckParent" />
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div class="font-medium text-blue-500">{{ $usuario->name }}
                                                    </div>
                                                </td>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div class="font-medium text-slate-800">
                                                        {{ $usuario->email }}</div>
                                                </td>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div class="font-medium text-slate-800">
                                                        @if (!empty($usuario->getRoleNames()))
                                                            @foreach ($usuario->getRoleNames() as $rolName)
                                                                {{ $rolName }}
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div>
                                                        <div class="m-3 ">
                                                            <div class="flex items-center mt-2" x-data="{ checked: {{ $usuario->is_active ? 'true' : 'false' }} }">
                                                                <div class="form-switch">
                                                                    <input
                                                                        wire:click="toggleStatus({{ $usuario->id }})"
                                                                        type="checkbox" id="switch-e{{ $usuario->id }}"
                                                                        class="sr-only" x-model="checked" />
                                                                    <label class="bg-slate-400"
                                                                        for="switch-e{{ $usuario->id }}">
                                                                        <span class="bg-white shadow-sm"
                                                                            aria-hidden="true"></span>
                                                                        <span class="sr-only">Estado</span>
                                                                    </label>
                                                                </div>
                                                                <div class="text-sm text-slate-400 italic ml-2"
                                                                    x-text="checked ? 'Activo' : 'Inactivo'">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                                    <div class="space-x-1">

                                                        <a href="{{ route('admin.users.edit', $usuario) }}">
                                                            <button
                                                                class="text-slate-400 hover:text-slate-500 rounded-full">
                                                                <span class="sr-only">Editar</span>
                                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                                    <path
                                                                        d="M19.7 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 22H10v-2.6l6-6 2.6 2.6-6 6zm7.4-7.4L17.4 12l1.6-1.6 2.6 2.6-1.6 1.6z" />
                                                                </svg>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <td colspan="10"
                                        class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                        <div class="text-center">No hay Registros</div>
                                    </td>
                                @endif


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!-- Pagination -->
            <div class="mt-8 w-full">
                {{ $usuarios->links() }}
                {{-- @include('admin.partials.pagination-classic') --}}

            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click.prevent="closeModal" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

@once
    @push('scripts')
    @endpush
@endonce
