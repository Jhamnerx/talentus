<div class="flex items-center mt-2" x-data="{ checked: {{$model->estado ? 'true' : 'false'}} }">
    <div class="form-switch">
        <input wire:model.live.blur="estado" type="checkbox" id="switch-e{{$model->id}}" class="sr-only" x-model="checked" />
        <label class="bg-slate-400" for="switch-e{{$model->id}}">
            <span class="bg-white shadow-sm" aria-hidden="true"></span>
            <span class="sr-only">Estado</span>
        </label>
    </div>
    <div class="text-sm text-slate-400 italic ml-2" x-text="checked ? 'Aceptado' : 'Anulado'"></div>
</div>