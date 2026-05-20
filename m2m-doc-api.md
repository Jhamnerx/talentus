API REST para clientes M2MDataglobal (BETA)
En esta página se detalla la información para conectarse y usar nuestra API.

Índice
Conexión API
Llamadas y respuestas
Métodos disponibles en la API

Conexión API
Para conectarse a la API el cliente debe:

Obtener una API-Key de autentificación proporcionada por nosotros.
Especificar la IP desde donde se conectarán (opcional, mayor seguridad).
Una vez cumplidos esos requisitos, el cliente deberá agregar a la cabecera (header) de cada consulta el campo X-API-KEY con el valor de la API-Key recibida.
Por motivos de seguridad se debe incluir también el User-Agent en el header.

Ejemplo de un API-Key: 204c4e39-83a3-429f-b6e2-84e256938bf0
A continuación mostramos un ejemplo de conexión para el programa Postman:

api-key
Otro ejemplo alternativo para el programa Postman:

api-key
Llamadas y respuestas
Llamadas
La url de conexión es https://m2mcenter.app/apiclient/ seguido por la versión, la categoría, el método y los parámetros dentro de la misma url.

Ejemplos:

https://m2mcenter.app/apiclient/v1/sims/simList
https://m2mcenter.app/apiclient/v1/sims/simDetails/icc/88888888888888888888
https://m2mcenter.app/apiclient/[versión]/[categoría]/[método]/[parámetro]/[parámetro]
Respuestas
Las respuestas son por defecto en formato json, pero pueden elegirse otros tipos de formatos de respuesta.

Todas las respuestas tendrán un código de respuesta y un json con el parámetro status (true o false), el parámetro message cuando esté ok, el parámetro error cuando haya un error, y el parámetro data cuando sea el caso.

Ejemplo:

Llamada a: https://m2mcenter.app/apiclient/v1/sims/simDetails/icc/8934075200093532065

Devuelve json (muestra solo los datos disponibles):

{
"status": true,
"data": {
"icc": "8934075200093532065",
"msisdn": "345901037113837",
"planCode": "GPS_CL_LBX_6M_2020_0",
"planName": "Movistar Smart Sin Fronteras Chile 6 MB",
"imsi": "214074302232641",
"apn": "m2m.movistar.cl",
"imei": "86-440302-456315-6",
"ip": "10.40.184.154",
"simType": "SMART",
"simCycleState": "ACTIVATED",
"gprsStatus": 1,
"lastConnStart": "2021-01-14T14:07:03.000Z",
"lastConnStop": "2021-01-14T14:06:16.000Z",
"operator": "Movistar Chile",
"latitude": -33.42847,
"longitude": -70.791776,
"customField1": "hola",
"customField2": "mundo",
"commModuleManufacturer": "Teltonika",
"commModuleModel": "TM2500",
"consumptionMonthlyData": 1535426,
"consumptionDailyData": 46080
},
"message": "Simcard data retrieved successfully"
}
Ejemplo error:

{
"status": false,
"error": "Simcard not found"
}
En caso de necesitar que la respuesta sea en xml, hay que agregar el código "?format=xml" al final de la url.

Ejemplo:

https://m2mcenter.app/apiclient/v1/sims/simDetails/icc/8934075200093532065?format=xml

Métodos disponibles en la API
Listado de simcards
Detalle de simcard en tiempo real
Test de conexión GSM
Test de conexión GPRS
Reset simcard
Enviar SMS

• Obtener LISTADO de simcards (GET)
https://m2mcenter.app/apiclient/v1/sims/simList
Respuesta:

{
"status": true,
"total": "711",
"data": [
{
"icc": "88888888888888888888",
"msisdn": "5555555555",
"planCode": "GPS_CL_LBX_6M_2020_0",
"planName": "Movistar Smart Sin Fronteras Chile 6 MB",
"imei": "999999999999999",
"consumptionMonthlyData": "4510720",
"simCycleState": "ACTIVATED"
},
{
"icc": "88888888888888888999",
"msisdn": "5555555444",
"planCode": "ENTEL_MGR_30M_2020_POOL",
"planName": "Entel Chile Manager 30 MB Pool",
"imei": "999999999999888",
"consumptionMonthlyData": "5706170",
"simCycleState": "ACTIVATED"
},
{
"icc": "88888888888888888777",
"msisdn": "5555555333",
"planCode": "ENTEL_LGC_3MB",
"planName": "Entel Chile Legacy 3 MB",
"imei": "",
"consumptionMonthlyData": "0",
"simCycleState": "ACTIVATED"
},
...
],
"message": "Simcard data retrieved successfully"
}
En caso de error:

{
"status": false,
"error": "No simcards"
}

• Obtener DETALLE de simcard por icc, msisdn o imei (GET)
https://m2mcenter.app/apiclient/v1/sims/simDetails/icc/88888888888888888888
https://m2mcenter.app/apiclient/v1/sims/simDetails/msisdn/5555555555
https://m2mcenter.app/apiclient/v1/sims/simDetails/imei/99999999999999
Respuesta:

{
"status": true,
"data": {
"icc": "8934075200093532065",
"msisdn": "345901037113837",
"planCode": "GPS_CL_LBX_6M_2020_0",
"planName": "Movistar Smart Sin Fronteras Chile 6 MB",
"imsi": "214074302232641",
"apn": "m2m.movistar.cl",
"imei": "86-440302-456315-6",
"ip": "10.40.184.154",
"simType": "SMART",
"simCycleState": "ACTIVATED",
"gprsStatus": 1,
"lastConnStart": "2021-01-14T14:07:03.000Z",
"lastConnStop": "2021-01-14T14:06:16.000Z",
"operator": "Movistar Chile",
"latitude": -33.42847,
"longitude": -70.791776,
"customField1": "hola",
"customField2": "mundo",
"commModuleManufacturer": "Teltonika",
"commModuleModel": "TM2500",
"consumptionMonthlyData": 1535426,
"consumptionDailyData": 46080
},
"message": "Simcard data retrieved successfully"
}
En caso de error:

{
"status": false,
"error": "Simcard not found"
}

• Hacer test GSM por icc, msisdn o imei (GET)
https://m2mcenter.app/apiclient/v1/sims/testGsm/icc/88888888888888888888
https://m2mcenter.app/apiclient/v1/sims/testGsm/msisdn/5555555555
https://m2mcenter.app/apiclient/v1/sims/testGsm/imei/99999999999999
Respuesta:

{
"status": true,
"data": {
"result": "GSM_UP"
},
"message": "Simcard data retrieved successfully"
}
En caso de error:

{
"status": false,
"error": "Simcard not found"
}

• Hacer test GPRS por icc, msisdn o imei (GET)
https://m2mcenter.app/apiclient/v1/sims/testGprs/icc/88888888888888888888
https://m2mcenter.app/apiclient/v1/sims/testGprs/msisdn/5555555555
https://m2mcenter.app/apiclient/v1/sims/testGprs/imei/99999999999999
Respuesta:

{
"status": true,
"data": {
"result": "GPRS_UP"
},
"message": "Simcard data retrieved successfully"
}
En caso de error:

{
"status": false,
"error": "Simcard not found"
}

• Hacer RESET por icc, msisdn o imei (GET)
https://m2mcenter.app/apiclient/v1/sims/reset/icc/88888888888888888888
https://m2mcenter.app/apiclient/v1/sims/reset/msisdn/5555555555
https://m2mcenter.app/apiclient/v1/sims/reset/imei/99999999999999
Respuesta:

{
"status": true,
"message": "Simcard reset successfully"
}

• Enviar un SMS por icc, msisdn o imei (POST)
https://m2mcenter.app/apiclient/v1/sims/sms/icc/88888888888888888888
https://m2mcenter.app/apiclient/v1/sims/sms/msisdn/5555555555
https://m2mcenter.app/apiclient/v1/sims/sms/imei/99999999999999
Se debe enviar por POST un texto en formato json con el campo message y el texto a enviar. En la cabecera del mensaje (header) se debe especificar que el texto es de tipo "Content-Type: application/json".

Ejemplo json:

{"message": "Hola M2MLover"}
Ejemplo para el programa Postman:

sms
Respuesta:

{
"status": true,
"message": "SMS sended successfully"
}

• Actualizar campos personalizados (POST)
https://m2mcenter.app/apiclient/v1/customfields/sms/icc/88888888888888888888
https://m2mcenter.app/apiclient/v1/customfields/sms/msisdn/5555555555
https://m2mcenter.app/apiclient/v1/customfields/sms/imei/99999999999999
Se debe enviar por POST un texto en formato json con los campos customField1 o customField2 que se requieran modificar (Se puede modificar uno o ambos en una misma llamada). En la cabecera del mensaje (header) se debe especificar que el texto es de tipo "Content-Type: application/json".

Ejemplo json:

{ "customField1": "Prueba", "customField2": "API" }
Respuesta:

{
"status": true,
"message": "Fields updated successfully"
}
En caso de error:

{
"status": false,
"error": "Simcard not found"
}
