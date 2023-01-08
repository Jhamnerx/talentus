<div class="mb-12 space-y-4 py-10 xl:py-2">

    <form autocomplete="off" autocapitalize="on" autocapitalize="characters">
        <div class="pt-2 relative mx-auto text-gray-600">
            <div class="d-flex justify-content-center h-100">
                <div class="search box-border w-full bg-white">
                    <input wire:model="codigo" id="codigo" autocapitalize="on"
                        class=" border-2 w-full border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                        type="text" name="" placeholder="C-22-02">
                    <div class="absolute inset-0 leading-10 left-auto flex items-center">
                        <button wire:click.prevent="SearchCertificado()" class="search_icon"><i
                                class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex w-full">
            <div class="flex w-2/4">
                @error('codigo')

                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{$message}}
                </p>
                @enderror
            </div>

        </div>

    </form>
</div>

@push('scripts')
<script>
    $( document ).ready(function() {

        $('#codigo').caseEnforcer('uppercase');
    });

</script>

@endpush
