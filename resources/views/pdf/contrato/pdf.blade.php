<!DOCTYPE html>
<html>

<head>

    <title>CONTRATO {{$contrato->clientes->razon_social}}</title>


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {{header("Content-type:application/pdf");}}


    <style type="text/css">
        /* -- Base -- */
        body {

            font-family: "Arial, Helvetica, sans-serif";
            background-repeat: no-repeat;
            background-size: 100%;

        }

        html {
            margin: 0px;
            padding: 0px;

        }

        .contrato {
            display: flex;
            flex-wrap: wrap;
            overflow: hidden;
            padding: 2rem;
            // margin: 0rem 4rem;

        }
    </style>

</head>

@if ($contrato->fondo)

<body background="data:image/jpeg;base64, {{base64_encode(file_get_contents('images/'.$fondo))}}">
    @else

    <body>
        @endif


        <div class="contrato">


            <div class="header">


                <div class="titulo">
                    <span>CONTRATO</span>
                </div>

            </div>





            <div class="hash">
                {{$contrato->unique_hash}}
            </div>

        </div>



    </body>

</html>