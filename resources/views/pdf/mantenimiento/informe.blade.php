<html>

<head>

    <meta charset="UTF-8">
    <title>

        MATENIMIENTO {{ $mantenimiento->numero }}

    </title>

    <link rel="stylesheet" href="{{ asset('css/mantenimient.css') }}">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {{ header('Content-type:application/pdf') }}


    <style type="text/css">
        /* -- Base -- */
        body {

            background-repeat: no-repeat;
            background-size: 100%;

        }
    </style>
</head>

<body
    background="data:image/jpeg;base64,{{ base64_encode(file_get_contents(asset('storage/talentus/imagenes/fondo_documento_horizontal.png'))) }}">

    <div class="w-full px-6 mx-2 row margin-pdf">

        <div class="  medium-12">
            <h1 class="text-3xl font-semibold leading-7 text-talentus">MANTENIMIENTO
                #{{ $mantenimiento->numero }}
            </h1>
            <p class="text-base font-medium leading-6 text-gray-600">
                {{ $mantenimiento->fecha_hora_mantenimiento->isoformat('d \d\e MMMM Y') }}</p>
        </div>


        <div class="medium-6 left  h-full row">

            <div class="flex flex-row justify-start items-start w-full medium-12">

                <div class="flex flex-row justify-start items-start p-8 w-full">

                    <div class="mt-6 flex flex-row justify-start items-center space-x-8 w-full row">
                        <div
                            class="border-b border-gray-200 flex-row flex justify-between items-start w-full pb-8 space-y-0 medium-10 columns">
                            <div class="w-full medium-12  flex flex-col justify-start items-start space-y-8 medium-6">
                                <h3 class="text-xl font-semibold leading-6 text-talentus">
                                    Detalle programacion mantenimiento</h3>
                                <div class="flex justify-start items-start flex-row space-y-2">
                                    <p class="text-sm  leading-none text-talentus">
                                        <span class="font-semibold text-gray-800">
                                            Placa: </span>
                                        T5B-540
                                    </p>

                                    <p class="text-sm leading-none text-talentus"><span
                                            class="font-semibold text-gray-800">Estado: </span>
                                        {{ $mantenimiento->estado }}</p>
                                    <p class="text-sm leading-none text-talentus"><span
                                            class="font-semibold text-gray-800">Detalle: </span>
                                        {{ $mantenimiento->detalle_trabajo }}
                                    </p>
                                    <p class="text-sm leading-none text-talentus"><span
                                            class="font-semibold text-gray-800">Nota: </span>
                                        {{ $mantenimiento->nota }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>

        <div class="medium-6 right">
            <div class="flex flex-row justify-start items-start w-full medium-12">

                <div class="flex flex-row justify-start items-start p-8 w-full">

                    <div class="mt-6 flex flex-row justify-start items-center space-x-8 w-full row">
                        <div
                            class="border-b border-gray-200 flex-row flex justify-between items-start w-full pb-8 space-y-0 medium-10 columns">
                            <div class="w-full medium-12 flex flex-col justify-start items-start space-y-8 medium-6">
                                <h3 class="text-xl font-semibold leading-6 text-talentus">
                                    Detalle tarea relacionada</h3>
                                @if ($mantenimiento->tarea)
                                    <div class="flex justify-start items-start flex-row space-y-2">
                                        <p class="text-sm  leading-none text-talentus">
                                            <span class="font-semibold text-gray-800">
                                                Numero Tarea: </span>
                                            #{{ $mantenimiento->tarea->token }}
                                        </p>
                                        <p class="text-sm  leading-none text-talentus">
                                            <span class="font-semibold text-gray-800">
                                                Tecnico: </span>
                                            {{ $mantenimiento->tarea->tecnico->name }}
                                        </p>


                                        <p class="text-sm leading-none text-talentus"><span
                                                class="font-semibold text-gray-800">Descripción: </span>

                                            <br>
                                            @switch($mantenimiento->tarea->tipo_tarea_id)
                                                @case(1)
                                                    Instalación de GPS {{ $mantenimiento->tarea->dispositivo }} en vehículo:
                                                    <b>{{ $mantenimiento->tarea->vehiculo->placa }}</b>, Fecha
                                                    instalación: <b>
                                                        {{ $mantenimiento->tarea->fecha_hora->format('d/m/Y') }}</b> - Hora:
                                                    <b>{{ $mantenimiento->tarea->fecha_hora->format('h:i A') }}</b>
                                                @break

                                                @case(2)
                                                    Cambio de chip en el vehículo:
                                                    <b>{{ $mantenimiento->tarea->vehiculo->placa }}</b>, Fecha
                                                    Tarea: <b> {{ $mantenimiento->tarea->fecha_hora->format('d/m/Y') }}</b> -
                                                    Hora:
                                                    <b>{{ $mantenimiento->tarea->fecha_hora->format('h:i A') }}</b>
                                                @break

                                                @case(3)
                                                    Desinstalación de GPS {{ $mantenimiento->tarea->dispositivo }} en el
                                                    vehículo:
                                                    <b>{{ $mantenimiento->tarea->vehiculo->placa }}</b>, Fecha Tarea:
                                                    <b> {{ $mantenimiento->tarea->fecha_hora->format('d/m/Y') }}</b> - Hora:
                                                    <b>{{ $mantenimiento->tarea->fecha_hora->format('h:i A') }}</b>
                                                @break

                                                @case(4)
                                                    Instalación de Velocimetro
                                                    <b>{{ $mantenimiento->tarea->modelo_velocimetro }}</b> en el
                                                    vehículo:
                                                    <b>{{ $mantenimiento->tarea->vehiculo->placa }}</b>, Fecha
                                                    Tarea: <b> {{ $mantenimiento->tarea->fecha_hora->format('d/m/Y') }}</b> -
                                                    Hora:
                                                    <b>{{ $mantenimiento->tarea->fecha_hora->format('h:i A') }}</b>
                                                @break

                                                @case(5)
                                                    Mantenimiento GPS {{ $mantenimiento->tarea->dispositivo }} en el vehículo:
                                                    <b>{{ $mantenimiento->tarea->vehiculo->placa }}</b>, Fecha
                                                    Tarea: <b> {{ $mantenimiento->tarea->fecha_hora->format('d/m/Y') }}</b> -
                                                    Hora:
                                                    <b>{{ $mantenimiento->tarea->fecha_hora->format('h:i A') }}</b>
                                                @break
                                            @endswitch
                                        </p>
                                        <p class="text-sm leading-none text-talentus"><span
                                                class="font-semibold text-gray-800">Fecha Tarea Registrada: </span>
                                            {{ $mantenimiento->tarea->created_at->format('d-m-Y h:i A') }}
                                        </p>
                                        <p class="text-sm leading-none text-talentus"><span
                                                class="font-semibold text-gray-800">Fecha Termino Tarea: </span>
                                            {{ $mantenimiento->tarea->fecha_termino ? $mantenimiento->tarea->fecha_termino->format('d-m-Y h:i A') : '' }}
                                        </p>
                                    </div>
                                @else
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>


    </div>

    <div class="footer row medium-12">
        <div class="sello">

            <img src="data:image/jpeg;base64, {{ base64_encode(file_get_contents(asset('storage/' . $sello))) }}"
                alt="">


        </div>
        <div class="fecha">
            <p>
                {{ $fecha->isoformat('\C\a\j\a\m\a\r\c\a\, DD \d\e MMMM \d\e\l Y') }}
            </p>
        </div>
    </div>


</body>


</html>
