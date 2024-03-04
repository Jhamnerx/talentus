<div class="flex items-center" x-data="{ checked: {{$model->is_active ? 'true' : 'false'}} }">
    <div class="form-switch">
        <input role="switch" wire:model.live.blur="is_active" type="checkbox" id="switch-e{{$model->id}}" class="sr-only"
            x-model="checked" />
        <label class="bg-slate-400" for="switch-e{{$model->id}}">
            <span class="bg-white shadow-sm" aria-hidden="true"></span>
            <span class="sr-only">Estado</span>
        </label>
    </div>
    <div class="text-sm text-slate-400 italic ml-2" x-text="checked ? 'on' : 'off'">
    </div>
</div>