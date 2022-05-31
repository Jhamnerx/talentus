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

<div class="p-6 shadow overflow-hidden sm:rounded-md">



    @livewire('admin.ventas.presupuestos.save')






</div>



@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
    integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>




<script>
    var tipoCambio = parseFloat($(".tipoCambio").text());

    $("#money").maskMoney();    
    // FUNCION PARA CAMBIAR DATOS Y DIVISA
    function cambiarDivisa(e){

        calculate_totales(e)

    };


    // INICIALIZAR LOS INPUTS DE FECHA
    $( document ).ready(function() {
        cont=0;
        detalles=0;
        flatpickr('.fechaPresupuesto', {
            mode: 'single',
            defaultDate: "today",
            minDate: "today",
            disableMobile: "true",
            dateFormat: "Y-m-d",
            prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
            nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
        });  
        flatpickr('.fechaFinPresupuesto', {
            mode: 'single',
            defaultDate: new Date().fp_incr(14),
            minDate: "today",
            disableMobile: "true",
            dateFormat: "Y-m-d",
            prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
            nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
        });  
    })


    $('.clientes_id').select2({
       placeholder: 'Buscar Cliente',
        language: "es",
        minimumInputLength: 2,
        width: '100%',
        ajax: {
            url: '{{route("search.clientes")}}',
            dataType: 'json',
            delay: 250,
            cache: true,
            data: function (params) {

                var query = {
                    term: params.term,
                    //type: 'public'
                }

                // Query parameters will be ?search=[term]&type=public
                return query;
            },
            processResults: function (data, params) {

               // console.log(data.suggestions);
                var suggestions = $.map(data.suggestions, function (obj) {

                    obj.id = obj.id || obj.data; // replace pk with your identifier
                    obj.text = obj.value; // replace pk with your identifier

                    return obj;

                });
                //console.log(data);
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {

                    results: suggestions,
    
                };
                
            },


        }
    });

    $('.productoSelect').select2({
        placeholder: 'Añadir Artículo',
        language: "es",
        width: '100%',
        ajax: {
            url: '{{route("search.productos")}}',
            dataType: 'json',
            delay: 250,
            cache: true,
            data: function (params) {

                var query = {
                    term: params.term,
                    //type: 'public'
                }

                // Query parameters will be ?search=[term]&type=public
                return query;
            },
            processResults: function (data, params) {

               // console.log(data.suggestions);
                var suggestions = $.map(data.suggestions, function (obj) {

                    obj.id = obj.id || obj.data; // replace pk with your identifier
                    obj.text = obj.value; // replace pk with your identifier

                    return obj;

                });
                //console.log(data);
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {

                    results: suggestions,
    
                };
                
            },


        }
    });

    // funcion para colocar los datos del producto seleccionado
    // a los inputs
    $('.productoSelect').on('select2:select', function (e) {

        var data = e.params.data;
        enviarDatosProductos(data);
        $('.errorDescripcion').addClass('hidden');
        $('.errorPrecio').addClass('hidden');

    });

    // colocar los datos
    function enviarDatosProductos(data){
       //console.log(data);
        $('.descripcion').val(data.text);
        $('.importe').val(data.precio);
       // $('.cantidad').val(cantidad.precio);

        let divisa = $(".divisa option:selected").text();
        
        calculate_total(divisa)
    }

    function add_item_to_table(){

        let divisa = $(".divisa option:selected").text();
        var descripcion = $('.descripcion').val();
        var cantidad = $('.qyt').val();
        var precio = $('.importe').val();

        var fila = '<tr id="fila'+cont+'">'+
                '<td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">'+
                    '<textarea required name="items['+cont+'][producto]" class="form-input" rows="5">'+descripcion+'</textarea>'+
                '</td>'+
                '<td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">'+
                   '<input required type="number" name="items['+cont+'][cantidad]" min="0" value="'+cantidad+'" class="form-input cantidad" placeholder="Cantidad" value="2">'+
                '</td>'+
                '<td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">'+
                    '<input required type="number" min="0" data-quantity="" step="0.01" name="items['+cont+'][precio]" value="'+precio+'" class="form-input precio">'+
                '</td>'+
                '<td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">'+
                    '<input type="number" value="00.00" name="items['+cont+'][importe]" class="form-input importe subtotal" readonly>'+
                '</td>'+
                '<td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">'+
                    '<div class="space-x-1">'+
                        '<button type="button" @click.prevent="eliminarDetalle('+cont+')"  class="text-rose-500 hover:text-rose-600 rounded-full">'+
                            '<span class="sr-only">Delete</span>'+
                            '<svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">'+
                                '<path d="M13 15h2v6h-2zM17 15h2v6h-2z" />'+
                                '<path d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />'+
                            '</svg>'+
                        '</button>'+
                    '</div>'+
                '</td>'+
            '</tr>';
        


        if(descripcion && precio){
            //console.log('enviar tabla');
            cont++;
            detalles=detalles+1;
            $('.errorDescripcion').addClass('hidden');
            $('.errorPrecio').addClass('hidden');
            $('.listaItems').append(fila);

            $('.descripcion').val("");
            $('.qyt').val(1);
            $('.importe').val(0);
            addAlert();
            calculate_total(divisa)

        }else{
            $('.errorDescripcion').removeClass('hidden');
            $('.errorPrecio').removeClass('hidden');
        }







    }


    function calculate_total(divisa = "PEN"){

        var cant = $(".cantidad");
        var prec = $(".precio");
        var sub = $(".subtotal");


        //console.log(cant);
        for (var i = 0; i <cant.length; i++) {

            var inpC=cant[i];
            var inpP=prec[i];
            var inpS=sub[i];

            inpS.value=(inpC.value * inpP.value).toFixed(2);
            
           $(".subtotal")[i].innerHTML = parseFloat(inpS.value);
          // console.log(parseFloat(inpS.value));
        }
        calculate_totales(divisa);
    }

    function getDivisa(){

       // return $(".divisa option:selected").text();
        return parseFloat($(".tipoCambio").text());

    }


    function calculate_totales(divisa = "PEN"){

        var subTotal = $(".subtotal");
        //console.log(divisa);
       // var divisa = $(".divisa option:selected").text();

        /**
         * MOSTRAS SIMBOLO SEGUN DIVISA
         */


        var total =0;

        for (var i = 0; i <subTotal.length; i++) {

           // console.log(total);
            total += parseFloat($(".subtotal")[i].value);

            

        }

        // var divisa = cambiarDivisa();
        var simbolo = "S/."

        if (divisa === "PEN") {

            simbolo = "S/.";

            igvTotal = calcularIgv(total);

            totalPresupuesto = total + igvTotal;

            $(".total").html(simbolo + " "+ numeral(total).format('0,0.00'));



            $('.igv').html(simbolo + " "+numeral(igvTotal).format('0,0.00'))
            $('.totalPresupuesto').html(simbolo + " "+numeral(totalPresupuesto).format('0,0.00'));


            // ENVIAR DATOS DE TOTAL A INPUTS
            $(".subTotalPropuesto").val(numeral(total).format('0.00'));
            $(".impuestoPropuesto").val(numeral(igvTotal).format('0.00'));
            $(".totalPropuesto").val(numeral(totalPresupuesto).format('0.00'));

        }else if(divisa == "USD"){

            simbolo = "$";
           
            igvTotal = calcularIgv(total);

            totalPresupuesto = total + igvTotal;

            $(".total").html(simbolo + " "+ numeral(total).format('0,0.00'));
            $('.igv').html(simbolo + " "+numeral(igvTotal).format('0,0.00'))
            $('.totalPresupuesto').html(simbolo + " "+numeral(totalPresupuesto).format('0,0.00'));
            
            // ENVIAR DATOS DE TOTAL A INPUTS
            $(".subTotalPropuesto").val(numeral(total).format('0.00'));
            $(".impuestoPropuesto").val(numeral(igvTotal).format('0.00'));
            $(".totalPropuesto").val(numeral(totalPresupuesto).format('0.00'));

        }




    // evaluarGuardarVenta();
    }


    function calcularIgv(monto){

        igv = (parseFloat(monto)*18)/100;

        return igv;
    }

    $(document).on("change", ".listaItems .cantidad", function(){
        let divisa = $(".divisa option:selected").text();
        calculate_total(divisa);

    })
    $(document).on("change", ".listaItems .precio", function(){
        let divisa = $(".divisa option:selected").text();
        calculate_total(divisa);

    })


    function eliminarDetalle(indice){
        detalles=detalles-1;
        let divisa = $(".divisa option:selected").text();
        $("#fila" + indice).remove();
        calculate_total(divisa);
    }



    function addAlert(){
        iziToast.success({
            position: 'topRight',
            title: 'AGREGADO',
            message: 'Se añadio un producto al presupuesto',
        });
    }

    function evaluarGuardarPresupuesto(){

        //console.log(detalles);
        if (detalles>0)
        {
            $(".guardarPresupuesto").addClass('disabled');
        }
        else
        {
            $(".guardarPresupuesto").removeClass('disabled'); 
            cont=0;
        }
    }
</script>


<script>
    $('.formularioPresupuesto').submit(function(e){
        e.preventDefault();
        $(".vacio").addClass('hidden');
        if(detalles >0){
            this.submit();
            
        }else{
           $(".vacio").removeClass('hidden');
        }
    })

</script>


@endsection