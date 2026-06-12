<div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden mt-10">

    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h2 class="text-xl md:text-2xl text-gray-800 dark:text-gray-100 font-bold">Perfil SLA por plan</h2>
            <span class="text-gray-500 dark:text-gray-400 text-sm">
                Cada plan usa uno de los 4 perfiles. Los tickets toman estos tiempos automáticamente según el plan del vehículo/cliente.
            </span>
        </div>
        <div class="flex items-center gap-2">
            <x-form.input wire:model.live="search" placeholder="Buscar plan..." icon="magnifying-glass" />
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-x-auto">
        <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20">
                <tr>
                    <th class="px-4 py-3 text-left">Plan</th>
                    <th class="px-4 py-3 text-left">Slug</th>
                    <th class="px-4 py-3 text-left w-64">Perfil SLA</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($plans as $plan)
                    @php
                        $planName = is_array($plan->name) ? ($plan->name['es'] ?? $plan->name['en'] ?? reset($plan->name)) : $plan->name;
                    @endphp
                    <tr wire:key="plan-{{ $plan->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                        <td class="px-4 py-3">
                            <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $planName }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs font-mono">{{ $plan->slug }}</td>
                        <td class="px-4 py-3">
                            <select
                                wire:change="updateTier({{ $plan->id }}, $event.target.value)"
                                class="form-select w-full text-sm rounded-lg border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                                @foreach ($tierLabels as $tier => $label)
                                    <option value="{{ $tier }}" @selected(($plan->sla_tier ?? 'basico') === $tier)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-10 text-center text-gray-400 dark:text-gray-500">
                            No se encontraron planes
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $plans->links() }}</div>
</div>
