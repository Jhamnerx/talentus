@extends('layouts.admin')
@section('ruta', 'ventas-presupuestos')
@section('contenido')
<!-- Code block starts -->
<div
    class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
    <!-- Add customer button -->
    <a href="{{route('admin.ventas.presupuestos.index')}}">
        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back w-5 h-5"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
            </svg>
            <span class="hidden xs:block ml-2">Atras</span>
        </button>
    </a>
    <div>
        <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">CREAR PRESUPUESTO</h4>
        <ul aria-label="current Status"
            class="flex flex-col md:flex-row items-start md:items-center text-gray-600 dark:text-gray-400 text-sm mt-3">
            <li class="flex items-center mr-4">
                <div class="mr-1">
                    <img class="dark:hidden"
                        src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_with_sub_text_and_border-svg1.svg"
                        alt="Active">
                    <img class="dark:block hidden"
                        src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_with_sub_text_and_border-svg1dark.svg"
                        alt="Active">
                </div>
                <span>Active</span>
            </li>

        </ul>
    </div>
</div>
<!-- Code block ends -->
<div class="p-6 shadow overflow-hidden sm:rounded-md" x-data="presupuesto()"
    x-init="generatepresupuestoNumber(111111, 999999);" x-cloak>
    <div class="px-4 py-2 bg-gray-50 sm:p-6">

        <div class="grid grid-cols-12 gap-2">


            <div class="col-span-12 md:col-span-6 border-dashed lg:border-r-2 border-talentus-100 pr-4">
                {{-- CLIENTE --}}
                <div class="col-span-12 sm:col-span-6 mb-5">
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Cliente <span class="text-sm text-red-500"> * </span></div>
                    </label>
                    {{-- <input class="form-input w-full" type="text" name="cliente" id="clienteSearch" /> --}}
                    <div x-data="selectConfigs()" x-init="fetchOptions()" class="flex flex-col items-center relative">
                        <div class="w-full">
                            <div @click.away="close()" class="my-2 p-1 bg-white flex border border-gray-200 rounded">
                                <input x-model="filter" x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    @mousedown="open()" @keydown.enter.stop.prevent="selectOption()"
                                    @keydown.arrow-up.prevent="focusPrevOption()"
                                    @keydown.arrow-down.prevent="focusNextOption()"
                                    class="p-1 px-2 appearance-none outline-none w-full text-gray-800 clienteId">
                                <div
                                    class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200">
                                    <button @click="toggle()"
                                        class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline x-show="!isOpen()" points="18 15 12 20 6 15"></polyline>
                                            <polyline x-show="isOpen()" points="18 15 12 9 6 15"></polyline>
                                        </svg>

                                    </button>
                                </div>
                            </div>
                        </div>
                        <div x-show="isOpen()"
                            class="absolute shadow bg-white top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj">
                            <div class="flex flex-col w-full">
                                <template x-for="(option, index) in filteredOptions()" :key="index">
                                    <div @click="onOptionClick(index)" :aria-selected="focusedOptionIndex === index">
                                        <div
                                            class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                                            <div class="w-6 flex flex-col items-center">
                                                <div
                                                    class="flex relative w-5 h-5 bg-orange-500 justify-center items-center m-1 mr-2 w-4 h-4 mt-1 rounded-full ">
                                                    <img class="rounded-full" alt="A"
                                                        x-bind:src="option.picture.thumbnail">
                                                </div>
                                            </div>
                                            <div class="w-full items-center flex">
                                                <div class="mx-2 -mt-1"><span x-text="option.razon_social"></span>
                                                    <div class="text-xs truncate w-full normal-case font-normal -mt-1 text-gray-500"
                                                        x-text="option.email"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- NUMERO --}}
                <div class="col-span-12 sm:col-span-6 mb-5">
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Número de Presupuesto <span class="text-sm text-red-500"> * </span></div>
                    </label>
                    <div class="relative">
                        <input id="numero_presupuesto" class="form-input w-full pl-12" type="text" />
                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                            <span class="text-sm text-slate-400 font-medium px-3">PRE-</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-4">
                    {{-- FECHA PRESUPUESTO--}}
                    <div class="col-span-6">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Fecha presupuesto <span class="text-sm text-red-500"> * </span></div>
                            <!---->
                            <!---->
                        </label>
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text"
                                class="fechaPresupuesto inputDate font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block w-full sm:text-sm border-gray-200 rounded-md text-black form-control input"
                                placeholder="Selecciona la fecha">
                        </div>
                    </div>
                    <!-- ... -->
                    {{-- FECHA CADUCIDAD--}}
                    <div class="col-span-6">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Fecha de caducidad <span class="text-sm text-red-500" style="display: none;"> * </span>
                            </div>
                            <!---->
                            <!---->
                        </label>
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text"
                                class="inputDate font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block w-full sm:text-sm border-gray-200 rounded-md text-black form-control input dark:focus:border-blue-500"
                                placeholder="Selecciona la fecha">
                        </div>
                    </div>
                </div>


            </div>





            <div class="col-span-12 md:col-span-6 border-red-600 lg:pl-6">
                <div class="grid grid-cols-12 gap-4">
                    {{-- moneda--}}
                    <div class="col-span-6">
                        <label class="block text-sm font-medium mb-1 text-gray-800">Tipo de Cambio:
                            <span class="text-rose-500" x-text="tipoCambio"></span> </label>
                        <label class="text-gray-800 block text-sm font-medium mb-1" for="moneda">Moneda
                            <span class="text-rose-500">*</span> </label>

                        <select id="moneda" class="form-select" x-model="divisa"
                            @change="changeCurrency($event.target.value)">
                            <option value="PEN">PEN</option>
                            <option value="USD">USD</option>
                        </select>

                        <input x-model="tipoCambio" x-init="tipoCambio = {{$tipoCambio}}" type="hidden"
                            value="{{$tipoCambio}}">



                    </div>

                    <div class="col-span-12">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Nota
                            </div>
                            <!---->
                            <!---->
                        </label>
                        <textarea class="form-input w-full px-4 py-3" name="nota" id="" cols="30" rows="5"
                            placeholder="Ingresar nota (opcional)"></textarea>
                    </div>
                    <!-- ... -->

                </div>

            </div>





        </div>

        <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3">
            <div class="flex -mx-1 border-b py-2 items-start">
                <div class="flex-1 px-1" style="width: 40%; min-width: 280px;">
                    <p class="text-gray-800 uppercase tracking-wide text-sm font-bold">Descripcion</p>
                </div>

                <div class="px-2 w-20 text-center" style="width: 10%; min-width: 120px;">
                    <p class="text-gray-800 uppercase tracking-wide text-sm font-bold">Cantidad</p>
                </div>

                <div class="px-2 w-32 text-right" style="width: 15%; min-width: 120px;">
                    <p class="leading-none">
                        <span class="block uppercase tracking-wide text-sm font-bold text-gray-800">Precio/Unidad</span>
                        <span class="font-medium text-xs text-gray-500">(Incl. IGV)</span>
                    </p>
                </div>

                <div class="px-1 w-32 text-right" style="width: 15%; min-width: 120px;">
                    <p class="leading-none">
                        <span class="block uppercase tracking-wide text-sm font-bold text-gray-800">Total</span>
                        <span class="font-medium text-xs text-gray-500">(Incl. IGV)</span>
                    </p>
                </div>

                <div class="px-1 w-20 text-center">
                </div>
            </div>
            <template x-for="presupuesto in items" :key="presupuesto.id">
                <div class="flex -mx-1 px-2 py-4 border-b box-border ">
                    <div class="flex-1 px-1" style="width: 40%; min-width: 280px;">
                        <p class="text-gray-800" x-text="presupuesto.name"></p>

                    </div>

                    <div class="px-2 w-20 text-right" style="width: 10%; min-width: 120px;">

                        <p class="text-gray-800" x-text="presupuesto.qty"></p>
                    </div>

                    <div class="px-2 w-32 text-right" style="width: 15%; min-width: 120px;">
                        <p class="text-gray-800" x-text="numberFormat(presupuesto.rate)"></p>
                    </div>

                    <div class="px-1 w-32 text-right" style="width: 15%; min-width: 120px;">
                        <p class="text-gray-800" x-text="numberFormat(presupuesto.total)"></p>
                    </div>

                    <div class="px-1 w-20 text-right">
                        <a href="#" class="text-red-500 hover:text-red-600 text-sm font-semibold"
                            @click.prevent="deleteItem(presupuesto.id)">Eliminar</a>
                    </div>
                </div>
            </template>
            <button
                class="mt-6 bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 text-sm border border-gray-300 rounded shadow-sm"
                x-on:click="openModal = !openModal">
                Añadir Item
            </button>
            <div class="py-2 ml-auto mt-5 w-full sm:w-2/4 lg:w-1/4">
                <div class="flex justify-between mb-3">
                    <div class="text-gray-800 text-right flex-1">Total incl. IGV</div>
                    <div class="text-right w-40">
                        <div class="text-gray-800 font-medium" x-html="netTotal"></div>
                    </div>
                </div>
                <div class="flex justify-between mb-4">
                    <div class="text-sm text-gray-600 text-right flex-1">IGV(18%) incl. en Total</div>
                    <div class="text-right w-40">
                        <div class="text-sm text-gray-600" x-html="totalIGV"></div>
                    </div>
                </div>

                <div class="py-2 border-t border-b">
                    <div class="flex justify-between">
                        <div class="text-xl text-gray-600 text-right flex-1">Monto Total</div>
                        <div class="text-right w-40">
                            <div class="text-xl text-gray-800 font-bold" x-html="netTotal"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div style=" background-color: rgba(0, 0, 0, 0.8)" class="fixed z-40 top-0 right-0 left-0 bottom-0 h-full w-full"
        x-show.transition.opacity="openModal">
        <div class="p-4 max-w-xl mx-auto relative left-0 right-0 overflow-hidden mt-24">
            <div class="shadow absolute right-0 top-0 w-10 h-10 rounded-full bg-white text-gray-500 hover:text-gray-800 inline-flex items-center justify-center cursor-pointer"
                x-on:click="openModal = !openModal">
                <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                </svg>
            </div>

            <div class="shadow rounded-lg bg-white overflow-hidden w-full block p-8">

                <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">Ingresa el producto</h2>

                <div class="mb-4">
                    <label
                        class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Descripción</label>
                    <input name="producto"
                        class="mb-1 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                        id="inline-full-name" type="text" x-model="item.name">
                </div>

                <div class="flex">
                    <div class="mb-4 w-32 mr-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Cantidad</label>
                        <input name="cantidad"
                            class="text-right mb-1 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            id="inline-full-name" type="number" min="0" step="any" x-model="item.qty">
                    </div>

                    <div class="mb-4 w-32 mr-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide v-money3">Precio
                            Unitario</label>
                        <input id="money" name="precio"
                            class="text-right mb-1 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            id="inline-full-name" type="number" x-model="item.rate">
                    </div>

                    <div class="mb-4 w-32">
                        <label class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Total</label>
                        <input name="total"
                            class="text-right mb-1 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            id="inline-full-name" type="text" x-model="item.total=item.qty*item.rate">
                    </div>
                </div>

                <div class="mb-4 w-32">
                    <div class="relative">
                        <label class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">IGV</label>
                        <select
                            class="text-gray-700 block appearance-none w-full bg-gray-200 border-2 border-gray-200 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            x-model="item.igv">
                            <option selected value="18">IGV 18%</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                            <svg class="fill-current h-4 w-4 mt-6" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-right">
                    <button type="button"
                        class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 border border-gray-300 rounded shadow-sm mr-2"
                        @click="openModal = !openModal">
                        Cancelar
                    </button>
                    <button type="button"
                        class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded shadow-sm"
                        @click="addItem()">
                        Añadir
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal -->

</div>



<div class="px-4 py-3 text-right sm:px-6">

    <button class="btn bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2
                                                            focus:ring-emerald-600 text-white">GUARDAR</button>
</div>


</div>





@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
    integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    $("#money").maskMoney();
    function presupuesto() {
    			return {
    				items: [],
    				presupuestoNumber: 0,
                    divisa: "PEN",
                    tipoCambio: '',
    				presupuestoDate: '',
    				presupuestoDueDate: '',
    
    				totalIGV: 0,
    				netTotal: 0,
    
    				item: {
    					id: '',
    					name: '',
    					qty: 0,
    					rate: 0,
    					total: 0,
    					igv: 18
    				},
    
    				billing: {
    					name: '',
    					address: '',
    					extra: ''
    				},
    				from: {
    					name: '',
    					address: '',
    					extra: ''
    				},
    
    				showTooltip: false,
    				openModal: false,
    
    				addItem() {
    					this.items.push({
    						id: this.generateUUID(),
    						name: this.item.name,
    						qty: this.item.qty,
    						rate: this.item.rate,
    						igv: this.calculateIGV(this.item.igv, this.item.rate),
    						total: this.item.qty * this.item.rate
    					})
    
    					this.itemSubTotal();
    					this.itemTotalIGV();
    
    					this.item.id = '';
    					this.item.name = '';
    					this.item.qty = 0;
    					this.item.rate = 0;
    					this.item.igv = 18;
    					this.item.total = 0;
    				},
                    changeCurrency(currency){
    					this.itemSubTotal();
    					this.itemTotalIGV();

                    },
    
    				deleteItem(uuid) {
    					this.items = this.items.filter(item => uuid !== item.id);
    					this.itemSubTotal();
    					this.itemTotalIGV();
    				},
    
    				itemSubTotal() {

                        this.netTotal = this.numberFormat(this.items.length > 0 ? this.items.reduce((result, item) => {
                            return result + item.total;
                        }, 0) : 0);


    				},
    
    				itemTotalIGV() {
                        this.totalIGV =  this.numberFormat(this.items.length > 0 ? this.items.reduce((result, item) => {
    						return result + (item.igv * item.qty);
    					}, 0) : 0);
    				},
    
    				calculateIGV(IGVPercentage, itemRate) {

                        return this.numberFormat((itemRate - (itemRate * (100 / (100 + IGVPercentage)))).toFixed(2));
    		
    				},
    
    				generateUUID() {
    					return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    						var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    						return v.toString(16);
    					});
    				},
    
    				generatepresupuestoNumber(minimum, maximum) {
    					const randomNumber = Math.floor(Math.random() * (maximum - minimum)) + minimum;
    					this.presupuestoNumber = '#FACT-'+ randomNumber;
    				},
    
    				numberFormat(amount) {
                        return amount.toLocaleString("es-ES", {
                            style: "currency",
                            currencyDisplay: "symbol",
                            currency: this.divisa
                        });
                    
    				},
    
    			}
    		}
</script>
<script>
    function selectConfigs() {
    return {
        filter: '',
        show: false,
        selected: null,
        focusedOptionIndex: null,
        options: null,
        close() {
            this.show = false;
            this.filter = this.selectedName();
            this.focusedOptionIndex = this.selected ? this.focusedOptionIndex : null;
        },
        open() {
            this.show = true;
            this.filter = '';
        },
        toggle() {
            if (this.show) {
                this.close();
            } else {
                this.open()
            }
        },
        isOpen() {
            return this.show === true
        },
        selectedName() {
            return this.selected ? this.selected.razon_social + ' ' + this.selected.numero_documento : this.filter;
        },
        classOption(id, index) {
            const isFocused = (index == this.focusedOptionIndex);
            return {
                'cursor-pointer w-full border-gray-100 border-b hover:bg-blue-50': true,
                'bg-blue-50': isFocused
            };
        },
        fetchOptions() {
            fetch('{{route("search.clientes")}}')
                .then(response => response.json())
                .then(data => this.options = data);
                
        },
        filteredOptions() {
            return this.options ?
                this.options.results.filter(option => {
                    return (option.razon_social.toLowerCase().indexOf(this.filter) > -1) ||
                        (option.numero_documento.toLowerCase().indexOf(this.filter) > -1) ||
                        (option.telefono.toLowerCase().indexOf(this.filter) > -1)
                }) :
                {}
        },
        onOptionClick(index) {
            this.focusedOptionIndex = index;
            this.selectOption();
        },
        selectOption() {
            if (!this.isOpen()) {
                return;
            }
            this.focusedOptionIndex = this.focusedOptionIndex ?? 0;
            const selected = this.filteredOptions()[this.focusedOptionIndex]

                this.selected = selected;
                this.filter = this.selectedName();

            this.close();
        },
        focusPrevOption() {
            if (!this.isOpen()) {
                return;
            }
            const optionsNum = Object.keys(this.filteredOptions()).length - 1;
            if (this.focusedOptionIndex > 0 && this.focusedOptionIndex <= optionsNum) {
                this.focusedOptionIndex--;
            } else if (this.focusedOptionIndex == 0) {
                this.focusedOptionIndex = optionsNum;
            }
        },
        focusNextOption() {
            const optionsNum = Object.keys(this.filteredOptions()).length - 1;
            if (!this.isOpen()) {
                this.open();
            }
            if (this.focusedOptionIndex == null || this.focusedOptionIndex == optionsNum) {
                this.focusedOptionIndex = 0;
            } else if (this.focusedOptionIndex >= 0 && this.focusedOptionIndex < optionsNum) {
                this.focusedOptionIndex++;
            }
        }
    }

}



// AUTOCOMPLETE CLIENTE
    // $("#clienteSearch").autocomplete({
    //     serviceUrl: '{{route("search.clientes")}}',

    //     minChars: 3,
    //     onSelect: function (suggestion) {

    //         console.log(suggestion.value);
    //         alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
    //     }
        
    //     source: function(request, response){
    //         $.ajax({
    //             url: '{{route("search.clientes")}}',
    //             dataType: 'json',
    //             data: {
    //                 term: request.term
    //             },
    //             success: function(data){
    //                 response(data);
    //                 console.log(data);
    //             }

    //         })
    //     }
    // })





</script>
@endsection