<div class="flex items-center" x-data="{ checkeds{{$model->id}}: {{$model->sello ? 'true' : 'false'}} }">
    <span class="text-sm mr-5">Sello: </span>
    <div class="form-switch">
        <input wire:model.lazy="sello" type="checkbox" id="switch-s{{$model->id}}" class="sr-only"
            x-model="checkeds{{$model->id}}" />
        <label class="bg-slate-400" for="switch-s{{$model->id}}">
            <span class="bg-white shadow-sm" aria-hidden="true"></span>
            <span class="sr-only">Sello</span>
        </label>
    </div>
    <div class="text-sm text-slate-400 italic ml-2" x-text="checkeds{{$model->id}} ? 'ON' : 'OFF'"></div>
</div>