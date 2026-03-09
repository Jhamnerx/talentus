# RUC - Documentación

[Skip to main content](#content-area)

[Documentación home page![light logo](https://mintcdn.com/factiliza/7a7xBG97tl9T-ulm/logo/light.svg?fit=max&auto=format&n=7a7xBG97tl9T-ulm&q=85&s=10c8c9f95e3b798949a9a57b354879a4)![dark logo](https://mintcdn.com/factiliza/7a7xBG97tl9T-ulm/logo/dark.svg?fit=max&auto=format&n=7a7xBG97tl9T-ulm&q=85&s=9cedaa9b0ee4870db9b91fc96a025f8c)](/)

Search...

Ctrl K

Search...

Navigation

API Consulta

RUC

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
  --url https://api.factiliza.com/v1/ruc/info/{ruc} \
  --header 'Authorization: Bearer <token>'
```

200

400

Copy

```
{
  "status": 200,
  "success": true,
  "message": "Exito",
  "data": {
    "numero": "20552103816",
    "nombre_o_razon_social": "AGROLIGHT PERU S.A.C.",
    "tipo_contribuyente": "SOCIEDAD ANONIMA CERRADA",
    "estado": "SUSPENSION TEMPORAL",
    "condicion": "HABIDO",
    "departamento": "LIMA",
    "provincia": "LIMA",
    "distrito": "SANTA ANITA",
    "direccion": "PJ. JORGE BASADRE NRO. 158 URB. POP LA UNIVERSAL 2DA ET.",
    "direccion_completa": "PJ. JORGE BASADRE NRO. 158 URB. POP LA UNIVERSAL 2DA ET., LIMA - LIMA - SANTA ANITA",
    "ubigeo_sunat": "150137",
    "ubigeo": [
      "15",
      "1501",
      "150137"
    ]
  }
}
```

API Consulta

# RUC

Retorna datos segun el RUC

GET

/

ruc

/

info

/

{ruc}

Try it

cURL

cURL

Copy

```
curl --request GET \
  --url https://api.factiliza.com/v1/ruc/info/{ruc} \
  --header 'Authorization: Bearer <token>'
```

200

400

Copy

```
{
  "status": 200,
  "success": true,
  "message": "Exito",
  "data": {
    "numero": "20552103816",
    "nombre_o_razon_social": "AGROLIGHT PERU S.A.C.",
    "tipo_contribuyente": "SOCIEDAD ANONIMA CERRADA",
    "estado": "SUSPENSION TEMPORAL",
    "condicion": "HABIDO",
    "departamento": "LIMA",
    "provincia": "LIMA",
    "distrito": "SANTA ANITA",
    "direccion": "PJ. JORGE BASADRE NRO. 158 URB. POP LA UNIVERSAL 2DA ET.",
    "direccion_completa": "PJ. JORGE BASADRE NRO. 158 URB. POP LA UNIVERSAL 2DA ET., LIMA - LIMA - SANTA ANITA",
    "ubigeo_sunat": "150137",
    "ubigeo": [
      "15",
      "1501",
      "150137"
    ]
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

#### Path Parameters

[​

](#parameter-ruc)

ruc

integer<int64>

required

El RUC a consultar

#### Response

200

application/json

ruc response

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

[DNI](/api-consulta/endpoint/dni)[RUC - Establecimientos](/api-consulta/endpoint/ruc-anexo)

Ctrl+I

Assistant

Responses are generated using AI and may contain mistakes.
