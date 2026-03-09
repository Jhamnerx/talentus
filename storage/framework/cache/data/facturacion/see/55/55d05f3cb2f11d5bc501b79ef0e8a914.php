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

/* voided.xml.twig */
class __TwigTemplate_5ac1e17ffc03a69808f92d910b4cfc59 extends Template
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
        $_v0 = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 2
            yield "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<VoidedDocuments xmlns=\"urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1\" xmlns:cac=\"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2\" xmlns:cbc=\"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2\" xmlns:ext=\"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2\" xmlns:sac=\"urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1\" xmlns:ds=\"http://www.w3.org/2000/09/xmldsig#\">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionContent/>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    <cbc:UBLVersionID>2.0</cbc:UBLVersionID>
    <cbc:CustomizationID>1.0</cbc:CustomizationID>
    <cbc:ID>";
            // line 11
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["doc"] ?? null), "xmlId", [], "any", false, false, false, 11);
            yield "</cbc:ID>
    <cbc:ReferenceDate>";
            // line 12
            yield $this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["doc"] ?? null), "fecGeneracion", [], "any", false, false, false, 12), "Y-m-d");
            yield "</cbc:ReferenceDate>
    <cbc:IssueDate>";
            // line 13
            yield $this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["doc"] ?? null), "fecComunicacion", [], "any", false, false, false, 13), "Y-m-d");
            yield "</cbc:IssueDate>
    ";
            // line 14
            $context["emp"] = CoreExtension::getAttribute($this->env, $this->source, ($context["doc"] ?? null), "company", [], "any", false, false, false, 14);
            // line 15
            yield "    <cac:Signature>
        <cbc:ID>SIGN";
            // line 16
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["emp"] ?? null), "ruc", [], "any", false, false, false, 16);
            yield "</cbc:ID>
        <cac:SignatoryParty>
            <cac:PartyIdentification>
                <cbc:ID>";
            // line 19
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["emp"] ?? null), "ruc", [], "any", false, false, false, 19);
            yield "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA[";
            // line 22
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["emp"] ?? null), "razonSocial", [], "any", false, false, false, 22);
            yield "]]></cbc:Name>
            </cac:PartyName>
        </cac:SignatoryParty>
        <cac:DigitalSignatureAttachment>
            <cac:ExternalReference>
                <cbc:URI>#GREENTER-SIGN</cbc:URI>
            </cac:ExternalReference>
        </cac:DigitalSignatureAttachment>
    </cac:Signature>
    <cac:AccountingSupplierParty>
        <cbc:CustomerAssignedAccountID>";
            // line 32
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["emp"] ?? null), "ruc", [], "any", false, false, false, 32);
            yield "</cbc:CustomerAssignedAccountID>
        <cbc:AdditionalAccountID>6</cbc:AdditionalAccountID>
        <cac:Party>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[";
            // line 36
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["emp"] ?? null), "razonSocial", [], "any", false, false, false, 36);
            yield "]]></cbc:RegistrationName>
            </cac:PartyLegalEntity>
        </cac:Party>
    </cac:AccountingSupplierParty>
    ";
            // line 40
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["doc"] ?? null), "details", [], "any", false, false, false, 40));
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
                // line 41
                yield "    <sac:VoidedDocumentsLine>
        <cbc:LineID>";
                // line 42
                yield CoreExtension::getAttribute($this->env, $this->source, ($context["loop"] ?? null), "index", [], "any", false, false, false, 42);
                yield "</cbc:LineID>
        <cbc:DocumentTypeCode>";
                // line 43
                yield CoreExtension::getAttribute($this->env, $this->source, ($context["det"] ?? null), "tipoDoc", [], "any", false, false, false, 43);
                yield "</cbc:DocumentTypeCode>
        <sac:DocumentSerialID>";
                // line 44
                yield CoreExtension::getAttribute($this->env, $this->source, ($context["det"] ?? null), "serie", [], "any", false, false, false, 44);
                yield "</sac:DocumentSerialID>
        <sac:DocumentNumberID>";
                // line 45
                yield CoreExtension::getAttribute($this->env, $this->source, ($context["det"] ?? null), "correlativo", [], "any", false, false, false, 45);
                yield "</sac:DocumentNumberID>
        <sac:VoidReasonDescription><![CDATA[";
                // line 46
                yield CoreExtension::getAttribute($this->env, $this->source, ($context["det"] ?? null), "desMotivoBaja", [], "any", false, false, false, 46);
                yield "]]></sac:VoidReasonDescription>
    </sac:VoidedDocumentsLine>
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
            // line 49
            yield "</VoidedDocuments>
";
            yield from [];
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 1
        yield Twig\Extension\CoreExtension::spaceless($_v0);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "voided.xml.twig";
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
        return array (  169 => 1,  164 => 49,  147 => 46,  143 => 45,  139 => 44,  135 => 43,  131 => 42,  128 => 41,  111 => 40,  104 => 36,  97 => 32,  84 => 22,  78 => 19,  72 => 16,  69 => 15,  67 => 14,  63 => 13,  59 => 12,  55 => 11,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% apply spaceless %}
<?xml version=\"1.0\" encoding=\"utf-8\"?>
<VoidedDocuments xmlns=\"urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1\" xmlns:cac=\"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2\" xmlns:cbc=\"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2\" xmlns:ext=\"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2\" xmlns:sac=\"urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1\" xmlns:ds=\"http://www.w3.org/2000/09/xmldsig#\">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionContent/>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    <cbc:UBLVersionID>2.0</cbc:UBLVersionID>
    <cbc:CustomizationID>1.0</cbc:CustomizationID>
    <cbc:ID>{{ doc.xmlId }}</cbc:ID>
    <cbc:ReferenceDate>{{ doc.fecGeneracion|date('Y-m-d') }}</cbc:ReferenceDate>
    <cbc:IssueDate>{{ doc.fecComunicacion|date('Y-m-d') }}</cbc:IssueDate>
    {% set emp = doc.company %}
    <cac:Signature>
        <cbc:ID>SIGN{{ emp.ruc }}</cbc:ID>
        <cac:SignatoryParty>
            <cac:PartyIdentification>
                <cbc:ID>{{ emp.ruc }}</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA[{{ emp.razonSocial|raw }}]]></cbc:Name>
            </cac:PartyName>
        </cac:SignatoryParty>
        <cac:DigitalSignatureAttachment>
            <cac:ExternalReference>
                <cbc:URI>#GREENTER-SIGN</cbc:URI>
            </cac:ExternalReference>
        </cac:DigitalSignatureAttachment>
    </cac:Signature>
    <cac:AccountingSupplierParty>
        <cbc:CustomerAssignedAccountID>{{ emp.ruc }}</cbc:CustomerAssignedAccountID>
        <cbc:AdditionalAccountID>6</cbc:AdditionalAccountID>
        <cac:Party>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[{{ emp.razonSocial|raw }}]]></cbc:RegistrationName>
            </cac:PartyLegalEntity>
        </cac:Party>
    </cac:AccountingSupplierParty>
    {% for det in doc.details %}
    <sac:VoidedDocumentsLine>
        <cbc:LineID>{{ loop.index }}</cbc:LineID>
        <cbc:DocumentTypeCode>{{ det.tipoDoc }}</cbc:DocumentTypeCode>
        <sac:DocumentSerialID>{{ det.serie }}</sac:DocumentSerialID>
        <sac:DocumentNumberID>{{ det.correlativo }}</sac:DocumentNumberID>
        <sac:VoidReasonDescription><![CDATA[{{ det.desMotivoBaja|raw }}]]></sac:VoidReasonDescription>
    </sac:VoidedDocumentsLine>
    {% endfor %}
</VoidedDocuments>
{% endapply %}", "voided.xml.twig", "C:\\laragon2\\www\\talentus\\vendor\\greenter\\greenter\\packages\\xml\\src\\Xml\\Templates\\voided.xml.twig");
    }
}
