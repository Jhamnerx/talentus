<div class="flex">
    <div class="relative flex items-start" variant="indigo">
        <div class="flex items-center h-5">
            <input name="{{ $name }}" wire:model.live='{{ $model }}' id="{{ $value }}"
                variant="indigo" type="checkbox"
                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500"
                value="{{ $value }}">
        </div>
        <div class="ml-3 text-sm">

            <label for="{{ $value }}" class="font-medium text-gray-600 cursor-pointer">

                {{ $label }}
            </label>

        </div>
    </div>
</div>
