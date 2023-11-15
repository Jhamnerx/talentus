<div class="flex items-center mt-2" x-data="{ checkedf{{$model->id}}: {{$model->fondo ? 'true' : 'false'}} }">
    <span class="text-sm mr-3">Fondo: </span>
    <div class="form-switch">
        <input wire:model.live.blur="fondo" type="checkbox" id="switch-f{{$model->id}}" class="sr-only"
            x-model="checkedf{{$model->id}}" />
        <label class="bg-slate-400" for="switch-f{{$model->id}}">
            <span class="bg-white shadow-sm" aria-hidden="true"></span>
            <span class="sr-only">Fondo</span>
        </label>
    </div>
    <div class="text-sm text-slate-400 italic ml-2" x-text="checkedf{{$model->id}} ? 'ON' : 'OFF'"></div>
</div>