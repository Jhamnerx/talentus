<div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Perfiles SLA ✨</h1>
            <span class="text-gray-500 dark:text-gray-400 text-sm">
                Define los tiempos de respuesta (TR) y restauración (TS) por prioridad para cada perfil. Los planes se vinculan a un perfil más abajo.
            </span>
        </div>
        <div class="flex items-center gap-2">
            <x-form.button primary label="Guardar perfiles" wire:click="save" spinner="save" />
        </div>
    </div>

    {{-- Tabs de perfiles --}}
    <div class="flex flex-wrap gap-2 mb-5">
        @foreach ($tierLabels as $tier => $label)
            <button wire:click="setTier('{{ $tier }}')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ $activeTier === $tier
                    ? 'bg-indigo-500 text-white shadow-sm'
                    : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-x-auto">
        <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20">
                <tr>
                    <th class="px-4 py-3 text-left">Prioridad</th>
                    <th class="px-4 py-3 text-left">TR — Respuesta (horas)</th>
                    <th class="px-4 py-3 text-center">TR en horas hábiles</th>
                    <th class="px-4 py-3 text-left">TS — Restauración (horas)</th>
                    <th class="px-4 py-3 text-center">TS en horas hábiles</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                @foreach (['urgent', 'high', 'medium', 'low'] as $priority)
                    <tr wire:key="rule-{{ $activeTier }}-{{ $priority }}" class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                        <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-100 whitespace-nowrap">
                            {{ $priorityLabels[$priority] }}
                        </td>
                        <td class="px-4 py-3 w-40">
                            <x-form.input type="number" step="0.001" min="0"
                                wire:model="rules.{{ $activeTier }}.{{ $priority }}.tr_hours" />
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox"
                                wire:model="rules.{{ $activeTier }}.{{ $priority }}.tr_business_hours"
                                class="form-checkbox rounded text-indigo-500" />
                        </td>
                        <td class="px-4 py-3 w-40">
                            <x-form.input type="number" step="0.001" min="0"
                                wire:model="rules.{{ $activeTier }}.{{ $priority }}.ts_remote_hours" />
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox"
                                wire:model="rules.{{ $activeTier }}.{{ $priority }}.ts_business_hours"
                                class="form-checkbox rounded text-indigo-500" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
        <strong>Horas hábiles</strong> = Lunes a Viernes 09:00–18:00. Si está desmarcado, el plazo cuenta en horas calendario (24/7).
        Ejemplo: 0.083 h ≈ 5 min, 0.5 h = 30 min, 9 h = 1 día hábil.
    </p>
</div>
