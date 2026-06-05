<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

    {{-- Encabezado --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100">Equipos KPI</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Asigna usuarios a cada área para el cálculo
                automático de indicadores.</p>
        </div>
        <a href="{{ route('admin.gerencia.kpi-dashboard') }}"
            class="flex items-center gap-1.5 text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
            <x-heroicons name="chart-bar" class="w-4 h-4" />
            Dashboard KPI
        </a>
    </div>

    {{-- Grid de áreas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($areas as $slug => $nombre)
            @php
                $equipo = $equipos->get($slug);
                $colores = [
                    'comercial' => 'border-blue-400',
                    'operaciones' => 'border-orange-400',
                    'administracion' => 'border-green-400',
                    'postventa' => 'border-purple-400',
                    'monitoreo' => 'border-cyan-400',
                    'gerencia' => 'border-red-400',
                ];
                $badges = [
                    'comercial' => 'bg-blue-100 text-blue-700',
                    'operaciones' => 'bg-orange-100 text-orange-700',
                    'administracion' => 'bg-green-100 text-green-700',
                    'postventa' => 'bg-purple-100 text-purple-700',
                    'monitoreo' => 'bg-cyan-100 text-cyan-700',
                    'gerencia' => 'bg-red-100 text-red-700',
                ];
                $color = $colores[$slug] ?? 'border-gray-300';
                $badge = $badges[$slug] ?? 'bg-gray-100 text-gray-700';
            @endphp

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 {{ $color }} p-5 flex flex-col gap-4">

                {{-- Header tarjeta --}}
                <div class="flex items-center justify-between">
                    <div>
                        <span
                            class="inline-block text-xs font-semibold px-2 py-0.5 rounded {{ $badge }} mb-1">{{ $slug }}</span>
                        <h2 class="text-base font-bold text-gray-800 dark:text-gray-100">{{ $nombre }}</h2>
                    </div>
                    <x-form.button icon="plus" xs flat label="Agregar" color="secondary"
                        wire:click="abrirModalAgregar('{{ $slug }}')" />
                </div>

                {{-- Lista de miembros --}}
                @if ($equipo && $equipo->users->count())
                    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($equipo->users as $miembro)
                            <li class="flex items-center justify-between py-2 gap-2">
                                <div class="flex items-center gap-2 min-w-0">
                                    <div
                                        class="h-7 w-7 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-xs font-bold text-gray-600 dark:text-gray-300 shrink-0">
                                        {{ mb_strtoupper(mb_substr($miembro->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200 truncate">
                                            {{ $miembro->name }}</p>
                                        <p class="text-xs text-gray-400 truncate">{{ $miembro->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5 shrink-0">
                                    {{-- Selector de rol --}}
                                    <select
                                        class="text-xs rounded border border-gray-200 dark:border-gray-600 bg-transparent text-gray-600 dark:text-gray-300 px-1 py-0.5"
                                        wire:change="cambiarRol({{ $equipo->id }}, {{ $miembro->id }}, $event.target.value)">
                                        <option value="lider"
                                            {{ $miembro->pivot->role_in_team === 'lider' ? 'selected' : '' }}>Líder
                                        </option>
                                        <option value="miembro"
                                            {{ $miembro->pivot->role_in_team !== 'lider' ? 'selected' : '' }}>Miembro
                                        </option>
                                    </select>
                                    <button wire:click="quitarMiembro({{ $equipo->id }}, {{ $miembro->id }})"
                                        wire:confirm="¿Quitar a {{ $miembro->name }} del equipo?"
                                        class="text-gray-400 hover:text-red-500 transition-colors" title="Quitar">
                                        <x-heroicons name="x-mark" class="w-4 h-4" />
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-4">Sin miembros asignados</p>
                @endif

            </div>
        @endforeach
    </div>

    {{-- Modal: agregar miembro --}}
    <x-form.modal.card title="Agregar miembro — {{ $nombreArea }}" wire:model.live="modalAgregar" max-width="md">
        <div class="space-y-4">

            {{-- Búsqueda --}}
            <x-form.input wire:model.live.debounce.300ms="busquedaUsuario" label="Buscar usuario"
                placeholder="Nombre o email..." icon="magnifying-glass" />

            {{-- Lista de resultados --}}
            @if (count($usuariosDisponibles))
                <div class="border dark:border-gray-600 rounded-lg overflow-hidden">
                    @foreach ($usuariosDisponibles as $u)
                        <button type="button"
                            class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700 text-left transition-colors
                                {{ $userId === $u['id'] ? 'bg-indigo-50 dark:bg-indigo-900/30' : '' }}"
                            wire:click="$set('userId', {{ $u['id'] }})">
                            <div
                                class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-sm font-bold text-gray-600 dark:text-gray-300 shrink-0">
                                {{ mb_strtoupper(mb_substr($u['name'], 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $u['name'] }}</p>
                                <p class="text-xs text-gray-400">{{ $u['email'] }}</p>
                            </div>
                            @if ($userId === $u['id'])
                                <x-heroicons name="check-circle" class="w-5 h-5 text-indigo-500 ml-auto" />
                            @endif
                        </button>
                    @endforeach
                </div>
            @elseif ($busquedaUsuario)
                <p class="text-sm text-gray-400 text-center py-2">No se encontraron usuarios.</p>
            @endif

            {{-- Rol --}}
            <x-form.select wire:model="rolEnEquipo" label="Rol en el equipo" :options="[['name' => 'Miembro', 'id' => 'miembro'], ['name' => 'Líder', 'id' => 'lider']]" option-label="name"
                option-value="id" />

            @error('userId')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button flat label="Cancelar" wire:click="$set('modalAgregar', false)" />
                <x-form.button primary label="Agregar al equipo" wire:click="agregarMiembro" :disabled="!$userId" />
            </div>
        </x-slot>
    </x-form.modal.card>

</div>
