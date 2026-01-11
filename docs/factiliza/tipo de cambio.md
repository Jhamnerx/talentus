# Tipo de Cambio - Documentación

[Skip to main content](#content-area)

[Documentación home page![light logo](https://mintcdn.com/factiliza/7a7xBG97tl9T-ulm/logo/light.svg?fit=max&auto=format&n=7a7xBG97tl9T-ulm&q=85&s=10c8c9f95e3b798949a9a57b354879a4)![dark logo](https://mintcdn.com/factiliza/7a7xBG97tl9T-ulm/logo/dark.svg?fit=max&auto=format&n=7a7xBG97tl9T-ulm&q=85&s=9cedaa9b0ee4870db9b91fc96a025f8c)](/)

Search...

Ctrl K

Search...

Navigation

API Consulta

Tipo de Cambio

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
  --url https://api.factiliza.com/v1/tipocambio/info/dia \
  --header 'Authorization: Bearer <token>'
```

200

400

Copy

```
{
  "status": 200,
  "message": "Exito",
  "data": {
    "fecha": "2024-04-11",
    "compra": 3.773,
    "venta": 3.781
  }
}
```

API Consulta

# Tipo de Cambio

Retorna el tipo de cambio segun la fecha

GET

/

tipocambio

/

info

/

dia

Try it

cURL

cURL

Copy

```
curl --request GET \
  --url https://api.factiliza.com/v1/tipocambio/info/dia \
  --header 'Authorization: Bearer <token>'
```

200

400

Copy

```
{
  "status": 200,
  "message": "Exito",
  "data": {
    "fecha": "2024-04-11",
    "compra": 3.773,
    "venta": 3.781
  }
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

#### Query Parameters

[​

](#parameter-fecha)

fecha

string

required

La fecha a consultar. Ejm 2024-01-01

#### Response

200

application/json

cee response

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

Datos detallados de la respuesta

Show child attributes

[Integra Facturador PRO](/api-consulta/facturador-pro)[Consulta CPE](/api-consulta/endpoint/sunat-cpe)

Ctrl+I

Assistant

Responses are generated using AI and may contain mistakes.
