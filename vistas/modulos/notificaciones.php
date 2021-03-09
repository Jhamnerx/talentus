<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Notificaciones
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Almacen</a></li>

      <li class="active">Notificaciones</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
       
      <div class="box-header with-border">

      </div>

      <div class="box-body">

        <div class="table100 ver4 m-b-110">
            <table data-vertable="ver4">
                <thead>
                    <tr class="row100 head">
                        <th class="column100 column1" data-column="column1">#</th>
                        <th class="column100 column2" data-column="column2">Descripcion</th>
                    </tr>
                </thead>
                <tbody>

                        <?php


                            $notificaciones = ControladorNotificaciones::ctrMostrarNotificaciones(null, null);

                            //$totalNotificaciones = $notificaciones["nuevosUsuarios"] + $notificaciones["nuevasVentas"] + $notificaciones["nuevasVisitas"];

                            //var_dump($notificaciones);

                            foreach ($notificaciones as $key => $value) {

                                $cobros = ModeloCobros::mdlMostrarCobros("cobros", "id", $value["idCobro"]);
                                $fechaInicial = $cobros["fechaVen"];
                                $fechaFinal = date("Y/m/d");

                                $dias = Utiles::diferenciaFechas($fechaInicial, $fechaFinal);
                                //var_dump($dias);

                                // if ($dias < 0) {
                                //  $diasP =abs($dias);
                                //  echo "pasaron ".$diasP;
                                // }
                                if ($dias <= 0) {
                                  

                                  $notifi = ModeloNotificaciones::mdlActualizarNotificacion("notificaciones", "descripcion", "vencido", "id", $value["id"]);

                                }



                                /**
                                 * MOSTRAR NOTIFICACIONES EN CAMPANA
                                 */

                                if ($value["descripcion"] == "vencido") {


                                    echo '<tr class="row100 head">
                                                <td class="column100 column'.($key+1).'" data-column="column'.($key+1).'">'.($key+1).'</td>
                                                <td class="column100 column'.($key+1).'" data-column="column'.($key+1).'">El Plan de  '.$cobros["empresa"].' se encuentra vencido</td>
                                            </tr>';
                                }else{


                                    echo '<tr class="row100 head">
                                                <td class="column100 column'.($key+1).'" data-column="column'.($key+1).'">'.($key+1).'</td>
                                                <td class="column100 column'.($key+1).'" data-column="column'.($key+1).'">El Plan de  '.$cobros["empresa"].' Esta por vencer ('.$dias.' dias restantes)</td>
                                            </tr>';

                                }


                            }

                        ?>

                </tbody>
            </table>
        </div>
          
      </div>

    </div>

  </section>

</div>
