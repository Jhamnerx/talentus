# Descargar PDF (SUNAT) - Documentación

[Skip to main content](#content-area)

[Documentación home page![light logo](https://mintcdn.com/factiliza/7a7xBG97tl9T-ulm/logo/light.svg?fit=max&auto=format&n=7a7xBG97tl9T-ulm&q=85&s=10c8c9f95e3b798949a9a57b354879a4)![dark logo](https://mintcdn.com/factiliza/7a7xBG97tl9T-ulm/logo/dark.svg?fit=max&auto=format&n=7a7xBG97tl9T-ulm&q=85&s=9cedaa9b0ee4870db9b91fc96a025f8c)](/)

Search...

Ctrl K

Search...

Navigation

API Consulta

Descargar PDF (SUNAT)

[API Consulta

](/api-consulta/endpoint/dni)[API Facturación

](/api-facturacion/endpoint/invoice/send)[API WhatsApp

](/api-whatsapp/endpoint/send-text)[API SMS

](/api-sms/introduction)

##### API Consulta

-   [GET

    DNI

    ](/api-consulta/endpoint/dni)

-   [GET

    RUC

    ](/api-consulta/endpoint/ruc)

-   [GET

    RUC - Establecimientos

    ](/api-consulta/endpoint/ruc-anexo)

-   [GET

    RUC - Representante

    ](/api-consulta/endpoint/ruc-representante)

-   [GET

    Carnet de extranjeria

    ](/api-consulta/endpoint/cee)

-   [

    Integra Facturador PRO

    ](/api-consulta/facturador-pro)

-   [GET

    Tipo de Cambio

    ](/api-consulta/endpoint/tipocambio)

-   [POST

    Consulta CPE

    ](/api-consulta/endpoint/sunat-cpe)

-   [GET

    Placa de vehiculo

    ](/api-consulta/endpoint/placa)

-   [GET

    SOAT de vehiculo

    ](/api-consulta/endpoint/soat)

-   [GET

    Licencia de conducir

    ](/api-consulta/endpoint/licencia-conducir)

-   [GET

    Descargar XML (SUNAT)

    ](/api-consulta/endpoint/sunat-xml)

-   [GET

    Descargar PDF (SUNAT)

    ](/api-consulta/endpoint/sunat-pdf)

-   [GET

    Descargar CDR (SUNAT)

    ](/api-consulta/endpoint/sunat-cdr)

-   [GET

    Descargar Guia JSON (SUNAT)

    ](/api-consulta/endpoint/sunat-guia)

-   [GET

    Descargar Guia XML (SUNAT)

    ](/api-consulta/endpoint/sunat-guia-xml)

cURL

cURL

Copy

```
curl --request GET \
  --url https://api.factiliza.com/v1/sunat/pdf/{numRuc}-{tipoDocumento}-{numSerieComprobante}-{numDocumentoComprobante} \
  --header 'Authorization: Bearer <token>'
```

200

400

Copy

```
{
  "status": 200,
  "message": "Exito",
  "success": true,
  "data": "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"
}
```

API Consulta

# Descargar PDF (SUNAT)

Descarga el PDF de cualquier documento enviado a SUNAT, sin importar quien la emitió

GET

/

sunat

/

pdf

/

{numRuc}

\-

{tipoDocumento}

\-

{numSerieComprobante}

\-

{numDocumentoComprobante}

Try it

cURL

cURL

Copy

```
curl --request GET \
  --url https://api.factiliza.com/v1/sunat/pdf/{numRuc}-{tipoDocumento}-{numSerieComprobante}-{numDocumentoComprobante} \
  --header 'Authorization: Bearer <token>'
```

200

400

Copy

```
{
  "status": 200,
  "message": "Exito",
  "success": true,
  "data": "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"
}
```

#### Authorizations

[​

](#authorization-authorization)

Authorization

string

header

required

Bearer authentication header of the form `Bearer <token>`, where `<token>` is your auth token.

#### Path Parameters

[​

](#parameter-num-ruc)

numRuc

string

required

[​

](#parameter-tipo-documento)

tipoDocumento

string

required

[​

](#parameter-num-serie-comprobante)

numSerieComprobante

string

required

[​

](#parameter-num-documento-comprobante)

numDocumentoComprobante

string

required

#### Response

200

application/json

sunat response

[​

](#response-status)

status

integer

El código de estado de la respuesta

[​

](#response-success)

success

boolean

El estado de la respuesta true o false

[​

](#response-message)

message

string

Mensaje de la respuesta

[​

](#response-data)

data

object

El CDR eb BASE64

[Descargar XML (SUNAT)](/api-consulta/endpoint/sunat-xml)[Descargar CDR (SUNAT)](/api-consulta/endpoint/sunat-cdr)

Ctrl+I

Assistant

Responses are generated using AI and may contain mistakes.
