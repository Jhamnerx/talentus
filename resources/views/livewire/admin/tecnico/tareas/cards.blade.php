<div class="grid grid-cols-12 gap-6">
    {{-- SIN LEER --}}

    <x-admin.tecnico.tareas.card color-initial="from-sky-400" color-final="to-sky-600" cantidad="{{ $totales['unread'] }}"
        wire:click="openWithoutReading">
        VER TAREAS SIN LEER
    </x-admin.tecnico.tareas.card>


    {{-- TERMINADAS --}}
    <x-admin.tecnico.tareas.card color-initial="from-emerald-400" color-final="to-emerald-600"
        cantidad="{{ $totales['complete'] }}" wire:click="openTaskComplete">
        TAREAS COMPLETADAS
    </x-admin.tecnico.tareas.card>
    {{-- pendientes --}}
    <x-admin.tecnico.tareas.card color-initial="from-orange-400" color-final="to-orange-600"
        cantidad="{{ $totales['pendient'] }}" wire:click="openTaskPending">
        TAREAS PENDIENTES
    </x-admin.tecnico.tareas.card>
    <x-admin.tecnico.tareas.card color-initial="from-rose-400" color-final="to-rose-600"
        cantidad="{{ $totales['canceled'] }}" wire:click="openTaskCanceled">
        TAREAS CANCELADAS
    </x-admin.tecnico.tareas.card>
</div>
