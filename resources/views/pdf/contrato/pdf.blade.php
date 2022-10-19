<!DOCTYPE html>
<html>

<head>

    <title>CONTRATO {{ $contrato->clientes->razon_social }}</title>


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ asset('docs/contrato/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('docs/contrato/contrato.css') }}">
    {{ header('Content-type:application/pdf') }}


    <style type="text/css">
        /* -- Base -- */

        body:before {
            display: block;
            position: fixed;
            top: -65px;
            right: -28px;
            bottom: -84px;
            left: -82px;

            background-image: url(data:image/jpeg;base64, {{ base64_encode(file_get_contents('images/' . $fondo)) }});
            background-size: 100%;
            background-repeat: no-repeat;
            /* opacity: .2; */
            content: "";
            z-index: -1000;
        }
    </style>

</head>

@if ($contrato->fondo)

    <body>
    @else

        <body>
@endif



<div class="contrato">

    <section>
        <div>
            <h2 class="center-text ">
                <b>CONTRATO DE PRESTACIÓN DE SERVICIO.</b>
            </h2>

            <p>
                Conste por el presente documento, el contrato de prestación de servicio de rastreo y
                monitoreo satelital, que celebran de una parte <b>____(X)____</b>, con RUC N° ___(X), con domicilio
                fiscal en el Jr. ___(X)___, del distrito de __(X)__, provincia y departamento de ___(X)___, debidamente
                representada por su <b>Gerente General</b><b>___(X)___</b>, identificado con DNI N° <b>___(X)___</b>,
                con correo electrónico <b>___(X)___</b>, a quien en adelante se le denominará <b>“LA EMPRESA/EL
                    CLIENTE”;</b> y de la otra parte la <b>TALENTUS TECHNOLOGY EIRL (T Y T)</b>, con RUC N° 20496172168,
                debidamente representada por su <b>Titular Gerente, María Jhovana Centurión Torres</b>, identificada con
                DNI N° 40969356, con domicilio fiscal sito en el Jirón Santa María N° 209, Barrio Mollepampa, del
                distrito, provincia y departamento de Cajamarca, a quien en adelante se le denominará <b>“EL LOCADOR”;
                </b>contrato que se celebra en los términos y condiciones siguientes:
            </p>

            <h2 class="sutitulo">
                <b>
                    <u> Cláusula primera: Antecedentes</u><b>.</b>
                </b>

            </h2>

            <p>
                <b>1.1.- EL CLIENTE</b>
                requiere de una empresa especializada en servicios de rastreo y monitoreo satelital para la ubicación
                vehicular, control y supervisión de sus vehículos que prestan el servicio de transporte de mercaderías,
                pasajeros y/o servicios particulares.
            </p>

            <p>
                <b>1.2.- TALENTUS TECHNOLOGY E.I.R.L.</b>
                es una persona jurídica debidamente constituida, registrada y reconocida como tal, especializada en
                tecnología, con equipos de Tecnología GPS (Global Positioning System), homologados por el Ministerio de
                Transportes y Comunicaciones necesarios para el rastreo satelital que le permiten conocer la ubicación
                exacta en cualquier momento, siempre que se encuentre el móvil dentro del área de cobertura de alguno de
                los sistemas de comunicación inalámbrica que estos equipos utilizan para la transmisión de la
                información hacia la Central de Operaciones de<b>TALENTUS TECHNOLOGY E.I.R.L.</b>entre los que se
                incluyen el rastreo satelital para la localización de vehículos, gestión, control y seguridad de
                flotas, con las autorizaciones, registros y licencias necesarias para brindar el mencionado servicio a
                las siguientes unidades de placas:
            </p>
        </div>
    </section>


    {{-- tabla --}}
    <section class="center-text">
        <div>
            <div>
                <table class="tabla">

                    </colgroup>
                    <thead class="tabla-vehiculos-header color-table">
                        <tr style="height: 21px;">
                            <th class="tabla-vehiculos">ITEM</th>
                            <th class="tabla-vehiculos">TIPO</th>
                            <th class="tabla-vehiculos">PLACA</th>
                            <th class="tabla-vehiculos">PLAN</th>
                        </tr>
                    </thead>
                    <tbody class="tabla-vehiculos-body center-tex">
                        <tr>
                            <td class="tabla-vehiculos"> 1 </td>
                            <td class="tabla-vehiculos">PLACA</td>
                            <td class="tabla-vehiculos">PLACA</td>
                            <td class="tabla-vehiculos">PREMIUM</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <section>
        <div>
            <h2 class="sutitulo">
                <b>
                    <u>Cláusula segunda: Objeto del contrato</u>
                </b><b>.</b>
            </h2>
            <p>
                <b>2.1.- </b>La <b></b>cobertura del servicio,<b></b>que <b>TALENTUS TECHNOLOGY
                    E.I.R.L.</b>&nbsp;brindará a&nbsp;<b>EL CLIENTE</b>&nbsp;por el servicio descrito en la cláusula que
                antecede, es en una cobertura de rastreo solamente en el Territorio Peruano durante las 24 horas del día
                los 365 días del año, con personal debidamente capacitado y con sistemas que garantizan la atención de
                todas las necesidades de&nbsp;<b>EL CLIENTE</b>. Para que se brinde el presente servicio, <b>EL CLIENTE
                </b>se obliga a comprar el equipo a <b>T Y T, </b>o de acuerdo al plazo del contrato, se obliga a
                alquilar el equipo; en el supuesto que <b>EL CLIENTE </b>ya tenga el equipo, <b>T Y T</b> sólo realizará
                el cambio de chip a una línea de la misma empresa, previa comprobación de compatibilidad con su
                plataforma. Todo equipo nuevo tiene una garantía de un (01) año, sea por fallas o defectos de
                fabricación (la garantía no cubre las manipulaciones que se realicen en los equipos, por personal ajeno
                a la empresa y/o no autorizado). De acuerdo al tipo del presente contrato, <b>EL CLIENTE </b>procede a
                realizar: compra de equipo (…) / alquiler de equipo (…) / cambio de chip (…).<br>
                <br>
            </p>
            <p>
                <b>2.2.- TALENTUS TECHNOLOGY E.I.R.L.</b>&nbsp;no se responsabiliza por los eventuales cortes en la
                prestación del servicio&nbsp;dentro de la cobertura de la señal contratada, que pueda surgir como
                consecuencia de la falta de cobertura por parte de la empresa proveedora de comunicación
                inalámbrica de&nbsp;<b>T Y T </b>y/o por la falta de pago por parte de&nbsp;<b>EL CLIENTE</b>, y/o por
                algún desperfecto técnico en los sistemas de energía que puede provocar un reinicio forzado en los
                servidores (cuyo reinició puede ocasionar la corrupción de datos en los discos duros que usamos para
                almacenar la data de los reportes), por lo que el cliente debe tomar las medidas preventivas sacando sus
                reportes, ya que la data almacenada son 3 meses como máximo a fin de evitar la pérdida de información.
            </p>
            <p>
                <b>2.3.- TALENTUS TECHNOLOGY E.I.R.L.</b>, declara contar con una Central de Operaciones, Monitoreo y
                Atención al Cliente con personal debidamente capacitado y con un sistema de alta disponibilidad que
                garantiza la recepción y atención de la información para realizar la localización y rastreo, así como la
                generación de reportes; así mismo declara que su número telefónico a efecto de comunicaciones es el
                siguiente 987816560 / 977794338 / 944299794.
            </p>
        </div>
    </section>


    <section>
        <div>
            <h2 class="sutitulo">
                <b>
                    <u>Cláusula tercera: Contraprestación</u>
                </b><b>.</b>
            </h2>
            <p>
                <b>3.1.-</b> En virtud del presente contrato, <b>EL CLIENTE</b> se obliga ante <b>EL LOCADOR</b> a pagar
                en calidad de contraprestación la cantidad de S/ ___(x)___ (___(x)___ con 00/100 Soles), monto que no
                que incluye IGV, de forma ……… y por adelantado, previa emisión de la factura correspondiente,
                realizándose en la cuenta perteneciente a <b>T Y T</b> que les brinde oportunamente. El monto indicado
                no comprende el precio del equipo que se instala en las unidades vehiculares y demás circunstancias
                indicadas en la cláusula segunda, punto 2.1, del presente contrato.&nbsp;
            </p>
            <p><b>3.</b><b>2.- EL CLIENTE</b>&nbsp;faculta, en caso de incumplimiento con los pagos,&nbsp;a <b>TALENTUS
                    TECHNOLOGY E.I.R.L.,&nbsp;</b>para que envíe un reporte a las empresas prestadoras de información
                crediticia, respetando la normativa respectiva sobre información a centrales de riesgo de acuerdo a la
                normativa estipulada por la S.B.S. (Superintendencia de Banca, Seguros y AFP); así como la referente a
                protección de datos y el código de ética que las empresas de las centrales de riesgo manejan.<b></b>
            </p>
        </div>
    </section>
    <section>
        <div>
            <h2 class="sutitulo">
                <b><u>Cláusula cuarta: Ejecución y plazo del contrato</u></b><b>.<u></u></b>
            </h2>

            <p>
                <b>4.1.-</b> Ambas partes convienen en que la vigencia del presente contrato tendrá un plazo de duración
                de ___(x)___ (___(x)___), que se contabilizarán desde el <b>(X) de (X) del 2022 al (X) de (X) del
                    (X)</b>; así mismo cualquiera de las partes se reservan el derecho de dejar sin efecto el presente
                contrato mediante simple aviso escrito u electrónico con previo aviso de 05 días naturales de
                anticipación sin expresión de causa. Del mismo modo, si <b>EL CLIENTE</b> desea renovar el presente
                contrato, debe manifestar su intención con un pre aviso de 05 días naturales (razonable) de anticipación
                antes de la culminación del mismo.<b>
                </b>
            </p>
        </div>
    </section>

    <section>
        <div>
            <h2 class="sutitulo">
                <b><u>Cláusula quinta: Obligaciones de las partes</u></b>
                <b>.</b>
            </h2>
            <p>
                <b>5.1.- EL CLIENTE&nbsp;</b>se compromete a definir y comunicar a&nbsp;<b>TALENTUS TECHNOLOGY
                    E.I.R.L.</b>, la placa de la unidad, así como su nombre y/o razón social, y demás datos que se les
                solicite, a fin de identificarse al momento de llamar a la Central de Operaciones de&nbsp;<b>TALENTUS
                    TECHNOLOGY.</b> En caso&nbsp;<b>EL CLIENTE </b>no recuerde sus accesos será&nbsp;<b>TALENTUS
                    TECHNOLOGY E.I.R.L.</b>&nbsp;quien cambie la clave previamente otorgada e informe al cliente la
                nueva clave generada, la misma que puede ser cambiada por mutuo acuerdo y registro.
            </p>
            <p>
                <b>5.2.- </b>En caso de riesgo o emergencia, procedan de la siguiente manera:
            </p>

            <p>
                <b>5.2.1.-</b> Reporten el incidente a la brevedad posible llamando a la Central de Operaciones
                de&nbsp;<b>TALENTUS TECHNOLOGY E.I.R.L</b>, a los siguientes números telefónicos 987816560/
                977794338/944299794, identificándose con sus accesos placa y/o Razón Social, brindando toda la
                información posible acerca del incidente y siguiendo obligatoriamente todas las indicaciones que se
                le den en la Central de Operaciones. <br><b>5.2.2.-</b> A partir de este momento&nbsp;<b>TALENTUS
                    TECHNOLOGY E.I.R.L.</b>&nbsp;procederá a ubicar la posición de&nbsp;<b>LOS VEHICULOS y o generación
                    de reportes de ubicación,</b> tras confirmar la autenticidad de la emergencia, coordinará
                con&nbsp;<b>EL CLIENTE</b>&nbsp;y las autoridades competentes la atención del llamado de ayuda.<br>
            </p>

            <p>
                <b>5.3.- </b>De acuerdo a la cláusula tercera, a cumplir puntualmente con los pagos, caso contrario este
                incumplimiento, puede ser causal de resolución del presente contrato, independientemente de las acciones
                legales que consideren.
            </p>
            <p>
                <b>5.4.- TALENTUS TECHNOLOGY E.I.R.L.&nbsp;</b>debe contar con un equipo especializado de soporte
                técnico las 24 horas del día, los 7 días de la semana, los 365 días del año para caso de emergencias o
                ubicación de vehículos. En caso de que el cliente quede disconforme con la atención, puede presentar un
                reclamo. Una vez que <b>EL CLIENTE</b> presenta su reclamo, <b>TALENTUS TECHNOLOGY E.I.R.L. </b>cuenta
                con un plazo de 07 días hábiles para brindar una solución a <b>EL CLIENTE</b> o dirigirse a nuestras
                oficinas ubicadas en el Jr Santa María N° 209, dentro del horario de atención.

                Los plazos de atención son los siguientes:
            </p>
        </div>
    </section>

    <section>
        <div>
            <div>
                <table class="tabla">
                    <colgroup>
                        <col width="2.26%">
                        <col width="76.76%">
                        <col width="20.98%">
                    </colgroup>
                    <thead class="color-table tabla-vehiculos-header">
                        <tr style="height: 46px;">
                            <th>N°</th>
                            <th>REQUERIMIENTO</th>
                            <th>TIEMPO DE ATENCION</th>
                        </tr>
                    </thead>
                    <tbody class="tabla-border">
                        <tr style="height: 25px;">
                            <td>
                                1</td>
                            <td>Instalación de equipo GPS nuevo
                                (previa coordinacion con el area tecnica)</td>
                            <td>40 minutos</td>
                        </tr>
                        <tr style="height: 27px;">
                            <td>
                                2</td>
                            <td>Creación y envío de usuarios y
                                contraseñas para el monitoreo de la unidad vehicular</td>
                            <td>2 horas</td>
                        </tr>
                        <tr style="height: 27px;">
                            <td>
                                3<br>
                            </td>
                            <td>Entrega de certificados electronicos
                            </td>
                            <td>2 horas</td>
                        </tr>
                        <tr style="height: 27px;">
                            <td>
                                4<br>
                            </td>
                            <td>Entrega de facturas y/o recibos
                                electronicos (después del pago)<br>
                            </td>
                            <td>2 horas</td>
                        </tr>
                        <tr style="height: 25px;">
                            <td>5</td>
                            <td>Reactivación del servicio</td>
                            <td>24 horas</td>
                        </tr>
                        <tr style="height: 30px;">
                            <td>6</td>
                            <td>Mantenimiento y servicio técnico
                                (previa coordinacion con el técnico)</td>
                            <td>24 horas</td>
                        </tr>
                        <tr style="height: 27px;">
                            <td>7</td>
                            <td>Desarrollo de módulos adicionales en
                                la plataforma (previa consulta con el área correspondiente)</td>
                            <td>5 dias hábiles de acuerdo a la
                                complejidad</td>
                        </tr>
                        <tr style="height: 29px;">
                            <td>8</td>
                            <td>Consultas de ubicacion y recorrido del
                                vehiculo</td>
                            <td>Inmediato</td>
                        </tr>
                        <tr style="height: 76px;">
                            <td>9</td>
                            <td>Reportes en formato Excel de las
                                unidades vehiculares (siempre y cuando el usuario no pueda acceder desde una PC a la
                                plataforma)</td>
                            <td>2 horas</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p> Los horarios de atención son los siguientes:</p>
            <ul>
                <li>Lunes a viernes de 9am – 1pm y de 3:30pm a 6.30pm:
                    administrativos, reportes, capacitaciones, consultas.&nbsp;</li>
                <li>
                    Emergencias: <span
                        style="background-color: #ffffff; color: #111111; font-family: 'Open Sans',sans-serif; font-size: 1rem;">24
                        horas del día, los 7 días de la semana, los 365 días del año</span>
                </li>
            </ul>

            <p>
                <b> 5.5.- EL CLIENTE </b>se responsabiliza por cualquier concepto de multa en el ente regulador Sutrán,
                puesto que el mismo está a cargo de la dirección y manipulación de los vehículos. <br>

            </p>

            <p>
                <b>5.6.- EL CLIENTE </b>se responsabiliza por el cambio del equipo GPS, haciendo de su conocimiento por
                intermedio del presente documento que el equipo GPS tiene una vida útil aproximada no mayor a tres (03)
                años debiendo proceder a solicitar/adquirir un nuevo equipo de acuerdo a las cláusulas correspondientes
                del presente contrato (ver cláusula tercera y demás aplicables); motivo por el cual, <b>Talentus
                    Technology EIRL, </b>no se responsabiliza de ser el caso, de reportes errados emitidos por el GPS
                (que se requiera el cambio por pasar su vida útil).
            </p>

            <p>
                <b>5.7.- CLIENTE</b> autoriza a <b>Talentus Technology EIRL</b> a recolectar y procesar datos personales
                (ruc, razón social, fecha de nacimiento, correos, teléfonos y alguna otra información que sea necesaria
                para brindar un óptimo servicio), garantizando la confidencialidad, integridad y disponibilidad de la
                información para el desarrollo de su operación con la siguiente finalidad:
            </p>

            <ul>
                <li>Ejecutar los contratos celebrados&nbsp;</li>
                <li>Realizar análisis con fines contractuales </li>
                <li>
                    <span>Utilizarlos para fines administrativos en las diferentes actividades que realiza la empresa y
                        otros afines al servicio brindado.</span>
                </li>
            </ul>

            <p>
                La entrega de datos personales es facultativa. Lo anterior no impedirá que los titulares en cualquier
                momento y conforme a la ley, puedan ejercer sus derechos de conocimiento, acceso, rectificación,
                actualización, revocatoria y supresión de sus datos personales, siempre que no exista un mandato legal o
                contractual que faculte a Talentus Technology EIRL para continuar con el tratamiento directamente.</p>
        </div>

    </section>

    <section>
        <div>
            <h2 class="sutitulo">
                <b><u>Cláusula sexta:&nbsp;Extinción de responsabilidad</u></b><b>.</b>
            </h2>

            <p><b>6.1.- TALENTUS TECHNOLOGY E.I.R.L.&nbsp;</b>no es una empresa de seguros por lo que no se le
                podrá imputar responsabilidad alguna por el daño directo o indirecto, por la pérdida total o parcial que
                sufra cualquiera de los vehículos<b>&nbsp;</b>y/o los daños directos o indirectos que pudieran
                generarse a los pasajeros, al personal de&nbsp;<b>EL CLIENTE</b>&nbsp;o a terceros como consecuencia del
                robo o secuestro, o inminente robo o secuestro de&nbsp;los vehículos, o cargas que transporten (incluido
                el combustible que puedan usar los vehículos).

            </p>
            <p>
                <b> 6.2.-</b> Cualquier póliza de seguros, de ser requerida, será responsabilidad de&nbsp;<b>EL
                    CLIENTE</b>. <br><b>

            </p>
            <p>
                <b> 6.3.- TALENTUS TECHNOLOGY E.I.R.L.&nbsp;</b>no será responsable por el funcionamiento (deficiente o
                aceptable) del servicio de comunicación inalámbrica que le brinda la empresa proveedora de la señal
                inalámbrica necesaria para la prestación del servicio brindado. <br>
            </p>
            <p>
                <b>6.4.- EL CLIENTE</b>&nbsp;acepta que los referidos casos no constituyen incumplimiento por parte
                de&nbsp;<b>TALENTUS TECHNOLOGY E.I.R.L.</b>, respecto de las obligaciones pactadas en el presente
                contrato. <br>
            </p>
            <p>
                <b>6.5.- TALENTUS TECHNOLOGY E.I.R.L.</b> no se responsabiliza por desperfectos técnicos en los sistemas
                de energía que puede provocar un reinicio forzado en los servidores y cuyo reinició puede ocasionar
                la corrupción de datos en los discos duros que usamos para almacenar la data de los reportes. <br><b>
            </p>
            <p>
                <b>6.6.- </b>Están comprendidos los casos de fuerza mayor y casos fortuitos, que pudieran darse al
                brindar el servicio, lo cual no genera ninguna responsabilidad por parte de <b>TALENTUS TECHNOLOGY
                    E.I.R.L</b>.
            </p>
        </div>
    </section>
    <section>
        <div>
            <h2 class="sutitulo">
                <b><u>Cláusula séptima: Cumplimiento de normatividad</u></b><b>.</b>
            </h2>

            <p>
                <b>7.1.-</b> Para efectos que&nbsp;<b>TALENTUS TECHNOLOGY E.I.R.L.&nbsp;</b>brinde el servicio objeto
                del
                presente contrato, este debe contar con los certificados de valores añadidos emitidos por el Ministerio
                de Transporte y Comunicaciones, de acuerdo a la Ley de Telecomunicaciones (Decreto Supremo N°
                013-93-TCC).&nbsp;<br><b>

                </b>
            </p>
            <p>
                <b>7.2.-</b> En caso que&nbsp;<b>EL CLIENTE&nbsp;</b>lo requiera,&nbsp;<b>TALENTUS TECHNOLOGY
                    E.I.R.L.,</b>&nbsp;puede retransmitir datos hacia los servidores de la Superintendencia
                de&nbsp;<br>Transporte Terrestre de Personas, Carga y Mercancías (SUTRAN) o al Organismo Supervisor de
                la Inversión en Energía y Minería (OSINERGMIN), en caso que&nbsp;<b>EL CLIENTE&nbsp;</b>en cumplimiento
                de la normativa nacional, se vea obligado a cumplir con la ley de la materiales, esto es factible debido
                a que, <b>TALENTUS TECHNOLOGY E.I.R.L. </b>cuenta con los certificados emitidos por el Ministerio de
                Transporte y Comunicaciones de valor añadido en las modalidades de “Almacenamiento y Retransmisión de
                datos”.
            </p>
        </div>
    </section>

    <section>
        <div>
            <h2 class="sutitulo">
                <b><u>Cláusula octava: Resolución del contrato y penalidades</u></b><b>.</b>
            </h2>

            <p>
                <b>8.1.-</b> Cualquiera de las partes podrá resolver el presente contrato, antes de su vencimiento,
                debido al incumplimiento de alguna obligación pactada o inherente al servicio de conformidad con el
                artículo 1371° del Código Civil.
            </p>

            <p>
                <b>8.2.-</b> En caso&nbsp;<b>EL CLIENTE&nbsp;</b>desee resolver el presente contrato mientras que este
                se
                encuentre vigente, tendrá que enviar un correo (solicitando acuse de recepción) a
                administracion@talentustechnology.com, indicando la baja del servicio el cual será atendido en un plazo
                no mayor a 24 horas a excepción de sábados, domingos y feriados, y deberá pagar las penalidades
                correspondientes de acuerdo a la presente cláusula, mas los días en los cuales se le siga prestando el
                servicio hasta la dada de baja.
            </p>
            <p>
                <b>8.3.-</b> En caso <b>TALENTUS TECHNOLOGY E.I.R.L.</b> desee resolver el presente contrato mientras
                que este se encuentre vigente, deberá de notificar a <b>EL CLIENTE</b> por conducto notarial
                con una anticipación no menor a 30 días calendarios posteriores a la notificación de su decisión de
                resolver el presente contrato.
            </p>

            <p><b>8.4.-</b> En caso de incumplimiento de obligaciones, se puede requerir el normal desarrollo del
                presente contrato a la parte que se encuentre incumpliendo el mismo; si vencido dicho plazo el
                incumplimiento persistiera, la otra parte podrá resolver el contrato en forma total o parcial,
                fuera de solicitar la indemnización correspondiente de acuerdo con el artículo 1428° del Código Civil.
            </p>

            <p>
                <b>8.5.-</b> La resolución se formaliza a través de la recepción de la carta notarial o&nbsp;un correo
                indicando la baja del servicio al correo indicado en el ítem anterior, según sea el caso, respectivo,
                informando la decisión de resolver total o parcialmente el contrato. Si <b>EL CLIENTE</b> decide dejar
                sin efecto el contrato antes del vencimiento del primer año forzoso, deberá pagar a favor
                de&nbsp;<b>TALENTUS TECHNOLOGY E.I.R.L.&nbsp;</b>una penalidad conforme lo establece el artículo 1341°
                del Código Civil, correspondiente este igual al 50% del monto adeudado hasta la culminación del
                contrato y adicionalmente el total del monto del valor del equipo GPS, en caso de que se haya acordado
                su pago durante un periodo de doce meses. Si&nbsp;<b>EL CLIENTE</b>&nbsp;incumple con el pago de la
                mensualidad del servicio contratado, <b>TALENTUS TECHNOLOGY E.I.R.L.</b> tiene la facultad de suspender
                el servicio de localización, rastreo, ubicación, control y supervisión satelital vehicular hasta que
                <b>EL CLIENTE</b> regularice el pago, con una penalidad por cada día calendario de atraso, equivalente a
                S/.0.50 (cero con 50/100 nuevos soles); pudiendo&nbsp;<b>TALENTUS TECHNOLOGY E.I.R.L.</b> resolver el
                contrato parcial o totalmente por incumplimiento mediante carta notarial sin perjuicio de la
                indemnización por los daños y perjuicios ulteriores que pueda existir y aplicación de la penalidad. La
                justificación por el retraso se sujeta a lo dispuesto por el Código Civil y demás normas concordantes.
                Adicionalmente en caso que <b>EL CLIENTE</b> incumpla con los pagos a favor de <b>TALENTUS TECHNOLOGY
                    E.I.R.L</b> este último se encuentra facultado a protestar títulos valores y/o endosar comprobantes
                de pago con la finalidad que otras entidades financieras puedan realizar el cobro respectivo, por lo
                tanto, mediante la suscripción del presente contrato, <b>EL CLIENTE </b>acepta lo mencionado
                anteriormente. En caso de que el servicio haya sido suspendido por falta de pagos y no se pueda realizar
                la reconexión remota <b>EL CLIENTE</b> pagará a <b>TALENTUS TECHNOLOGY E.I.R.L</b>. una
                penalidad&nbsp;por cargos de reinstalación y cambio de chips según las tarifas indicadas a continuación
                y este tendrá un plazo de 48 hrs., o del tiempo que demore en tener contacto con el vehículo para su
                correcto funcionamiento, lo cual exime de responsabilidad a <b>TALENTUS TECHNOLOGY E.I.R.L</b>.
            </p>
        </div>
    </section>

    <section>
        <div>
            <div>
                <table class="tabla-ciudad">
                    <colgroup>
                        <col width="50%">
                        <col width="50%">
                    </colgroup>
                    <tbody class="u-table-alt-palette-1-light-3">
                        <tr class="tabla-ciudad-header">
                            <td>CAJAMARCA Y CIUDADES</td>
                            <td>PROVINCIAS Y DISTRITOS</td>
                        </tr>
                        <tr class="tabla-ciudad-body">
                            <td>S/. 40.00</td>
                            <td> S/. 80.00 más viáticos</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section>
        <div>
            <p><b>&nbsp;Estos precios no incluyen IGV.</b>
            </p>
            <p> No es
                indispensable la firma del contrato para la aceptación de los términos y
                condiciones generales, Así mismo estos términos están sujetos a la aceptación
                tácita con emisión de comprobantes de pago del servicio y/o con sólo contar un
                usuario en la plataforma del panel de <b>TALENTUS TECHNOLOGY E.I.R.L</b>
            </p>
        </div>
    </section>
    <section>
        <div>
            <h2 class="sutitulo"><b><u>Cláusula novena:</u></b><u><b>Domicilio</b></u><b>.<u></u></b>
            </h2>
            <p> Para la validez de todas las comunicaciones y notificaciones a las partes, con motivo de la ejecución de
                este contrato, ambas señalan como sus respectivos domicilios los indicados en la introducción de este
                documento. El cambio de cualquiera de las partes surtirá efectos desde la fecha de comunicación de dicho
                cambio a la otra parte,
                por vía notarial.
            </p>
            <h2 class="sutitulo"><b><u>Cláusula décima: Aplicación supletoria de la Ley</u></b><b>. <u></u></b>
            </h2>
            <p> En todo lo no previsto por
                las partes en el presente contrato, ambas se someten a lo establecido por el
                Código Civil&nbsp;y demás del sistema jurídico que resulten aplicables.
            </p>

            <h2 class="sutitulo"><b><u>Cláusula décimo primera: Jurisdicción y
                        competencia</u></b><b>.<u></u></b>
            </h2>

            <p>
                Las controversias entre las partes se solucionarán mediante reuniones de trato
                directo y conciliación extrajudicial si fuese necesario. Sin embargo, para
                todos los efectos obligacionales, incumplimientos de cualquiera de las partes,
                interpretación o duda de cualquiera de las cláusulas del presente contrato y
                demás controversias que surjan luego de la suscripción del presente contrato,
                ambas partes se someten a la jurisdicción de los jueces y tribunales de la
                ciudad de Cajamarca.
            </p>
        </div>
    </section>

    </body>



    {{-- 
    <div class="hash">
        {{ $contrato->unique_hash }}
    </div> --}}

</div>



</body>

</html>
