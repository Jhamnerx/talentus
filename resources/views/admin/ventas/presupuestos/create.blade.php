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
        {!! Form::open(['route' => 'admin.ventas.presupuestos.store']) !!}
        <div class="grid grid-cols-12 gap-2">


            <div class="col-span-12 md:col-span-6 border-dashed lg:border-r-2 border-talentus-100 pr-4">
                {{-- CLIENTE --}}
                <div class="col-span-12 sm:col-span-6 mb-5">
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Cliente <span class="text-sm text-red-500"> * </span></div>
                    </label>

                    {{-- <input class="form-input w-full" type="text" name="cliente" id="clienteSearch" /> --}}

                    @livewire('admin.ventas.presupuestos.select')

                    {{-- NUMERO --}}
                    <div class="col-span-12 sm:col-span-6 mb-5">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Número de Presupuesto <span class="text-sm text-red-500"> * </span></div>
                        </label>
                        <div class="relative">
                            <input required name="numero_presupuesto" id="numero_presupuesto" class="form-input w-full valid:border-emerald-300
                            required:border-rose-300 invalid:border-rose-300 peer pl-12" type="text" />
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
                                <input name="fecha" type="text"
                                    class="form-input valid:border-emerald-300
                            required:border-rose-300 invalid:border-rose-300 peer fechaPresupuesto inputDate font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block sm:text-sm border-gray-200 rounded-md text-black input w-full"
                                    placeholder="Selecciona la fecha">
                            </div>
                        </div>
                        <!-- ... -->
                        {{-- FECHA CADUCIDAD--}}
                        <div class="col-span-6">
                            <label
                                class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                <div>Fecha de caducidad <span class="text-sm text-red-500" style="display: none;"> *
                                    </span>
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
                                <input name="fecha_caducidad" type="text"
                                    class="form-input valid:border-emerald-300
                            required:border-rose-300 invalid:border-rose-300 peer inputDate font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block w-full sm:text-sm border-gray-200 rounded-md text-black input dark:focus:border-blue-500"
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

                            <select name="divisa" id="moneda" class="form-select" x-model="divisa"
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
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800">Precio/Unidad</span>
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

                            <input type="hidden" name="item.name[]" x-model="presupuesto.name">

                        </div>

                        <div class="px-2 w-20 text-right" style="width: 10%; min-width: 120px;">

                            <p class="text-gray-800" x-text="presupuesto.qty"></p>
                            <input type="hidden" name="item.cantidad[]" x-model="presupuesto.qty">
                        </div>

                        <div class="px-2 w-32 text-right" style="width: 15%; min-width: 120px;">
                            <p class="text-gray-800" x-text="numberFormat(presupuesto.rate)"></p>
                            <input type="hidden" name="item.precio[]" x-model="numberFormat(presupuesto.rate)">
                        </div>

                        <div class="px-1 w-32 text-right" style="width: 15%; min-width: 120px;">
                            <p class="text-gray-800" x-text="numberFormat(presupuesto.total)"></p>
                            <input type="hidden" name="item.total[]" x-model="presupuesto.total">
                        </div>

                        <div class="px-1 w-20 text-right">
                            <a href="#" class="text-red-500 hover:text-red-600 text-sm font-semibold"
                                @click.prevent="deleteItem(presupuesto.id)">Eliminar</a>
                        </div>
                    </div>
                </template>
                <button
                    class="mt-6 bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 text-sm border border-gray-300 rounded shadow-sm"
                    x-on:click.prevent="openModal = !openModal">
                    Añadir Item
                </button>
                <div class="py-2 ml-auto mt-5 w-full sm:w-2/4 lg:w-1/4">
                    <div class="flex justify-between mb-3">
                        <div class="text-gray-800 text-right flex-1">Total incl. IGV</div>
                        <div class="text-right w-40">
                            <div class="text-gray-800 font-medium" x-html="netTotal"></div>
                            <input type="hidden" x-model="netTotal" name="total">
                        </div>
                    </div>
                    <div class="flex justify-between mb-4">
                        <div class="text-sm text-gray-600 text-right flex-1">IGV(18%) incl. en Total</div>
                        <div class="text-right w-40">
                            <div class="text-sm text-gray-600" x-html="totalIGV"></div>
                            <input type="hidden" x-model="totalIGV" name="impuesto">
                        </div>
                    </div>

                    <div class="py-2 border-t border-b">
                        <div class="flex justify-between">
                            <div class="text-xl text-gray-600 text-right flex-1">Monto Total</div>
                            <div class="text-right w-40">
                                <div class="text-xl text-gray-800 font-bold" x-html="netTotal"></div>
                                <input type="hidden" x-model="netTotal" name="total_venta">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 text-right sm:px-6">
            {!! Form::submit('GUARDAR', ['class' => 'btn bg-emerald-500 hover:bg-emerald-600 focus:outline-none
            focus:ring-2 focus:ring-offset-2
            focus:ring-emerald-600 text-white']) !!}

        </div>
        {!! Form::close() !!}

        <!-- Modal -->
        <div style="background-color: rgba(0, 0, 0, 0.8)" class="fixed z-40 top-0 right-0 left-0 bottom-0 h-full w-full"
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
                            <input name="cantidad" min="0" step="1"
                                class="text-right mb-1 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                id="inline-full-name" type="number" min="0" step="any" x-model="item.qty">
                        </div>

                        <div class="mb-4 w-32 mr-2">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide v-money3">Precio
                                Unitario</label>
                            <input name="precio" min="0"
                                class="text-right mb-1 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                id="inline-full-name" type="number" x-model="item.rate">
                        </div>

                        <div class="mb-4 w-32">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Total</label>
                            <input name="total" disabled
                                class="text-right mb-1 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                id="inline-full-name" type="text" x-model="item.total=item.qty*item.rate">
                        </div>
                    </div>

                    <div class="mb-4 w-32">
                        <div class="relative">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">IGV</label>
                            <select
                                class="text-gray-700 block appearance-none w-full bg-gray-200 border-2 border-gray-200 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                x-model="item.igv">
                                <option selected value="18">IGV 18%</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                <svg class="fill-current h-4 w-4 mt-6" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
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






</div>



@stop
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
    function select(config) {
            return {

                data: config.data,

                emptyOptionsMessage: 'No hay resultados.',

                focusedOptionIndex: null,

                name: 'clientes',

                name: config.name,

                open: false,
                selected: 0,

                options: {},

                placeholder: config.placeholder ?? 'Selecciona una opcion',

                search: '',

                value: config.value,

                closeListbox: function () {
                    this.open = false

                    this.focusedOptionIndex = null

                    this.search = ''
                },

                focusNextOption: function () {
                    if (this.focusedOptionIndex === null) return this.focusedOptionIndex = Object.keys(this.options).length - 1

                    if (this.focusedOptionIndex + 1 >= Object.keys(this.options).length) return

                    this.focusedOptionIndex++

                    this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                        block: "center",
                    })
                },

                focusPreviousOption: function () {
                    if (this.focusedOptionIndex === null) return this.focusedOptionIndex = 0

                    if (this.focusedOptionIndex <= 0) return

                    this.focusedOptionIndex--

                    this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                        block: "center",
                    })
                },

                init: function () {

                    this.options = this.data

                    //console.log(this.data);

                    if (!(this.value in this.options)) this.value = null

                    this.$watch('search', ((value) => {
                        if (!this.open || !value) return this.options = this.data

                        this.options = Object.keys(this.data)
                            .filter((key) => this.data[key].toLowerCase().includes(value.toLowerCase()))
                            .reduce((options, key) => {
                                options[key] = this.data[key]
                                return options
                            }, {})
                    }))
                    

                },

                selectOption: function () {

                    if (!this.open) return this.toggleListboxVisibility()

                    this.value = Object.keys(this.options)[this.focusedOptionIndex]
                    console.log(this.value);
                    this.selected = this.value;
                    this.closeListbox()
                },

                toggleListboxVisibility: function () {
                    if (this.open) return this.closeListbox()

                    this.focusedOptionIndex = Object.keys(this.options).indexOf(this.value)

                    if (this.focusedOptionIndex < 0) this.focusedOptionIndex = 0

                    this.open = true

                    this.$nextTick(() => {
                        this.$refs.search.focus()

                        this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                            block: "center"
                        })
                    })
                },
            }
    }
</script>




@endsection