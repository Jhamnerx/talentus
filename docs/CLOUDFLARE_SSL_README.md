# Configuración SSL con Cloudflare - Resumen Rápido

## Tu Configuración Actual

✅ **Dominio principal**: `talentustechnology.com` (web institucional)  
✅ **Sistema Laravel**: `sistema.talentustechnology.com` (aplicación Talentus)  
✅ **SSL Method**: Let's Encrypt vía Cloudflare DNS Challenge  
✅ **Plugin**: `certbot-dns-cloudflare` ya instalado  
✅ **API Token**: Ya configurado en `/root/.secrets/cloudflare.ini`

## ¿Necesito un nuevo API Token?

**NO**. Puedes usar el mismo API Token que ya tienes configurado.

El API Token de Cloudflare funciona a nivel de zona (dominio), entonces un solo token puede gestionar:

-   `talentustechnology.com`
-   `www.talentustechnology.com`
-   `sistema.talentustechnology.com`
-   Cualquier otro subdominio de `talentustechnology.com`

## Pasos para Configurar el Sistema

### 1. Agregar Registro DNS en Cloudflare

Ve a **Cloudflare Dashboard** → **DNS** → **Records**:

| Type | Name    | Content           | Proxy Status | TTL  |
| ---- | ------- | ----------------- | ------------ | ---- |
| A    | sistema | `IP_DEL_SERVIDOR` | ✅ Proxied   | Auto |

### 2. Generar Certificado SSL

**Opción A: Script Automatizado (Recomendado)**

```bash
# En tu servidor
sudo bash /var/www/talentus/docs/setup-talentus-sistema-ssl.sh
```

**Opción B: Comando Manual**

```bash
sudo certbot certonly \
  --dns-cloudflare \
  --dns-cloudflare-credentials /root/.secrets/cloudflare.ini \
  --dns-cloudflare-propagation-seconds 60 \
  -d sistema.talentustechnology.com \
  --email admin@talentustechnology.com \
  --agree-tos \
  --non-interactive
```

### 3. Configurar VirtualHost de Apache

Crear `/etc/httpd/conf.d/talentus-sistema.conf` con el contenido de la sección 3.1 de la guía principal.

### 4. Configurar Cloudflare

En **Cloudflare Dashboard** → **SSL/TLS**:

-   **Encryption Mode**: Full (strict) ⚠️ IMPORTANTE
-   **Always Use HTTPS**: ON
-   **Automatic HTTPS Rewrites**: ON
-   **Minimum TLS Version**: 1.2

### 5. Reiniciar Apache

```bash
sudo apachectl configtest
sudo systemctl restart httpd
```

## Verificar SSL

```bash
# Test básico
curl -I https://sistema.talentustechnology.com

# Test completo (desde navegador)
https://www.ssllabs.com/ssltest/analyze.html?d=sistema.talentustechnology.com
```

## Renovación Automática

### Configuración con Crontab (Requerido)

**Tu servidor NO tiene el systemd timer de certbot instalado**, por lo que debes configurar crontab manualmente:

**1. Desactivar el timer de systemd (si está activo)**

```bash
sudo systemctl stop certbot-renew.timer
sudo systemctl disable certbot-renew.timer
```

**2. Crear script de renovación con logs**

```bash
sudo nano /usr/local/bin/certbot-renew.sh
```

Contenido del script:

```bash
#!/bin/bash
# Script de renovación automática de certificados SSL

LOG_FILE="/var/log/certbot-renew.log"
DATE=$(date '+%Y-%m-%d %H:%M:%S')

echo "[$DATE] Iniciando renovación automática de certificados..." >> "$LOG_FILE"

# Renovar certificados
certbot renew --quiet --deploy-hook "systemctl reload httpd" >> "$LOG_FILE" 2>&1

if [ $? -eq 0 ]; then
    echo "[$DATE] Renovación completada exitosamente" >> "$LOG_FILE"
else
    echo "[$DATE] ERROR en la renovación" >> "$LOG_FILE"
fi

echo "----------------------------------------" >> "$LOG_FILE"
```

**3. Dar permisos de ejecución**

```bash
sudo chmod +x /usr/local/bin/certbot-renew.sh
```

**4. Configurar crontab**

```bash
sudo crontab -e
```

Agregar esta línea (se ejecuta cada día a las 2:30 AM):

```cron
30 2 * * * /usr/local/bin/certbot-renew.sh
```

O esta variante (dos veces al día - 2:30 AM y 2:30 PM):

```cron
30 2,14 * * * /usr/local/bin/certbot-renew.sh
```

**5. Verificar crontab configurado**

```bash
sudo crontab -l
```

**6. Ver logs de renovación**

```bash
sudo tail -f /var/log/certbot-renew.log
```

**Nota**: Let's Encrypt recomienda ejecutar la renovación 2 veces al día. Los certificados solo se renuevan si están a 30 días o menos de expirar.

### Test de Renovación

Antes de confiar en el crontab, verifica que funciona:

```bash
# Test manual (sin aplicar cambios)
sudo certbot renew --dry-run

# Si todo está OK, verás: "Congratulations, all simulated renewals succeeded"
```

## Certificados Actuales

```bash
# Listar todos los certificados
sudo certbot certificates

# Deberías ver:
# 1. talentustechnology.com + www (web institucional)
# 2. sistema.talentustechnology.com (sistema Laravel)
```

## Estructura de Archivos

```
/var/www/
├── talentus-web/          # Web institucional
│   └── public/
└── talentus/              # Sistema Laravel (este proyecto)
    └── public/

/etc/httpd/conf.d/
├── talentus-web.conf      # VirtualHost web institucional
└── talentus-sistema.conf  # VirtualHost sistema Laravel (nuevo)

/etc/letsencrypt/live/
├── talentustechnology.com/           # Certificado web principal
│   ├── fullchain.pem
│   └── privkey.pem
└── sistema.talentustechnology.com/   # Certificado sistema
    ├── fullchain.pem
    └── privkey.pem

/root/.secrets/
└── cloudflare.ini         # API Token compartido
```

## Troubleshooting

### Error: "dns_cloudflare_api_token not found"

```bash
# Verificar que existe el archivo
ls -la /root/.secrets/cloudflare.ini

# Verificar permisos
sudo chmod 600 /root/.secrets/cloudflare.ini
```

### Error: DNS validation failed

```bash
# Verificar registro DNS en Cloudflare
curl -X GET "https://api.cloudflare.com/client/v4/zones/ZONE_ID/dns_records" \
  -H "Authorization: Bearer YOUR_TOKEN" | grep sistema

# Esperar propagación DNS (hasta 5 minutos)
dig sistema.talentustechnology.com +short
```

### Error: Certificate already exists

```bash
# Forzar renovación
sudo certbot certonly --force-renewal \
  --dns-cloudflare \
  --dns-cloudflare-credentials /root/.secrets/cloudflare.ini \
  -d sistema.talentustechnology.com
```

### Cloudflare muestra "Error 525: SSL Handshake Failed"

Esto significa que Cloudflare no puede validar tu certificado SSL.

**Solución**:

1. Verifica que el modo SSL/TLS esté en **Full (strict)**
2. Verifica que Apache esté usando los certificados correctos
3. Reinicia Apache: `sudo systemctl restart httpd`

### Cloudflare muestra "Error 526: Invalid SSL Certificate"

Similar al 525, verifica:

```bash
# Ver logs de Apache
sudo tail -50 /var/log/httpd/talentus-sistema-ssl-error.log

# Verificar que el certificado es válido
sudo openssl x509 -in /etc/letsencrypt/live/sistema.talentustechnology.com/fullchain.pem -text -noout
```

## Comandos Útiles

```bash
# Ver estado de certificados
sudo certbot certificates

# Ver logs de certbot
sudo tail -f /var/log/letsencrypt/letsencrypt.log

# Renovar manualmente (dry-run)
sudo certbot renew --dry-run

# Renovar manualmente (real)
sudo certbot renew

# Ver configuración de Apache
sudo apachectl -S

# Test de configuración
sudo apachectl configtest
```

## Contacto y Soporte

Para problemas con:

-   **Cloudflare**: Revisa [Cloudflare Support](https://support.cloudflare.com/)
-   **Let's Encrypt**: Revisa [Let's Encrypt Community](https://community.letsencrypt.org/)
-   **Talentus**: Contacta al equipo de desarrollo

---

**Última actualización**: Enero 2026  
**Versión**: 1.0
