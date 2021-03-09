<!--=====================================
PÁGINA DE INICIO
======================================-->

<!-- content-wrapper -->
<div class="content-wrapper">

  <!-- content-header -->
  <section class="content-header">
    
    <h1>
    SERVICIO
    <small>TECNICO</small>
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Servicio Tecnico</li>

    </ol>

  </section>
  <!-- content-header -->

  <!-- content -->
  <section class="content">
    
    <!-- row -->
    <div class="row">

       <?php


        include "tecnico/cajas-superiores.php";

      
      ?>

    </div>
    <!-- row -->

    <!-- row -->
    <div class="row">

       <div class="col-lg-12">

        <?php

         include "tecnico/cajas-medias.php";

        ?>

      </div>

    </div>
    <!-- row -->


    <!-- row TECNICOS AÑADIR Y MAS -->
    <div class="row">

       <div class="col-lg-12">

        <?php

         include "tecnico/tecnicos.php";

        ?>

      </div>

    </div>
    <!-- row -->


 </section>
  <!-- content -->

</div>
<!-- content-wrapper -->

<script type="text/javascript">

$(".TareasNoLeidasclick").on("click", function(){

  var myVar = 0;
  myVar = setInterval(ciclo, 5000);

  $('.close').blur(function () {

    clearInterval(myVar);

  });

})


function ciclo (){

 $.get("ajax/tarea.ajax.php?verTareasNoleidas=1", function( data ) {

    const tarea = JSON.parse(data);
    console.log(data);

    if (tarea.success==true) {

      //console.log("actualizado exitosamente")

      tarea.registro.map((columna)=>{
        //console.log(columna)
        $( "#bodytable" ).append('<tr role="row" class="odd task'+columna.id+'">'+
                '<td class="sorting_1">'+columna.key+'</td>'+
                '<td>'+columna.tipo+'</td>'+
                '<td>'+columna.id_admin+'</td>'+
                '<td>'+columna.descripcion+'</td>'+
                '<td>'+
                  '<div class="btn-group"><button class="btn btn-danger btnCancelarTarea idtarea="'+columna.id+'"><i class="fa fa-times"></i></button></div>'+
                '</td>'+
              '</tr>');
        //$("#bodytable").hide().appendTo("<tr><td>"+columna.titulo+"</td><td>"+columna.mensaje+"</td><td>"+columna.desde+"</td></tr>").show('normal');

      })

    }
    else{
      console.log("no hay datos "+tarea.success)
       //$( "#bodytable" ).append('<tr role="row" class="odd"> <td class="sorting_1" colspan="6">No hay Datos</td>  </tr>')
    }

  });

} 
 

</script>

  