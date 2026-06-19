<div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">
        Reseñas ({{ $resenas->count() }})
    </h2>

    @can('gestionar-resenas-cliente')
        <form wire:submit.prevent="guardar" class="mb-5 space-y-3">
            <div>
                <label for="comentario" class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Comentario</label>
                <textarea wire:model="comentario" id="comentario" rows="3"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm"
                    placeholder="Escribe una reseña sobre este cliente..."></textarea>
                @error('comentario')
                    <span class="text-xs text-rose-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <span class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Calificación (opcional)</span>
                <div class="flex items-center gap-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="$set('calificacion', {{ $i }})"
                            class="p-0.5" title="{{ $i }} estrella(s)">
                            <svg class="w-5 h-5 {{ $calificacion && $i <= $calificacion ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    @endfor
                    @if ($calificacion)
                        <button type="button" wire:click="$set('calificacion', null)"
                            class="ml-2 text-xs text-gray-400 hover:text-gray-600">Quitar</button>
                    @endif
                </div>
                @error('calificacion')
                    <span class="text-xs text-rose-600">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition-colors">
                Agregar reseña
            </button>
        </form>
    @endcan

    @if ($resenas->isNotEmpty())
        <ul class="space-y-3">
            @foreach ($resenas as $resena)
                <li wire:key="resena-{{ $resena->id }}" class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <div class="flex items-center gap-2 text-sm">
                            <span class="font-medium text-gray-800 dark:text-gray-100">{{ $resena->user->name }}</span>
                            <span class="text-xs text-gray-400">
                                — {{ \App\Models\Team::KPI_AREAS[$resena->team->kpi_area] ?? $resena->team->name }}
                            </span>
                        </div>
                        <time class="text-xs text-gray-400">{{ $resena->created_at->format('d/m/Y H:i') }}</time>
                    </div>

                    @if ($resena->calificacion)
                        <div class="flex items-center gap-0.5 mt-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $resena->calificacion ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                    @endif

                    <p class="text-sm text-gray-700 dark:text-gray-200 mt-2">{{ $resena->comentario }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-sm text-gray-400">Sin reseñas registradas.</p>
    @endif
</div>
