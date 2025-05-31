<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* invoice.html.twig */
class __TwigTemplate_f76f5932193f5e79c0fdb88243c52b9f extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<html>
<head>
";
        // line 3
        $context["cp"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 3, $this->source); })()), "company", [], "any", false, false, false, 3);
        // line 4
        $context["isNota"] = CoreExtension::inFilter(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 4, $this->source); })()), "tipoDoc", [], "any", false, false, false, 4), ["07", "08"]);
        // line 5
        $context["isAnticipo"] = (CoreExtension::getAttribute($this->env, $this->source, ($context["doc"] ?? null), "totalAnticipos", [], "any", true, true, false, 5) && (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 5, $this->source); })()), "totalAnticipos", [], "any", false, false, false, 5) > 0));
        // line 6
        $context["name"] = $this->env->getRuntime('Greenter\Report\Filter\DocumentFilter')->getValueCatalog(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 6, $this->source); })()), "tipoDoc", [], "any", false, false, false, 6), "01");
        // line 7
        yield "    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <title>";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cp"]) || array_key_exists("cp", $context) ? $context["cp"] : (function () { throw new RuntimeError('Variable "cp" does not exist.', 10, $this->source); })()), "ruc", [], "any", false, false, false, 10), "html", null, true);
        yield "-";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 10, $this->source); })()), "serie", [], "any", false, false, false, 10), "html", null, true);
        yield "- ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 10, $this->source); })()), "correlativo", [], "any", false, false, false, 10), "html", null, true);
        yield "</title>
    <style type=\"text/css\">
        .bold,b,strong{
            font-weight:700
        }
        body{
        background-repeat:no-repeat;
        background-position:center center;
        text-align:center;
        margin:0;
        font-family: Verdana, monospace
        }
        .tabla_borde{
            border:1px solid #666;
            border-radius:10px
        }
        tr.border_bottom td{
            border-bottom:1px solid #000
        }
        tr.border_top td{
            border-top:1px solid #666
        }
        td.border_right{
            border-right:1px solid #666
        }
        .table-valores-totales tbody>tr>td{
            border:0
        }
        .table-valores-totales>tbody>tr>td:first-child{
            text-align:right
        }
        .table-valores-totales>tbody>tr>td:last-child{
            border-bottom:1px solid #666;
            text-align:right;
            width:30%
        }
        hr,img{
            border:0
        }
        table td{
            font-size:12px
        }
        html{
            font-family:sans-serif;
            -webkit-text-size-adjust:100%;
            -ms-text-size-adjust:100%;
            font-size:10px;
            -webkit-tap-highlight-color:transparent
        }
        a{
            background-color:transparent
        }
        a:active,a:hover{
            outline:0
        }
        img{
            vertical-align:middle
        }
        hr{
            height:0;
            -webkit-box-sizing:content-box;
            -moz-box-sizing:content-box;
            box-sizing:content-box;
            margin-top:20px;
            margin-bottom:20px;
            border-top:1px solid #eee
        }
        table{
            border-spacing:0;
            border-collapse:collapse
        }
        @media print{
            blockquote,img,tr{
                page-break-inside:avoid
            }
            *,:after,:before{
                color:#000!important;
                text-shadow:none!important;
                background:0 0!important;
                -webkit-box-shadow:none!important;
                box-shadow:none!important
            }
            a,a:visited{
                text-decoration:underline
            }
            a[href]:after{
                content:\" (\" attr(href) \")\"
            }
            blockquote{
                border:1px solid #999
            }
            img{
                max-width:100%!important
            }
            p{
                orphans:3;
                widows:3
            }
            .table{
                border-collapse:collapse!important
            }
            .table td{
                background-color:#fff!important
            }
        }
        a,a:focus,a:hover{
            text-decoration:none
        }
        *,:after,:before{
            -webkit-box-sizing:border-box;
            -moz-box-sizing:border-box;
            box-sizing:border-box
        }
        a{
            color:#428bca;
            cursor:pointer
        }
        a:focus,a:hover{
            color:#2a6496
        }
        a:focus{
            outline:dotted thin;
            outline:-webkit-focus-ring-color auto 5px;
            outline-offset:-2px
        }
        h6{
            font-family:inherit;
            line-height:1.1;
            color:inherit;
            margin-top:10px;
            margin-bottom:10px
        }
        p{
            margin:0 0 10px
        }
        blockquote{
            padding:10px 20px;
            margin:0 0 20px;
            border-left:5px solid #eee
        }
        table{
            background-color:transparent
        }
        .table{
            width:100%;
            max-width:100%;
            margin-bottom:20px
        }
        h6{
            font-weight:100;
            font-size:10px
        }
        body{
            line-height:1.42857143;
            font-family:\"open sans\",\"Helvetica Neue\",Helvetica,Arial,sans-serif;
            background-color:#2f4050;
            font-size:13px;
            color:#676a6c;
            overflow-x:hidden
        }
        .table>tbody>tr>td{
            vertical-align:top;
            border-top:1px solid #e7eaec;
            line-height:1.42857;
            padding:8px
        }
        .white-bg{
            background-color:#fff
        }
        td{
            padding:6
        }
        .table-valores-totales tbody>tr>td{
            border-top:0 none!important
        }
        //CUSTOM CSS
            body{

                font-family: Verdana, monospace
            }
            #tabla-cabecera,
            #tabla-cliente,
            #tabla-items,
            #tabla-totales,
            .tabla-importes,
            .tabla-observacion {
                position: relative;
                width: 100%;
                border-collapse: collapse;

            }

            #tabla-cabecera {
                text-align: center;
                letter-spacing: 0.5px;
                color: #333;
            }

            #tabla-cabecera h3 {
                font-size: 16px;
                margin-bottom: 1px;
                color: #444;
            }

            #tabla-cliente td {
                border: 0.5px solid #333;
                padding: 7px;
                text-align: left;
                font-size: 12px;
                padding-left: 10px;
                letter-spacing: 1px;
            }

            #tabla-totales td {
                padding: 7px;
                text-align: left;
                font-size: 12px;
                letter-spacing: 0.5px;
                padding-left: 10px;
            }

            .tabla-importes td {
                border: 0.5px solid #333;
                padding: 7px;
                text-align: left;
                font-size: 12px;
                letter-spacing: 0.5px;
                padding-left: 10px;
            }

            #tabla-cliente {
                margin-top: 10px;
            }

            #tabla-items {
                margin-top: 10px;
            }

            #tabla-items th {
                border: 0.5px solid #333;
                padding: 6px;
                text-align: center;
                font-size: 11px;
                letter-spacing: 0.5px;
                padding-left: 10px;
            }

            #tabla-items td {
                border: 0.5px solid #333;
                padding: 6px;
                text-align: center;
                font-size: 12px;
                letter-spacing: 0.5px;
                padding-left: 10px;
            }

            .ruc-emisor {
                position: relative;
                border: 1px solid #666;
                border-radius: 20px;
                text-align: center;
                vertical-align: top;

            }

            .ruc-emisor h4 {
                color: #444;
            }

            .v5 {
                width: 5%;
            }

            .v10 {
                width: 10%;
            }

            .v15 {
                width: 15%;
            }

            .v20 {
                width: 20%;
            }

            .v25 {
                width: 25%;
            }

            .v30 {
                width: 30%;
            }

            .v35 {
                width: 35%;
            }

            .v40 {
                width: 40%;
            }

            .v45 {
                width: 45%;
            }

            .v50 {
                width: 50%;
            }

            .v55 {
                width: 55%;
            }

            .v60 {
                width: 60%;
            }

            .v65 {
                width: 65%;
            }

            .v70 {
                width: 70%;
            }

            .v75 {
                width: 75%;
            }

            .v80 {
                width: 80%;
            }

            .v100 {
                width: 100%;
            }

            .direccion {
                font-size: 10px;
            }

            .total-letras {

                border: 0.5px solid #333;
                font-size: 9px;
                text-align: left;
                border-radius: 10px;
                padding: 10px;
                margin-top: 5px;
                padding-left: 10px;
            }

            .tabla-observacion {
                position: relative;
                margin-top: 5px;


            }

            .tabla-observacion td {
                position: relative;
                vertical-align: baseline;


            }

            .tabla-tipo-pago {
                width: 70%;
                border-collapse: collapse;
            }

            .tabla-tipo-pago td {
                border-bottom: 0.5px solid #333;


            }

            .col {
                background-color: #999;
            }

            .pie-pag {
                padding: 10px;
                font-size: 12px;
                border: 0.5px solid #333;
                margin-top: 10px;
                border-radius: 10px;
            }

            .b-l {
                border-radius: 7px 0px 0px 0px;
            }

            .b-r {
                border-radius: 0px 7px 0px 0px;
            }

            .mayu {
                text-transform: uppercase;
            }

            .anulado-print {
                position: absolute;
                top: 30%;
                left: 23%;
                color: #FF7979;
                font-size: 30px;
                text-align: center;
                font-weight: bold
            }

            .tabla-credito th {
                border: 0.5px solid #000;
                padding: 6px;
                text-align: center;
                font-size: 11px;
                letter-spacing: 0.5px;
                padding-left: 10px;
            }

            .tabla-credito td{
                border: 0.5px solid #000;
                padding: 7px;
                text-align: left;
                font-size: 12px;
                letter-spacing: 0.5px;
                padding-left: 10px;
            }

        .flex-container{
            display: inline-block;
        }

        .tabla_cuotas{
            margin-left: 10px;
        }

        .mb-2 {
            margin-bottom: 2px;
        }
        .mb-4 {
            margin-bottom: 4px;
        }
    </style>
</head>
<body style=\"margin: -5mm -5mm;;\" class=\"white-bg\">
    <page backtop=\"5mm\" backbottom=\"5mm\" backleft=\"5mm\" backright=\"5mm\">
        <!-- CABECERA COMPROBANTE=================== -->
        <table width=\"100%\" id=\"tabla-cabecera\">
            <tr>
                <!-- LOGO================== -->
                <td class=\"v25\">

                    <img class=\"v100\" src=\"";
        // line 463
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\ImageFilter')->toBase64(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 463, $this->source); })()), "system", [], "any", false, false, false, 463), "logo", [], "any", false, false, false, 463)), "html", null, true);
        yield "\" >


                </td>
                <!--FIN LOGO================== -->
                <td class=\"v45\">
                    <h3>";
        // line 469
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cp"]) || array_key_exists("cp", $context) ? $context["cp"] : (function () { throw new RuntimeError('Variable "cp" does not exist.', 469, $this->source); })()), "razonSocial", [], "any", false, false, false, 469), "html", null, true);
        yield "</h3>
                    <label class=\"direccion\"> ";
        // line 470
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["cp"]) || array_key_exists("cp", $context) ? $context["cp"] : (function () { throw new RuntimeError('Variable "cp" does not exist.', 470, $this->source); })()), "address", [], "any", false, false, false, 470), "direccion", [], "any", false, false, false, 470), "html", null, true);
        yield " </label>
                    <br>
                    <span class=\"direccion\"> ";
        // line 472
        yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 472, $this->source); })()), "user", [], "any", false, false, false, 472), "header", [], "any", false, false, false, 472);
        yield " </span>

                </td>
                <td class=\"v30\" style=\"text-align: left\">
                    <div class=\"ruc-emisor v100\">
                        <h4>R.U.C. ";
        // line 477
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cp"]) || array_key_exists("cp", $context) ? $context["cp"] : (function () { throw new RuntimeError('Variable "cp" does not exist.', 477, $this->source); })()), "ruc", [], "any", false, false, false, 477), "html", null, true);
        yield " </h4>
                        <h4>";
        // line 478
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["name"]) || array_key_exists("name", $context) ? $context["name"] : (function () { throw new RuntimeError('Variable "name" does not exist.', 478, $this->source); })()), "html", null, true);
        yield " ELECTRÓNICA </h4>
                        <h4>
                        ";
        // line 480
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 480, $this->source); })()), "serie", [], "any", false, false, false, 480), "html", null, true);
        yield "-";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 480, $this->source); })()), "correlativo", [], "any", false, false, false, 480), "html", null, true);
        yield "
                        </h4>
                    </div>
                </td>
            </tr>

        </table>
        ";
        // line 487
        $context["cl"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 487, $this->source); })()), "client", [], "any", false, false, false, 487);
        // line 488
        yield "        <!--CLIENTE COMPROBANTE=================== -->
        <div class=\"tabla_borde\">
            ";
        // line 490
        $context["cl"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 490, $this->source); })()), "client", [], "any", false, false, false, 490);
        // line 491
        yield "            <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                <tbody><tr>
                    <td width=\"60%\" align=\"left\"><strong>Razón Social:</strong>  ";
        // line 493
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cl"]) || array_key_exists("cl", $context) ? $context["cl"] : (function () { throw new RuntimeError('Variable "cl" does not exist.', 493, $this->source); })()), "rznSocial", [], "any", false, false, false, 493), "html", null, true);
        yield "</td>
                    <td width=\"40%\" align=\"left\"><strong>";
        // line 494
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\DocumentFilter')->getValueCatalog(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cl"]) || array_key_exists("cl", $context) ? $context["cl"] : (function () { throw new RuntimeError('Variable "cl" does not exist.', 494, $this->source); })()), "tipoDoc", [], "any", false, false, false, 494), "06"), "html", null, true);
        yield ":</strong>  ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cl"]) || array_key_exists("cl", $context) ? $context["cl"] : (function () { throw new RuntimeError('Variable "cl" does not exist.', 494, $this->source); })()), "numDoc", [], "any", false, false, false, 494), "html", null, true);
        yield "</td>
                </tr>
                <tr>
                    <td width=\"60%\" align=\"left\">
                        <strong>Fecha Emisión: </strong>  ";
        // line 498
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 498, $this->source); })()), "fechaEmision", [], "any", false, false, false, 498), "d/m/Y"), "html", null, true);
        yield "
                        ";
        // line 499
        if (($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 499, $this->source); })()), "fechaEmision", [], "any", false, false, false, 499), "H:i:s") != "00:00:00")) {
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 499, $this->source); })()), "fechaEmision", [], "any", false, false, false, 499), "H:i:s"), "html", null, true);
            yield " ";
        }
        // line 500
        yield "                        ";
        // line 503
        yield "                    </td>
                    <td width=\"40%\" align=\"left\"><strong>Dirección: </strong>  ";
        // line 504
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["cl"]) || array_key_exists("cl", $context) ? $context["cl"] : (function () { throw new RuntimeError('Variable "cl" does not exist.', 504, $this->source); })()), "address", [], "any", false, false, false, 504)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["cl"]) || array_key_exists("cl", $context) ? $context["cl"] : (function () { throw new RuntimeError('Variable "cl" does not exist.', 504, $this->source); })()), "address", [], "any", false, false, false, 504), "direccion", [], "any", false, false, false, 504), "html", null, true);
        }
        yield "</td>
                </tr>
                ";
        // line 506
        if ((isset($context["isNota"]) || array_key_exists("isNota", $context) ? $context["isNota"] : (function () { throw new RuntimeError('Variable "isNota" does not exist.', 506, $this->source); })())) {
            // line 507
            yield "                <tr>
                    <td width=\"60%\" align=\"left\"><strong>Tipo Doc. Ref.: </strong>  ";
            // line 508
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\DocumentFilter')->getValueCatalog(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 508, $this->source); })()), "tipDocAfectado", [], "any", false, false, false, 508), "01"), "html", null, true);
            yield "</td>
                    <td width=\"40%\" align=\"left\"><strong>Documento Ref.: </strong>  ";
            // line 509
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 509, $this->source); })()), "numDocfectado", [], "any", false, false, false, 509), "html", null, true);
            yield "</td>
                </tr>
                ";
        }
        // line 512
        yield "                <tr>
                    <td width=\"60%\" align=\"left\"><strong>Tipo Moneda: </strong>  ";
        // line 513
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\DocumentFilter')->getValueCatalog(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 513, $this->source); })()), "tipoMoneda", [], "any", false, false, false, 513), "021"), "html", null, true);
        yield " </td>
                    <td width=\"40%\" align=\"left\">";
        // line 514
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["doc"] ?? null), "compra", [], "any", true, true, false, 514) && CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 514, $this->source); })()), "compra", [], "any", false, false, false, 514))) {
            yield "<strong>O/C: </strong>  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 514, $this->source); })()), "compra", [], "any", false, false, false, 514), "html", null, true);
        }
        yield "</td>
                </tr>
                ";
        // line 516
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 516, $this->source); })()), "guias", [], "any", false, false, false, 516)) {
            // line 517
            yield "                <tr>
                    <td width=\"60%\" align=\"left\"><strong>Guias: </strong>
                    ";
            // line 519
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 519, $this->source); })()), "guias", [], "any", false, false, false, 519));
            foreach ($context['_seq'] as $context["_key"] => $context["guia"]) {
                // line 520
                yield "                        ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["guia"], "nroDoc", [], "any", false, false, false, 520), "html", null, true);
                yield "&nbsp;&nbsp;
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['guia'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 521
            yield "</td>
                    <td width=\"40%\"></td>
                </tr>
                ";
        }
        // line 525
        yield "                </tbody></table>
        </div><br>

        ";
        // line 528
        $context["moneda"] = $this->env->getRuntime('Greenter\Report\Filter\DocumentFilter')->getValueCatalog(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 528, $this->source); })()), "tipoMoneda", [], "any", false, false, false, 528), "02");
        // line 529
        yield "        <div class=\"tabla_borde\">
            <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                <tbody>
                    <tr>
                        <td align=\"center\" class=\"bold\">CANTIDAD</td>
                        <td align=\"center\" class=\"bold\">CÓDIGO</td>
                        <td align=\"center\" class=\"bold\">DESCRIPCIÓN</td>
                        <td align=\"center\" class=\"bold\">VALOR UNITARIO</td>
                        <td align=\"center\" class=\"bold\">VALOR TOTAL</td>
                    </tr>

                    ";
        // line 541
        yield "                    ";
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "user", [], "any", false, true, false, 541), "anticipos", [], "any", true, true, false, 541)) {
            // line 542
            yield "
                        ";
            // line 543
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 543, $this->source); })()), "user", [], "any", false, false, false, 543), "anticipos", [], "any", false, false, false, 543);
            yield "

                    ";
        }
        // line 546
        yield "
                 

                    ";
        // line 549
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 549, $this->source); })()), "details", [], "any", false, false, false, 549));
        foreach ($context['_seq'] as $context["_key"] => $context["det"]) {
            // line 550
            yield "                    <tr class=\"border_top\">
                        <td align=\"center\">
                            ";
            // line 552
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, $context["det"], "cantidad", [], "any", false, false, false, 552)), "html", null, true);
            yield "
                            ";
            // line 553
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["det"], "unidad", [], "any", false, false, false, 553), "html", null, true);
            yield "
                        </td>
                        <td align=\"center\">
                            ";
            // line 556
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["det"], "codProducto", [], "any", false, false, false, 556), "html", null, true);
            yield "
                        </td>
                        <td align=\"center\" width=\"300px\">
                            <span>";
            // line 559
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["det"], "descripcion", [], "any", false, false, false, 559), "html", null, true);
            yield "</span><br>
                        </td>
                        <td align=\"center\">
                            ";
            // line 562
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 562, $this->source); })()), "html", null, true);
            yield "
                            ";
            // line 563
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, $context["det"], "mtoValorUnitario", [], "any", false, false, false, 563)), "html", null, true);
            yield "
                        </td>
                        <td align=\"center\">
                            ";
            // line 566
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 566, $this->source); })()), "html", null, true);
            yield "
                            ";
            // line 567
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, $context["det"], "mtoValorVenta", [], "any", false, false, false, 567)), "html", null, true);
            yield "
                        </td>
                    </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['det'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 571
        yield "                </tbody>
            </table>
        </div>
        ";
        // line 575
        yield "
        <div class=\"total-letras\">

            ";
        // line 578
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\ResolveFilter')->getValueLegend(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 578, $this->source); })()), "legends", [], "any", false, false, false, 578), "1000"), "html", null, true);
        yield "

        </div>
        <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
            <tbody>
                <tr>
                    <td width=\"50%\" valign=\"top\">
                        <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                            <tbody>
                            <tr>
                                <td colspan=\"4\">
                                    <br>
                                    <br>
                                    <br>
                                    <strong>Información Adicional</strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                            <tbody>
                            <tr class=\"border_top\">
                                <td width=\"30%\" style=\"font-size: 10px;\">
                                    LEYENDA:
                                </td>
                                <td width=\"70%\" style=\"font-size: 10px;\">
                                    <p>

                                        ";
        // line 606
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 606, $this->source); })()), "legends", [], "any", false, false, false, 606));
        foreach ($context['_seq'] as $context["_key"] => $context["leg"]) {
            // line 607
            yield "                                        ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["leg"], "code", [], "any", false, false, false, 607) != "1000")) {
                // line 608
                yield "                                            ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["leg"], "value", [], "any", false, false, false, 608), "html", null, true);
                yield "<br>
                                        ";
            }
            // line 610
            yield "                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['leg'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 611
        yield "                                    </p>
                                </td>
                            </tr>
                            ";
        // line 614
        if ((isset($context["isNota"]) || array_key_exists("isNota", $context) ? $context["isNota"] : (function () { throw new RuntimeError('Variable "isNota" does not exist.', 614, $this->source); })())) {
            // line 615
            yield "                            <tr class=\"border_top\">
                                <td width=\"30%\" style=\"font-size: 10px;\">
                                    MOTIVO DE EMISIÓN:
                                </td>
                                <td width=\"70%\" style=\"font-size: 10px;\">
                                    ";
            // line 620
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 620, $this->source); })()), "desMotivo", [], "any", false, false, false, 620), "html", null, true);
            yield "
                                </td>
                            </tr>
                            ";
        }
        // line 624
        yield "                            ";
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "user", [], "any", false, true, false, 624), "extras", [], "any", true, true, false, 624)) {
            // line 625
            yield "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 625, $this->source); })()), "user", [], "any", false, false, false, 625), "extras", [], "any", false, false, false, 625));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 626
                yield "                                    <tr class=\"border_top\">
                                        <td width=\"30%\" style=\"font-size: 10px;\">
                                            ";
                // line 628
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "name", [], "any", false, false, false, 628)), "html", null, true);
                yield ":
                                        </td>
                                        <td width=\"70%\" style=\"font-size: 10px;\">
                                            ";
                // line 631
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "value", [], "any", false, false, false, 631), "html", null, true);
                yield "
                                        </td>
                                    </tr>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 635
            yield "                            ";
        }
        // line 636
        yield "                             <tr class=\"border_top\">
                                 <td width=\"30%\" style=\"font-size: 10px;\">

                                </td>
                                <td width=\"70%\" style=\"font-size: 10px;\">

                                </td>
                             </tr>
                            </tbody>
                        </table>
                        ";
        // line 646
        if ((isset($context["isAnticipo"]) || array_key_exists("isAnticipo", $context) ? $context["isAnticipo"] : (function () { throw new RuntimeError('Variable "isAnticipo" does not exist.', 646, $this->source); })())) {
            // line 647
            yield "                        <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                            <tbody>
                            <tr>
                                <td>
                                    <br>
                                    <strong>Anticipo</strong>
                                    <br>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" style=\"font-size: 10px;\">
                            <tbody>
                            <tr>
                                <td width=\"30%\"><b>Nro. Doc.</b></td>
                                <td width=\"70%\"><b>Total</b></td>
                            </tr>
                            ";
            // line 664
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 664, $this->source); })()), "anticipos", [], "any", false, false, false, 664));
            foreach ($context['_seq'] as $context["_key"] => $context["atp"]) {
                // line 665
                yield "                            <tr class=\"border_top\">
                                <td width=\"30%\">";
                // line 666
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["atp"], "nroDocRel", [], "any", false, false, false, 666), "html", null, true);
                yield "</td>
                                <td width=\"70%\">";
                // line 667
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 667, $this->source); })()), "html", null, true);
                yield " ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, $context["atp"], "total", [], "any", false, false, false, 667)), "html", null, true);
                yield "</td>
                            </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['atp'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 670
            yield "                            </tbody>
                        </table>
                        ";
        }
        // line 673
        yield "                    </td>
                    <td width=\"50%\" valign=\"top\">
                        <br>
                        <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"table table-valores-totales\">
                            <tbody>
                            ";
        // line 678
        if ((isset($context["isAnticipo"]) || array_key_exists("isAnticipo", $context) ? $context["isAnticipo"] : (function () { throw new RuntimeError('Variable "isAnticipo" does not exist.', 678, $this->source); })())) {
            // line 679
            yield "                                <tr class=\"border_bottom\">
                                    <td align=\"right\"><strong>Total Anticipo:</strong></td>
                                    <td width=\"120\" align=\"right\"><span>";
            // line 681
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 681, $this->source); })()), "html", null, true);
            yield "  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 681, $this->source); })()), "totalAnticipos", [], "any", false, false, false, 681)), "html", null, true);
            yield "</span></td>
                                </tr>
                            ";
        }
        // line 684
        yield "                            ";
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 684, $this->source); })()), "mtoOperGravadas", [], "any", false, false, false, 684)) {
            // line 685
            yield "                            <tr class=\"border_bottom\">

                                <td align=\"right\"><strong>Op. Gravadas:</strong></td>
                                <td width=\"120\" align=\"right\"><span>";
            // line 688
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 688, $this->source); })()), "html", null, true);
            yield "  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 688, $this->source); })()), "mtoOperGravadas", [], "any", false, false, false, 688)), "html", null, true);
            yield "</span></td>
                            </tr>
                            ";
        }
        // line 691
        yield "                            ";
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 691, $this->source); })()), "mtoOperInafectas", [], "any", false, false, false, 691)) {
            // line 692
            yield "                            <tr class=\"border_bottom\">
                                <td align=\"right\"><strong>Op. Inafectas:</strong></td>
                                <td width=\"120\" align=\"right\"><span>";
            // line 694
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 694, $this->source); })()), "html", null, true);
            yield "  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 694, $this->source); })()), "mtoOperInafectas", [], "any", false, false, false, 694)), "html", null, true);
            yield "</span></td>
                            </tr>
                            ";
        }
        // line 697
        yield "                            ";
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 697, $this->source); })()), "mtoOperExoneradas", [], "any", false, false, false, 697)) {
            // line 698
            yield "                            <tr class=\"border_bottom\">
                                <td align=\"right\"><strong>Op. Exoneradas:</strong></td>
                                <td width=\"120\" align=\"right\"><span>";
            // line 700
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 700, $this->source); })()), "html", null, true);
            yield "  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 700, $this->source); })()), "mtoOperExoneradas", [], "any", false, false, false, 700)), "html", null, true);
            yield "</span></td>
                            </tr>
                            ";
        }
        // line 703
        yield "                            <tr>
                                <td align=\"right\"><strong>I.G.V.";
        // line 704
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "user", [], "any", false, true, false, 704), "numIGV", [], "any", true, true, false, 704)) {
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 704, $this->source); })()), "user", [], "any", false, false, false, 704), "numIGV", [], "any", false, false, false, 704), "html", null, true);
            yield "%";
        }
        yield ":</strong></td>
                                <td width=\"120\" align=\"right\"><span>";
        // line 705
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 705, $this->source); })()), "html", null, true);
        yield "  ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 705, $this->source); })()), "mtoIGV", [], "any", false, false, false, 705)), "html", null, true);
        yield "</span></td>
                            </tr>
                            
                            ";
        // line 708
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 708, $this->source); })()), "descuentos", [], "any", false, false, false, 708)) {
            // line 709
            yield "                             ";
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 709, $this->source); })()), "user", [], "any", false, false, false, 709), "descuento", [], "any", false, false, false, 709);
            yield "
                            ";
        }
        // line 711
        yield "
                            ";
        // line 712
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 712, $this->source); })()), "mtoISC", [], "any", false, false, false, 712)) {
            // line 713
            yield "                            <tr>
                                <td align=\"right\"><strong>I.S.C.:</strong></td>
                                <td width=\"120\" align=\"right\"><span>";
            // line 715
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 715, $this->source); })()), "html", null, true);
            yield "  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 715, $this->source); })()), "mtoISC", [], "any", false, false, false, 715)), "html", null, true);
            yield "</span></td>
                            </tr>

                            ";
        }
        // line 719
        yield "                            ";
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 719, $this->source); })()), "sumOtrosCargos", [], "any", false, false, false, 719)) {
            // line 720
            yield "                                <tr>
                                    <td align=\"right\"><strong>Otros Cargos:</strong></td>
                                    <td width=\"120\" align=\"right\"><span>";
            // line 722
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 722, $this->source); })()), "html", null, true);
            yield "  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 722, $this->source); })()), "sumOtrosCargos", [], "any", false, false, false, 722)), "html", null, true);
            yield "</span></td>
                                </tr>
                            ";
        }
        // line 725
        yield "                            ";
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 725, $this->source); })()), "icbper", [], "any", false, false, false, 725)) {
            // line 726
            yield "                                <tr>
                                    <td align=\"right\"><strong>I.C.B.P.E.R.:</strong></td>
                                    <td width=\"120\" align=\"right\"><span>";
            // line 728
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 728, $this->source); })()), "html", null, true);
            yield "  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 728, $this->source); })()), "icbper", [], "any", false, false, false, 728)), "html", null, true);
            yield "</span></td>
                                </tr>
                            ";
        }
        // line 731
        yield "                            ";
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 731, $this->source); })()), "mtoOtrosTributos", [], "any", false, false, false, 731)) {
            // line 732
            yield "                                <tr>
                                    <td align=\"right\"><strong>Otros Tributos:</strong></td>
                                    <td width=\"120\" align=\"right\"><span>";
            // line 734
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 734, $this->source); })()), "html", null, true);
            yield "  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 734, $this->source); })()), "mtoOtrosTributos", [], "any", false, false, false, 734)), "html", null, true);
            yield "</span></td>
                                </tr>
                            ";
        }
        // line 737
        yield "                            <tr>
                                <td align=\"right\"><strong>Precio Venta:</strong></td>
                                <td width=\"120\" align=\"right\"><span id=\"ride-importeTotal\" class=\"ride-importeTotal\">";
        // line 739
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["moneda"]) || array_key_exists("moneda", $context) ? $context["moneda"] : (function () { throw new RuntimeError('Variable "moneda" does not exist.', 739, $this->source); })()), "html", null, true);
        yield "  ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 739, $this->source); })()), "mtoImpVenta", [], "any", false, false, false, 739)), "html", null, true);
        yield "</span></td>
                            </tr>
                            ";
        // line 741
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 741, $this->source); })()), "perception", [], "any", false, false, false, 741) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 741, $this->source); })()), "perception", [], "any", false, false, false, 741), "mto", [], "any", false, false, false, 741))) {
            // line 742
            yield "                                ";
            $context["perc"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 742, $this->source); })()), "perception", [], "any", false, false, false, 742);
            // line 743
            yield "                                ";
            $context["soles"] = $this->env->getRuntime('Greenter\Report\Filter\DocumentFilter')->getValueCatalog("PEN", "02");
            // line 744
            yield "                                <tr>
                                    <td align=\"right\"><strong>Percepción:</strong></td>
                                    <td width=\"120\" align=\"right\"><span>";
            // line 746
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["soles"]) || array_key_exists("soles", $context) ? $context["soles"] : (function () { throw new RuntimeError('Variable "soles" does not exist.', 746, $this->source); })()), "html", null, true);
            yield "  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["perc"]) || array_key_exists("perc", $context) ? $context["perc"] : (function () { throw new RuntimeError('Variable "perc" does not exist.', 746, $this->source); })()), "mto", [], "any", false, false, false, 746)), "html", null, true);
            yield "</span></td>
                                </tr>
                                <tr>
                                    <td align=\"right\"><strong>Total a Pagar:</strong></td>
                                    <td width=\"120\" align=\"right\"><span>";
            // line 750
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["soles"]) || array_key_exists("soles", $context) ? $context["soles"] : (function () { throw new RuntimeError('Variable "soles" does not exist.', 750, $this->source); })()), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\FormatFilter')->number(CoreExtension::getAttribute($this->env, $this->source, (isset($context["perc"]) || array_key_exists("perc", $context) ? $context["perc"] : (function () { throw new RuntimeError('Variable "perc" does not exist.', 750, $this->source); })()), "mtoTotal", [], "any", false, false, false, 750)), "html", null, true);
            yield "</span></td>
                                </tr>
                            ";
        }
        // line 753
        yield "                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
          ";
        // line 761
        yield "        ";
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "user", [], "any", false, true, false, 761), "detraccion", [], "any", true, true, false, 761)) {
            // line 762
            yield "

         ";
            // line 764
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 764, $this->source); })()), "user", [], "any", false, false, false, 764), "detraccion", [], "any", false, false, false, 764);
            yield "

        ";
        }
        // line 767
        yield "
         ";
        // line 769
        yield "        ";
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "user", [], "any", false, true, false, 769), "cuotas", [], "any", true, true, false, 769)) {
            // line 770
            yield "

         ";
            // line 772
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 772, $this->source); })()), "user", [], "any", false, false, false, 772), "cuotas", [], "any", false, false, false, 772);
            yield "

        ";
        }
        // line 775
        yield "
        ";
        // line 776
        if ((array_key_exists("max_items", $context) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 776, $this->source); })()), "details", [], "any", false, false, false, 776)) > (isset($context["max_items"]) || array_key_exists("max_items", $context) ? $context["max_items"] : (function () { throw new RuntimeError('Variable "max_items" does not exist.', 776, $this->source); })())))) {
            // line 777
            yield "            ";
            // line 778
            yield "            <div class=\"page-break\"></div>
        ";
        }
        // line 780
        yield "
        <div>
            <hr style=\"display: block; height: 1px; border: 0; border-top: 1px solid #666; margin: 20px 0; padding: 0;\">
            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                <tbody>
                    <tr>
                        <td width=\"85%\">
                            <blockquote>
                                ";
        // line 788
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "user", [], "any", false, true, false, 788), "footer", [], "any", true, true, false, 788)) {
            // line 789
            yield "                                    ";
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 789, $this->source); })()), "user", [], "any", false, false, false, 789), "footer", [], "any", false, false, false, 789);
            yield "
                                ";
        }
        // line 791
        yield "                                ";
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "system", [], "any", false, true, false, 791), "hash", [], "any", true, true, false, 791) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 791, $this->source); })()), "system", [], "any", false, false, false, 791), "hash", [], "any", false, false, false, 791))) {
            // line 792
            yield "                                    <strong>Resumen:</strong>   ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 792, $this->source); })()), "system", [], "any", false, false, false, 792), "hash", [], "any", false, false, false, 792), "html", null, true);
            yield "<br>
                                ";
        }
        // line 794
        yield "                                <span>Representación Impresa de la ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["name"]) || array_key_exists("name", $context) ? $context["name"] : (function () { throw new RuntimeError('Variable "name" does not exist.', 794, $this->source); })()), "html", null, true);
        yield " ELECTRÓNICA.</span>
                            </blockquote>
                        </td>
                        <td width=\"15%\" align=\"right\">
                            <img src=\"";
        // line 798
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\ImageFilter')->toBase64($this->env->getRuntime('Greenter\Report\Render\QrRender')->getImage((isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 798, $this->source); })())), "svg+xml"), "html", null, true);
        yield "\" alt=\"Qr Image\">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </page>





</body>

</html>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "invoice.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  1212 => 798,  1204 => 794,  1198 => 792,  1195 => 791,  1189 => 789,  1187 => 788,  1177 => 780,  1173 => 778,  1171 => 777,  1169 => 776,  1166 => 775,  1160 => 772,  1156 => 770,  1153 => 769,  1150 => 767,  1144 => 764,  1140 => 762,  1137 => 761,  1128 => 753,  1120 => 750,  1111 => 746,  1107 => 744,  1104 => 743,  1101 => 742,  1099 => 741,  1092 => 739,  1088 => 737,  1080 => 734,  1076 => 732,  1073 => 731,  1065 => 728,  1061 => 726,  1058 => 725,  1050 => 722,  1046 => 720,  1043 => 719,  1034 => 715,  1030 => 713,  1028 => 712,  1025 => 711,  1019 => 709,  1017 => 708,  1009 => 705,  1001 => 704,  998 => 703,  990 => 700,  986 => 698,  983 => 697,  975 => 694,  971 => 692,  968 => 691,  960 => 688,  955 => 685,  952 => 684,  944 => 681,  940 => 679,  938 => 678,  931 => 673,  926 => 670,  915 => 667,  911 => 666,  908 => 665,  904 => 664,  885 => 647,  883 => 646,  871 => 636,  868 => 635,  858 => 631,  852 => 628,  848 => 626,  843 => 625,  840 => 624,  833 => 620,  826 => 615,  824 => 614,  819 => 611,  813 => 610,  807 => 608,  804 => 607,  800 => 606,  769 => 578,  764 => 575,  759 => 571,  749 => 567,  745 => 566,  739 => 563,  735 => 562,  729 => 559,  723 => 556,  717 => 553,  713 => 552,  709 => 550,  705 => 549,  700 => 546,  694 => 543,  691 => 542,  688 => 541,  675 => 529,  673 => 528,  668 => 525,  662 => 521,  653 => 520,  649 => 519,  645 => 517,  643 => 516,  635 => 514,  631 => 513,  628 => 512,  622 => 509,  618 => 508,  615 => 507,  613 => 506,  606 => 504,  603 => 503,  601 => 500,  595 => 499,  591 => 498,  582 => 494,  578 => 493,  574 => 491,  572 => 490,  568 => 488,  566 => 487,  554 => 480,  549 => 478,  545 => 477,  537 => 472,  532 => 470,  528 => 469,  519 => 463,  59 => 10,  54 => 7,  52 => 6,  50 => 5,  48 => 4,  46 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "invoice.html.twig", "C:\\laragon2\\www\\talentus\\resources\\views\\templates\\comprobantes\\invoice.html.twig");
    }
}
