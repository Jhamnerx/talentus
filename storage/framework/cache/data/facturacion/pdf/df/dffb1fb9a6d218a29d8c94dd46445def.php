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

/* despatch.html.twig */
class __TwigTemplate_e4da2fbe05ce93424a3bc5aff0f48639 extends Template
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
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
    <style type=\"text/css\">
        ";
        // line 5
        yield from $this->loadTemplate("assets/style.css", "despatch.html.twig", 5)->unwrap()->yield($context);
        yield "td{padding: 3px;}

        .tabla_extra{
            margin-left: 10px;
        }
       .v100 {
                width: 100%;
        }
        .v80 {
                width: 80%;
        }
        .v50 {
                width: 50%;
        }
        .tabla_extra th {
            border: 0.5px solid #000;
            padding: 6px;
            text-align: center;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding-left: 10px;
        }

        .tabla_extra td{
            border: 1px solid #000;
            padding: 7px;
            text-align: left;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding-left: 10px;
        }

        .border_bottom{
            border-bottom:1px solid #000
        }
    </style>
</head>
<body class=\"white-bg\">
";
        // line 43
        $context["cp"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 43, $this->source); })()), "company", [], "any", false, false, false, 43);
        // line 44
        $context["name"] = $this->env->getRuntime('Greenter\Report\Filter\DocumentFilter')->getValueCatalog(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 44, $this->source); })()), "tipoDoc", [], "any", false, false, false, 44), "01");
        // line 45
        yield "<table width=\"100%\">
    <tbody><tr>
        <td style=\"padding:30px; !important\">
            <table width=\"100%\" height=\"200px\" border=\"0\" aling=\"center\" cellpadding=\"0\" cellspacing=\"0\">
                <tbody><tr>
                    <td width=\"50%\" height=\"90\" align=\"center\">
                        <span><img src=\"";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\ImageFilter')->toBase64(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 51, $this->source); })()), "system", [], "any", false, false, false, 51), "logo", [], "any", false, false, false, 51)), "html", null, true);
        yield "\" height=\"80\" style=\"text-align:center\" border=\"0\"></span>
                    </td>
                    <td width=\"5%\" height=\"40\" align=\"center\"></td>
                    <td width=\"45%\" rowspan=\"2\" valign=\"bottom\" style=\"padding-left:0\">
                        <div class=\"tabla_borde\">
                            <table width=\"100%\" border=\"0\" height=\"200\" cellpadding=\"6\" cellspacing=\"0\">
                                <tbody><tr>
                                    <td align=\"center\">
                                        <span style=\"font-family:Tahoma, Geneva, sans-serif; font-size:29px\" text-align=\"center\">";
        // line 59
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["name"]) || array_key_exists("name", $context) ? $context["name"] : (function () { throw new RuntimeError('Variable "name" does not exist.', 59, $this->source); })()), "html", null, true);
        yield "</span>
                                        <br>
                                        <span style=\"font-family:Tahoma, Geneva, sans-serif; font-size:19px\" text-align=\"center\">E L E C T R Ó N I C A</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align=\"center\">
                                        <span style=\"font-size:15px\" text-align=\"center\">R.U.C.: ";
        // line 66
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cp"]) || array_key_exists("cp", $context) ? $context["cp"] : (function () { throw new RuntimeError('Variable "cp" does not exist.', 66, $this->source); })()), "ruc", [], "any", false, false, false, 66), "html", null, true);
        yield "</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align=\"center\">
                                        <span style=\"font-size:24px\">";
        // line 71
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 71, $this->source); })()), "serie", [], "any", false, false, false, 71), "html", null, true);
        yield "-";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 71, $this->source); })()), "correlativo", [], "any", false, false, false, 71), "html", null, true);
        yield "</span>
                                    </td>
                                </tr>
                                </tbody></table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td valign=\"bottom\" style=\"padding-left:0\">
                        <div class=\"tabla_borde\">
                            <table width=\"96%\" height=\"100%\" border=\"0\" border-radius=\"\" cellpadding=\"9\" cellspacing=\"0\">
                                <tbody><tr>
                                    <td align=\"center\">
                                        <strong><span style=\"font-size:15px\">";
        // line 84
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cp"]) || array_key_exists("cp", $context) ? $context["cp"] : (function () { throw new RuntimeError('Variable "cp" does not exist.', 84, $this->source); })()), "razonSocial", [], "any", false, false, false, 84), "html", null, true);
        yield "</span></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td align=\"left\">
                                        <strong>Dirección: </strong>";
        // line 89
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["cp"]) || array_key_exists("cp", $context) ? $context["cp"] : (function () { throw new RuntimeError('Variable "cp" does not exist.', 89, $this->source); })()), "address", [], "any", false, false, false, 89), "direccion", [], "any", false, false, false, 89), "html", null, true);
        yield "
                                    </td>
                                </tr>
                                <tr>
                                    <td align=\"left\">
                                        ";
        // line 94
        yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 94, $this->source); })()), "user", [], "any", false, false, false, 94), "header", [], "any", false, false, false, 94);
        yield "
                                    </td>
                                </tr>
                                </tbody></table>
                        </div>
                    </td>
                </tr>
                </tbody></table>
            <br>
            <div class=\"tabla_borde\">
                ";
        // line 104
        $context["cl"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 104, $this->source); })()), "destinatario", [], "any", false, false, false, 104);
        // line 105
        yield "                <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                    <tbody>
                    <tr>
                        <td colspan=\"2\">DESTINATARIO</td>
                    </tr>
                    <tr class=\"border_top\">
                        <td width=\"60%\" align=\"left\"><strong>Razón Social:</strong>  ";
        // line 111
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cl"]) || array_key_exists("cl", $context) ? $context["cl"] : (function () { throw new RuntimeError('Variable "cl" does not exist.', 111, $this->source); })()), "rznSocial", [], "any", false, false, false, 111), "html", null, true);
        yield "</td>
                        <td width=\"40%\" align=\"left\"><strong>";
        // line 112
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\DocumentFilter')->getValueCatalog(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cl"]) || array_key_exists("cl", $context) ? $context["cl"] : (function () { throw new RuntimeError('Variable "cl" does not exist.', 112, $this->source); })()), "tipoDoc", [], "any", false, false, false, 112), "06"), "html", null, true);
        yield ":</strong>  ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["cl"]) || array_key_exists("cl", $context) ? $context["cl"] : (function () { throw new RuntimeError('Variable "cl" does not exist.', 112, $this->source); })()), "numDoc", [], "any", false, false, false, 112), "html", null, true);
        yield "</td>
                    </tr>
                    <tr>
                        <td width=\"40%\" align=\"left\" colspan=\"2\"><strong>Dirección:</strong>  ";
        // line 115
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["cl"]) || array_key_exists("cl", $context) ? $context["cl"] : (function () { throw new RuntimeError('Variable "cl" does not exist.', 115, $this->source); })()), "address", [], "any", false, false, false, 115)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["cl"]) || array_key_exists("cl", $context) ? $context["cl"] : (function () { throw new RuntimeError('Variable "cl" does not exist.', 115, $this->source); })()), "address", [], "any", false, false, false, 115), "direccion", [], "any", false, false, false, 115), "html", null, true);
        }
        yield "</td>
                    </tr>
                    </tbody></table>
            </div><br>
            <div class=\"tabla_borde\">
                ";
        // line 120
        $context["cl"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 120, $this->source); })()), "destinatario", [], "any", false, false, false, 120);
        // line 121
        yield "                <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                    <tbody>
                    <tr>
                        <td colspan=\"2\">ENVIO</td>
                    </tr>
                    <tr class=\"border_top\">
                        <td width=\"60%\" align=\"left\">
                            <strong>Fecha Emisión:</strong>  ";
        // line 128
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 128, $this->source); })()), "fechaEmision", [], "any", false, false, false, 128), "d/m/Y"), "html", null, true);
        yield "
                        </td>
                        <td width=\"40%\" align=\"left\"><strong>Fecha Inicio de Traslado:</strong>  ";
        // line 130
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 130, $this->source); })()), "envio", [], "any", false, false, false, 130), "fecTraslado", [], "any", false, false, false, 130), "d/m/Y"), "html", null, true);
        yield " </td>
                    </tr>
                    <tr>
                        <td width=\"60%\" align=\"left\"><strong>Motivo Traslado:</strong>  ";
        // line 133
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 133, $this->source); })()), "envio", [], "any", false, false, false, 133), "desTraslado", [], "any", false, false, false, 133), "html", null, true);
        yield " </td>
                        <td width=\"40%\" align=\"left\"><strong>Modalidad de Transporte:</strong>  ";
        // line 134
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 134, $this->source); })()), "envio", [], "any", false, false, false, 134), "modTraslado", [], "any", false, false, false, 134) == "02")) ? ("TRANSPORTE PRIVADO") : ("TRANSPORTE PUBLICO"));
        yield " </td>
                    </tr>
                    <tr>
                        <td width=\"60%\" align=\"left\"><strong>Peso Bruto Total (";
        // line 137
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 137, $this->source); })()), "envio", [], "any", false, false, false, 137), "undPesoTotal", [], "any", false, false, false, 137), "html", null, true);
        yield "):</strong>  ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 137, $this->source); })()), "envio", [], "any", false, false, false, 137), "pesoTotal", [], "any", false, false, false, 137), "html", null, true);
        yield " </td>
                        <td width=\"40%\">";
        // line 138
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 138, $this->source); })()), "envio", [], "any", false, false, false, 138), "numBultos", [], "any", false, false, false, 138)) {
            yield "<strong>Número de Bultos:</strong>  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 138, $this->source); })()), "envio", [], "any", false, false, false, 138), "numBultos", [], "any", false, false, false, 138), "html", null, true);
        }
        yield "</td>
                    </tr>
                    <tr>
                        <td width=\"60%\" align=\"left\"><strong>P. Partida:</strong>  ";
        // line 141
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 141, $this->source); })()), "envio", [], "any", false, false, false, 141), "partida", [], "any", false, false, false, 141), "ubigueo", [], "any", false, false, false, 141), "html", null, true);
        yield " - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 141, $this->source); })()), "envio", [], "any", false, false, false, 141), "partida", [], "any", false, false, false, 141), "direccion", [], "any", false, false, false, 141), "html", null, true);
        yield "</td>
                        <td width=\"40%\" align=\"left\"><strong>P. Llegada: </strong>  ";
        // line 142
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 142, $this->source); })()), "envio", [], "any", false, false, false, 142), "llegada", [], "any", false, false, false, 142), "ubigueo", [], "any", false, false, false, 142), "html", null, true);
        yield " - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 142, $this->source); })()), "envio", [], "any", false, false, false, 142), "llegada", [], "any", false, false, false, 142), "direccion", [], "any", false, false, false, 142), "html", null, true);
        yield "</td>
                    </tr>
                    </tbody></table>
            </div><br>
            ";
        // line 146
        $context["tr"] = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 146, $this->source); })()), "envio", [], "any", false, false, false, 146), "transportista", [], "any", false, false, false, 146);
        // line 147
        yield "            ";
        if ((isset($context["tr"]) || array_key_exists("tr", $context) ? $context["tr"] : (function () { throw new RuntimeError('Variable "tr" does not exist.', 147, $this->source); })())) {
            // line 148
            yield "            <div class=\"tabla_borde\">
                <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                    <tbody>
                    <tr>
                        <td colspan=\"2\">TRANSPORTE</td>
                    </tr>
                    <tr class=\"border_top\">
                        <td width=\"60%\" align=\"left\"><strong>Razón Social:</strong>  ";
            // line 155
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tr"]) || array_key_exists("tr", $context) ? $context["tr"] : (function () { throw new RuntimeError('Variable "tr" does not exist.', 155, $this->source); })()), "rznSocial", [], "any", false, false, false, 155), "html", null, true);
            yield "</td>
                        <td width=\"40%\" align=\"left\"><strong>";
            // line 156
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\DocumentFilter')->getValueCatalog(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tr"]) || array_key_exists("tr", $context) ? $context["tr"] : (function () { throw new RuntimeError('Variable "tr" does not exist.', 156, $this->source); })()), "tipoDoc", [], "any", false, false, false, 156), "06"), "html", null, true);
            yield ":</strong>  ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tr"]) || array_key_exists("tr", $context) ? $context["tr"] : (function () { throw new RuntimeError('Variable "tr" does not exist.', 156, $this->source); })()), "numDoc", [], "any", false, false, false, 156), "html", null, true);
            yield "</td>
                    </tr>
                    <tr>
                        <td width=\"60%\" align=\"left\"><strong>Vehiculo:</strong>  ";
            // line 159
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tr"]) || array_key_exists("tr", $context) ? $context["tr"] : (function () { throw new RuntimeError('Variable "tr" does not exist.', 159, $this->source); })()), "placa", [], "any", false, false, false, 159), "html", null, true);
            yield "</td>
                        <td width=\"40%\" align=\"left\"><strong>Conductor:</strong>  ";
            // line 160
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Greenter\Report\Filter\DocumentFilter')->getValueCatalog(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tr"]) || array_key_exists("tr", $context) ? $context["tr"] : (function () { throw new RuntimeError('Variable "tr" does not exist.', 160, $this->source); })()), "choferTipoDoc", [], "any", false, false, false, 160), "06"), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tr"]) || array_key_exists("tr", $context) ? $context["tr"] : (function () { throw new RuntimeError('Variable "tr" does not exist.', 160, $this->source); })()), "choferDoc", [], "any", false, false, false, 160), "html", null, true);
            yield "</td>
                    </tr>
                    </tbody></table>
            </div><br>
            ";
        }
        // line 165
        yield "            <div class=\"tabla_borde\">
                <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                    <tbody>
                    <tr>
                        <td align=\"center\" class=\"bold\">Item</td>
                        <td align=\"center\" class=\"bold\">Código</td>
                        <td align=\"center\" class=\"bold\" width=\"300px\">Descripción</td>
                        <td align=\"center\" class=\"bold\">Unidad</td>
                        <td align=\"center\" class=\"bold\">Cantidad</td>
                    </tr>
                        ";
        // line 175
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 175, $this->source); })()), "details", [], "any", false, false, false, 175));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["det"]) {
            // line 176
            yield "                        <tr class=\"border_top\">
                            <td align=\"center\">";
            // line 177
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 177), "html", null, true);
            yield "</td>
                            <td align=\"center\">";
            // line 178
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["det"], "codigo", [], "any", false, false, false, 178), "html", null, true);
            yield "</td>
                            <td align=\"center\">";
            // line 179
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["det"], "descripcion", [], "any", false, false, false, 179), "html", null, true);
            yield "</td>
                            <td align=\"center\">";
            // line 180
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["det"], "unidad", [], "any", false, false, false, 180), "html", null, true);
            yield "</td>
                            <td align=\"center\">";
            // line 181
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["det"], "cantidad", [], "any", false, false, false, 181), "html", null, true);
            yield "</td>
                        </tr>
                        ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['det'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 184
        yield "                    </tbody>
                </table></div>
            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                <tbody><tr>
                    <td width=\"50%\" valign=\"top\">
                        <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                            <tbody>
                            <tr>
                                <td colspan=\"4\">
                                ";
        // line 193
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 193, $this->source); })()), "observacion", [], "any", false, false, false, 193)) {
            // line 194
            yield "                                    <br><br>
                                    <span style=\"font-family:Tahoma, Geneva, sans-serif; font-size:12px\" text-align=\"center\"><strong>Observaciones</strong></span>
                                    <br>
                                    <p>";
            // line 197
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 197, $this->source); })()), "observacion", [], "any", false, false, false, 197), "html", null, true);
            yield "</p>
                                ";
        }
        // line 199
        yield "                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width=\"50%\" valign=\"top\"></td>
                </tr>
                </tbody></table>
            ";
        // line 207
        if ((array_key_exists("max_items", $context) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["doc"]) || array_key_exists("doc", $context) ? $context["doc"] : (function () { throw new RuntimeError('Variable "doc" does not exist.', 207, $this->source); })()), "details", [], "any", false, false, false, 207)) > (isset($context["max_items"]) || array_key_exists("max_items", $context) ? $context["max_items"] : (function () { throw new RuntimeError('Variable "max_items" does not exist.', 207, $this->source); })())))) {
            // line 208
            yield "                <div style=\"page-break-after:always;\"></div>
            ";
        }
        // line 210
        yield "            <div>
          ";
        // line 212
        yield "        ";
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "user", [], "any", false, true, false, 212), "dispositivos", [], "any", true, true, false, 212)) {
            // line 213
            yield "

         ";
            // line 215
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 215, $this->source); })()), "user", [], "any", false, false, false, 215), "dispositivos", [], "any", false, false, false, 215);
            yield "

        ";
        }
        // line 218
        yield "
            <table>
                <tbody>
                <tr>
                    <td width=\"100%\">
                        <blockquote>
                            ";
        // line 224
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "user", [], "any", false, true, false, 224), "footer", [], "any", true, true, false, 224)) {
            // line 225
            yield "                                ";
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 225, $this->source); })()), "user", [], "any", false, false, false, 225), "footer", [], "any", false, false, false, 225);
            yield "
                            ";
        }
        // line 227
        yield "                            ";
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "system", [], "any", false, true, false, 227), "hash", [], "any", true, true, false, 227) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 227, $this->source); })()), "system", [], "any", false, false, false, 227), "hash", [], "any", false, false, false, 227))) {
            // line 228
            yield "                                <strong>Resumen:</strong>   ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 228, $this->source); })()), "system", [], "any", false, false, false, 228), "hash", [], "any", false, false, false, 228), "html", null, true);
            yield "<br>
                            ";
        }
        // line 230
        yield "                            <span>Representación Impresa de la ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["name"]) || array_key_exists("name", $context) ? $context["name"] : (function () { throw new RuntimeError('Variable "name" does not exist.', 230, $this->source); })()), "html", null, true);
        yield " ELECTRÓNICA.</span>
                        </blockquote>
                    </td>
                    ";
        // line 234
        yield "                    ";
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["params"] ?? null), "user", [], "any", false, true, false, 234), "qr", [], "any", true, true, false, 234)) {
            // line 235
            yield "

                    ";
            // line 237
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["params"]) || array_key_exists("params", $context) ? $context["params"] : (function () { throw new RuntimeError('Variable "params" does not exist.', 237, $this->source); })()), "user", [], "any", false, false, false, 237), "qr", [], "any", false, false, false, 237);
            yield "

                    ";
        }
        // line 240
        yield "                </tr>
                </tbody></table>
            </div>
        </td>
    </tr>
    </tbody></table>
</body></html>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "despatch.html.twig";
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
        return array (  476 => 240,  470 => 237,  466 => 235,  463 => 234,  456 => 230,  450 => 228,  447 => 227,  441 => 225,  439 => 224,  431 => 218,  425 => 215,  421 => 213,  418 => 212,  415 => 210,  411 => 208,  409 => 207,  399 => 199,  394 => 197,  389 => 194,  387 => 193,  376 => 184,  359 => 181,  355 => 180,  351 => 179,  347 => 178,  343 => 177,  340 => 176,  323 => 175,  311 => 165,  301 => 160,  297 => 159,  289 => 156,  285 => 155,  276 => 148,  273 => 147,  271 => 146,  262 => 142,  256 => 141,  247 => 138,  241 => 137,  235 => 134,  231 => 133,  225 => 130,  220 => 128,  211 => 121,  209 => 120,  199 => 115,  191 => 112,  187 => 111,  179 => 105,  177 => 104,  164 => 94,  156 => 89,  148 => 84,  130 => 71,  122 => 66,  112 => 59,  101 => 51,  93 => 45,  91 => 44,  89 => 43,  48 => 5,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "despatch.html.twig", "C:\\laragon2\\www\\talentus\\resources\\views\\templates\\guia-remision\\despatch.html.twig");
    }
}
