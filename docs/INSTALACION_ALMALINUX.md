# Guía de Instalación - Talentus en AlmaLinux

## Información del Sistema

-   **Sistema Operativo**: AlmaLinux
-   **Servidor Web**: Apache HTTPD
-   **Base de Datos**: MariaDB
-   **Cache/Colas**: Redis
-   **Gestor de Procesos**: Supervisord
-   **Ruta de Instalación**: `/var/www/talentus`
-   **Dominio**: `sistema.talentustechnology.com`
-   **SSL**: Let's Encrypt vía Cloudflare DNS Challenge

---

## Nota Importante sobre Cloudflare

Este servidor ya tiene configurado:

-   ✅ **Dominio principal**: `talentustechnology.com` (web institucional en `/var/www/talentus-web`)
-   ✅ **Plugin Cloudflare**: Certbot con `dns-cloudflare` instalado
-   ✅ **API Token**: Configurado en `/root/.secrets/cloudflare.ini`

**Puedes usar el mismo API Token de Cloudflare** para generar el certificado del sistema. Solo necesitas agregar el registro DNS y ejecutar certbot.

---

## Resumen de Instalación Rápida

Para usuarios avanzados que ya tienen experiencia con Laravel en AlmaLinux:

```bash
# 1. Instalar stack básico
sudo dnf install -y php83 php83-fpm mariadb-server redis httpd supervisor

# 2. Configurar base de datos
sudo mysql -e "CREATE DATABASE talentus; CREATE USER 'talentus_user'@'localhost' IDENTIFIED BY 'TU_PASS'; GRANT ALL ON talentus.* TO 'talentus_user'@'localhost';"

# 3. Desplegar aplicación
cd /var/www/talentus
composer install --no-dev --optimize-autoloader
npm install && npm run build

# 4. Configurar VirtualHost con SSL (ver sección 3)

# 5. Desplegar aplicación Laravel (ver sección 7)

# 6. Generar certificado SSL con Cloudflare (ver sección 13)
sudo bash docs/setup-talentus-sistema-ssl.sh

# 7. Configurar Laravel Reverb (ver sección 8)

# 8. Configurar Supervisord para Colas y Reverb (ver sección 9)

# 9. Configurar cron (ver sección 10)
```

**Sigue la guía completa abajo** para instrucciones detalladas paso a paso.

---

## 1. Requisitos Previos del Sistema

### 1.1 Actualizar el Sistema

```bash
sudo dnf update -y
sudo dnf install -y epel-release
```

### 1.2 Instalar Repositorios Necesarios

```bash
# Instalar Remi Repository para PHP 8.2+
sudo dnf install -y https://rpms.remirepo.net/enterprise/remi-release-9.rpm
sudo dnf module reset php -y
sudo dnf module enable php:remi-8.3 -y
```

---

## 2. Instalación de PHP 8.3 y Extensiones

```bash
sudo dnf install -y php php-cli php-fpm php-mysqlnd php-zip php-devel \
    php-gd php-mbstring php-curl php-xml php-pear php-bcmath \
    php-json php-redis php-opcache php-intl php-soap \
    php-process php-pecl-zip php-dom php-simplexml \
    php-xmlreader php-xmlwriter php-tokenizer php-fileinfo

# Verificar versión de PHP
php -v  # Debe mostrar PHP 8.3.x
```

### 2.1 Configurar PHP para Producción

```bash
sudo nano /etc/php.ini
```

**Configuraciones recomendadas**:

```ini
memory_limit = 512M
upload_max_filesize = 64M
post_max_size = 64M
max_execution_time = 300
max_input_time = 300
date.timezone = America/Lima
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
```

### 2.2 Instalar Imagick (Requerido para QR Codes)

```bash
# Instalar ImageMagick y dependencias
sudo dnf install -y ImageMagick ImageMagick-devel

# Instalar extensión PHP imagick vía PECL
sudo pecl install imagick

# Habilitar extensión
echo "extension=imagick.so" | sudo tee /etc/php.d/40-imagick.ini

# Verificar instalación
php -m | grep imagick

# Reiniciar PHP-FPM
sudo systemctl restart php-fpm
```

**Verificar que funciona**:

```bash
php -r "echo (extension_loaded('imagick') ? 'Imagick instalado correctamente' : 'ERROR: Imagick no está disponible') . PHP_EOL;"
```

---

## 3. Instalación de Apache HTTPD

```bash
# Instalar Apache
sudo dnf install -y httpd

# Habilitar e iniciar Apache
sudo systemctl enable httpd
sudo systemctl start httpd

# Verificar estado
sudo systemctl status httpd
```

### 3.1 Configurar VirtualHost para Talentus Sistema

```bash
sudo nano /etc/httpd/conf.d/talentus-sistema.conf
```

**Contenido del archivo `talentus-sistema.conf`**:

```apache
# HTTP - Redirigir a HTTPS
<VirtualHost *:80>
    ServerName sistema.talentustechnology.com
    ServerAdmin admin@talentustechnology.com

    # Redirigir todo el tráfico a HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Permitir acceso a .well-known para renovación de certificados
    Alias /.well-known /var/www/talentus/public/.well-known
    <Directory /var/www/talentus/public/.well-known>
        Require all granted
    </Directory>
</VirtualHost>

# HTTPS - Configuración Principal del Sistema
<VirtualHost *:443>
    ServerName sistema.talentustechnology.com
    ServerAdmin admin@talentustechnology.com

    DocumentRoot /var/www/talentus/public

    <Directory /var/www/talentus/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php-fpm/www.sock|fcgi://localhost"
    </FilesMatch>

    # Logs específicos para Talentus Sistema
    ErrorLog /var/log/httpd/talentus-sistema-ssl-error.log
    CustomLog /var/log/httpd/talentus-sistema-ssl-access.log combined

    # SSL Configuration - Certificados de Let's Encrypt
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/sistema.talentustechnology.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/sistema.talentustechnology.com/privkey.pem

    # SSL Security Headers
    Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains; preload"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"

    # SSL Protocol and Cipher Configuration (Mozilla Intermediate)
    SSLProtocol all -SSLv3 -TLSv1 -TLSv1.1
    SSLCipherSuite ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384
    SSLHonorCipherOrder off
    SSLSessionTickets off

    # OCSP Stapling
    SSLUseStapling On
    # (NO poner SSLStaplingCache aquí - va en la configuración global)

    # Proteger directorios sensibles
    <Directory /var/www/talentus/storage>
        Require all denied
    </Directory>

    <Directory /var/www/talentus/bootstrap/cache>
        Require all denied
    </Directory>

    # Cache estático para assets compilados
    <FilesMatch "\.(jpg|jpeg|png|gif|ico|css|js|woff|woff2|ttf|svg)$">
        Header set Cache-Control "max-age=31536000, public"
    </FilesMatch>
</VirtualHost>
```

### 3.2 Habilitar módulos necesarios de Apache

```bash
# Instalar mod_ssl y mod_headers
sudo dnf install -y mod_ssl mod_headers

# Verificar módulos habilitados
sudo httpd -M | grep -E 'rewrite|ssl|headers|proxy_fcgi'

# Si falta mod_rewrite, editamos httpd.conf
# sudo nano /etc/httpd/conf/httpd.conf
# Buscar y descomentar: LoadModule rewrite_module modules/mod_rewrite.so

# Configurar OCSP Stapling globalmente
sudo nano /etc/httpd/conf.d/ssl.conf
```

**Agregar al final de `ssl.conf`**:

```apache
# OCSP Stapling Cache (configuración global)
SSLStaplingCache "shmcb:logs/stapling-cache(150000)"
```

```bash
# Verificar configuración
sudo apachectl configtest

# Reiniciar Apache
sudo systemctl restart httpd
```

---

## 4. Instalación de MariaDB

```bash
# Instalar MariaDB Server
sudo dnf install -y mariadb-server

# Habilitar e iniciar MariaDB
sudo systemctl enable mariadb
sudo systemctl start mariadb

# Verificar estado
sudo systemctl status mariadb
```

### 4.1 Configurar MariaDB

```bash
# Ejecutar script de seguridad
sudo mysql_secure_installation
```

**Respuestas recomendadas**:

-   Enter current password: [presionar Enter]
-   Switch to unix_socket authentication: `n`
-   Change root password: `Y` (establecer contraseña segura)
-   Remove anonymous users: `Y`
-   Disallow root login remotely: `Y`
-   Remove test database: `Y`
-   Reload privilege tables: `Y`

### 4.2 Crear Base de Datos y Usuario

```bash
sudo mysql -u root -p
```

```sql
-- Crear base de datos
CREATE DATABASE talentus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear usuario con contraseña segura
CREATE USER 'talentus_user'@'localhost' IDENTIFIED BY 'TU_CONTRASEÑA_SEGURA';

-- Otorgar privilegios
GRANT ALL PRIVILEGES ON talentus.* TO 'talentus_user'@'localhost';

-- Aplicar cambios
FLUSH PRIVILEGES;

-- Salir
EXIT;
```

### 4.3 Optimizar MariaDB para Producción

```bash
sudo nano /etc/my.cnf.d/server.cnf
```

**Agregar bajo `[mysqld]`**:

```ini
[mysqld]
max_connections = 200
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2
innodb_flush_method = O_DIRECT
query_cache_type = 1
query_cache_size = 32M
slow_query_log = 1
slow_query_log_file = /var/log/mariadb/slow-query.log
long_query_time = 2
```

```bash
# Reiniciar MariaDB
sudo systemctl restart mariadb
```

---

## 5. Instalación de Redis

```bash
# Instalar Redis
sudo dnf install -y redis

# Habilitar e iniciar Redis
sudo systemctl enable redis
sudo systemctl start redis

# Verificar estado
sudo systemctl status redis

# Probar conexión
redis-cli ping  # Debe responder: PONG
```

### 5.1 Configurar Redis para Producción

```bash
sudo nano /etc/redis/redis.conf
```

**Configuraciones recomendadas**:

```conf
# Seguridad
bind 127.0.0.1
protected-mode yes
requirepass TU_CONTRASEÑA_REDIS_SEGURA

# Memoria
maxmemory 512mb
maxmemory-policy allkeys-lru

# Persistencia
save 900 1
save 300 10
save 60 10000

# Logs
loglevel notice
logfile /var/log/redis/redis.log
```

```bash
# Reiniciar Redis
sudo systemctl restart redis

# Probar con contraseña
redis-cli
> AUTH TU_CONTRASEÑA_REDIS_SEGURA
> PING
```

---

## 6. Instalación de Composer

```bash
# Descargar Composer
cd ~
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Mover a directorio global
sudo mv composer.phar /usr/local/bin/composer

# Verificar instalación
composer --version
```

---

## 6. Instalación de Node.js y NPM

```bash
# Instalar Node.js 20.x (LTS)
curl -fsSL https://rpm.nodesource.com/setup_20.x | sudo bash -
sudo dnf install -y nodejs

# Verificar instalación
node --version
npm --version
```

---

## 7. Desplegar la Aplicación Talentus

### 7.1 Clonar o Subir el Proyecto

**Opción A: Usando Git**

```bash
cd /var/www
sudo git clone https://github.com/tu-usuario/talentus.git
```

**Opción B: Subir archivos comprimidos**

```bash
# En tu máquina local, comprimir el proyecto (excluyendo node_modules y vendor)
# Luego subir a /var/www/talentus

# Descomprimir
cd /var/www
sudo tar -xzf talentus.tar.gz
```

### 7.2 Configurar Permisos

```bash
# Cambiar propietario a usuario de Apache
sudo chown -R apache:apache /var/www/talentus

# Permisos específicos para storage y cache
sudo chmod -R 775 /var/www/talentus/storage
sudo chmod -R 775 /var/www/talentus/bootstrap/cache

# Si usas SELinux, configurar contextos
sudo semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/talentus/storage(/.*)?"
sudo semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/talentus/bootstrap/cache(/.*)?"
sudo restorecon -Rv /var/www/talentus
```

### 7.3 Instalar Dependencias

```bash
cd /var/www/talentus

# Instalar dependencias de PHP
sudo -u apache composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node.js
sudo -u apache npm install

# Compilar assets para producción
sudo -u apache npm run build
```

### 7.4 Configurar Variables de Entorno

```bash
# Copiar archivo de ejemplo
sudo cp .env.example .env

# Editar archivo .env
sudo nano .env
```

**Configuraciones importantes en `.env`**:

```env
APP_NAME="Talentus Technology"
APP_ENV=production
APP_KEY=  # Se generará en el siguiente paso
APP_DEBUG=false
APP_URL=https://sistema.talentustechnology.com

LOG_CHANNEL=daily
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=talentus
DB_USERNAME=talentus_user
DB_PASSWORD=TU_CONTRASEÑA_DB

BROADCAST_DRIVER=pusher
CACHE_DRIVER=redis
FILESYSTEM_DRIVER=public
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=1440

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=TU_CONTRASEÑA_REDIS_SEGURA
REDIS_PORT=6379

# Configuración de correo (ajustar según tu proveedor)
MAIL_MAILER=smtp
MAIL_HOST=smtp.tuproveedor.com
MAIL_PORT=587
MAIL_USERNAME=tu_correo@tudominio.com
MAIL_PASSWORD=tu_contraseña_correo
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@talentustechnology.com
MAIL_FROM_NAME="${APP_NAME}"

# Pusher (si lo usas)
PUSHER_APP_ID=tu_app_id
PUSHER_APP_KEY=tu_app_key
PUSHER_APP_SECRET=tu_app_secret
PUSHER_APP_CLUSTER=sa1

# SUNAT
TOKEN_API_SUNAT="tu_token_sunat"
EMPRESA_ID=1

# WhatsApp Cloud API
WHATSAPP_CLOUD_API_TOKEN="tu_token_whatsapp"
WHATSAPP_CLOUD_API_FROM_PHONE_NUMBER="tu_numero"

# FotaWeb
TOKEN_FOTAWEB="tu_token_fotaweb"

# Horizon
HORIZON_DOMAIN=null
HORIZON_PATH=horizon
```

### 7.5 Generar Key y Ejecutar Migraciones

```bash
cd /var/www/talentus

# Generar APP_KEY
sudo -u apache php artisan key:generate

# Ejecutar migraciones
sudo -u apache php artisan migrate --force

# Ejecutar seeders si es necesario
sudo -u apache php artisan db:seed --force

# Limpiar y cachear configuraciones
sudo -u apache php artisan config:cache
sudo -u apache php artisan route:cache
sudo -u apache php artisan view:cache

# Crear link simbólico para storage
sudo -u apache php artisan storage:link

# Optimizar autoload de Composer
sudo -u apache composer dump-autoload --optimize
```

---

## 8. Configurar Laravel Reverb (Broadcasting WebSockets)

Laravel Reverb es el servidor WebSocket para broadcasting en tiempo real (notificaciones push, chat, actualizaciones en vivo).

### 8.1 Verificar Configuración en .env

---

## 9. Configurar Supervisord (Colas y WebSockets)

Supervisord gestiona los procesos en segundo plano: Workers de Cola (5 procesos) y Laravel Reverb (1 proceso).

### 9.1 Instalar Supervisord

```bash
sudo dnf install -y supervisor

# Habilitar e iniciar Supervisor
sudo systemctl enable supervisord
sudo systemctl start supervisord

# Verificar estado
sudo systemctl status supervisord
```

### 9.2 Configurar Supervisor Global

```bash
sudo nano /etc/supervisord.conf
```

**Buscar `[supervisord]` y asegurar estos valores**:

```ini
[supervisord]
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid
childlogdir=/var/log/supervisor
nodaemon=false
minfds=10000
minprocs=200
user=root

[unix_http_server]
file=/var/run/supervisor.sock
chmod=0700

[supervisorctl]
serverurl=unix:///var/run/supervisor.sock

[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface

[include]
files = supervisord.d/*.ini
```

**Crear directorio de logs**:

```bash
sudo mkdir -p /var/log/supervisor
sudo chown apache:apache /var/log/supervisor
```

### 9.3 Configurar Workers de Cola

El sistema procesa 5 tipos de colas con `queue:work`:

-   **default**: Tareas generales del sistema
-   **emails**: Envío de correos electrónicos
-   **notifications**: Notificaciones push (FCM)
-   **exports**: Exportaciones de Excel/PDF
-   **facturacion**: Emisión de comprobantes electrónicos SUNAT

```bash
sudo nano /etc/supervisord.d/talentus-worker.ini
```

**Contenido del archivo**:

```ini
[program:talentus-worker]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/php /var/www/talentus/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=apache
numprocs=5
redirect_stderr=true
stdout_logfile=/var/www/talentus/storage/logs/worker.log
stdout_logfile_maxbytes=10MB
stdout_logfile_backups=5
stopwaitsecs=3600
stopasgroup=true
killasgroup=true
priority=999
```

### 9.4 Configurar Laravel Reverb

```bash
sudo nano /etc/supervisord.d/talentus-reverb.ini
```

**Contenido del archivo**:

```ini
[program:talentus-reverb]
process_name=%(program_name)s
command=/usr/bin/php /var/www/talentus/artisan reverb:start --host=0.0.0.0 --port=8080 --hostname=sistema.talentustechnology.com
autostart=true
autorestart=true
user=apache
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/talentus/storage/logs/reverb.log
stdout_logfile_maxbytes=10MB
stdout_logfile_backups=5
stopwaitsecs=10
stopasgroup=true
killasgroup=true
priority=100
```

**Explicación de parámetros**:

-   `--host=0.0.0.0`: Escucha en todas las interfaces de red (necesario para reverse proxy)
-   `--port=8080`: Puerto interno (Apache hace proxy de 443 → 8080)
-   `--hostname=sistema.talentustechnology.com`: Dominio público para validación CORS
-   `priority=100`: Prioridad media (inicia después de Workers)
-   `stopwaitsecs=10`: Tiempo corto ya que Reverb cierra conexiones rápidamente
-   `numprocs=1`: Solo 1 proceso (Reverb es multi-threaded internamente)

### 9.5 Iniciar Procesos

```bash
# Recargar configuración de Supervisor
sudo supervisorctl reread
sudo supervisorctl update

# Iniciar todos los procesos
sudo supervisorctl start all

# Verificar estado
sudo supervisorctl status
```

**Salida esperada**:

```
talentus-worker:talentus-worker_00   RUNNING   pid 12345, uptime 0:00:05
talentus-worker:talentus-worker_01   RUNNING   pid 12346, uptime 0:00:05
talentus-worker:talentus-worker_02   RUNNING   pid 12347, uptime 0:00:05
talentus-worker:talentus-worker_03   RUNNING   pid 12348, uptime 0:00:05
talentus-worker:talentus-worker_04   RUNNING   pid 12349, uptime 0:00:05
talentus-reverb                      RUNNING   pid 12350, uptime 0:00:03
```

### 9.8 Troubleshooting

#### A. Workers de Cola

**Jobs no se procesan**:

```bash
# Verificar que Redis está corriendo
sudo systemctl status redis

# Verificar que Workers están activos
sudo supervisorctl status talentus-worker:*

# Ver logs de Workers
sudo tail -f /var/www/talentus/storage/logs/worker.log

# Verificar conectividad con Redis
php /var/www/talentus/artisan tinker
>>> Redis::connection()->ping();
```

**Reiniciar después de cambios en código**:

```bash
# SIEMPRE reiniciar Workers después de git pull o cambios
php /var/www/talentus/artisan queue:restart

# O reiniciar manualmente vía supervisord
sudo supervisorctl restart talentus-worker:*

# Verificar que se reiniciaron correctamente
sudo supervisorctl status talentus-worker:*
```

**Jobs fallidos**:

```bash
# Ver lista de jobs fallidos
php /var/www/talentus/artisan queue:failed

# Reintentar job específico
php /var/www/talentus/artisan queue:retry JOB_ID

# Reintentar todos los fallidos
php /var/www/talentus/artisan queue:retry all

# Limpiar jobs fallidos
php /var/www/talentus/artisan queue:flush
```

#### B. Laravel Reverb

**Reverb no inicia**:

```bash
# Ver logs de error
sudo tail -f /var/www/talentus/storage/logs/reverb.log
sudo tail -f /var/log/supervisor/supervisord.log

# Verificar que el puerto 8080 no esté ocupado
sudo netstat -tulpn | grep :8080

# Si está ocupado, matar proceso
sudo lsof -ti:8080 | xargs kill -9

# Probar comando manualmente
sudo -u apache /usr/bin/php /var/www/talentus/artisan reverb:start --host=0.0.0.0 --port=8080
```

**WebSocket no conecta desde navegador**:

```bash
# Verificar que Apache tiene el módulo WebSocket
sudo httpd -M | grep proxy_wstunnel

# Verificar configuración de VirtualHost
sudo apachectl configtest

# Ver logs de Apache
sudo tail -f /var/log/httpd/sistema-error.log

# Probar conexión directa (sin SSL)
curl -i -N -H "Connection: Upgrade" -H "Upgrade: websocket" http://localhost:8080/app
```

**Verificar conexiones activas**:

```bash
# Ver conexiones WebSocket activas
sudo netstat -an | grep :8080

# Ver procesos de Reverb
ps aux | grep reverb

# Test desde Laravel Tinker
php /var/www/talentus/artisan tinker
>>> broadcast(new App\Events\TestEvent('Hola'));
```

---

## 10. Configurar Cron (Laravel Scheduler)

chmod=0700

[supervisorctl]
serverurl=unix:///var/run/supervisor.sock

[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface

[include]
files = supervisord.d/\*.ini

````

**Crear directorio de logs**:

```bash
sudo mkdir -p /var/log/supervisor
sudo chown apache:apache /var/log/supervisor
````

#### B. Configurar Workers de Cola

```bash
sudo nano /etc/supervisord.d/talentus-worker.ini
```

**Contenido del archivo**:

```ini
[program:talentus-worker]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/php /var/www/talentus/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600 --queue=default,emails,notifications,exports,facturacion
autostart=true
autorestart=true
user=apache
numprocs=5
redirect_stderr=true
stdout_logfile=/var/www/talentus/storage/logs/worker.log
stdout_logfile_maxbytes=10MB
stdout_logfile_backups=5
stopwaitsecs=3600
stopasgroup=true
killasgroup=true
priority=999
```

**Explicación de parámetros**:

-   `numprocs=5`: 5 workers en paralelo para mejor rendimiento
-   `--sleep=3`: Espera 3 segundos entre cada ciclo cuando no hay jobs
-   `--tries=3`: Reintenta jobs fallidos hasta 3 veces
-   `--max-time=3600`: Reinicia worker cada 1 hora (previene memory leaks)
-   `--queue=default,emails,notifications,exports,facturacion`: Orden de prioridad de colas
-   `stopwaitsecs=3600`: Espera 1 hora para permitir que jobs largos terminen
-   `priority=999`: Alta prioridad para iniciar antes que otros servicios

### 9.3 Iniciar Workers

```bash
# Recargar configuración de Supervisor
sudo supervisorctl reread
sudo supervisorctl update

# Iniciar Workers
sudo supervisorctl start talentus-worker:*

# Verificar estado
sudo supervisorctl status talentus-worker:*
```

**Salida esperada**:

```
talentus-worker:talentus-worker_00   RUNNING   pid 12345, uptime 0:00:05
talentus-worker:talentus-worker_01   RUNNING   pid 12346, uptime 0:00:05
talentus-worker:talentus-worker_02   RUNNING   pid 12347, uptime 0:00:05
talentus-worker:talentus-worker_03   RUNNING   pid 12348, uptime 0:00:05
talentus-worker:talentus-worker_04   RUNNING   pid 12349, uptime 0:00:05
```

### 9.4 Comandos Útiles de Supervisord

```bash
# Ver logs de Workers en tiempo real
sudo tail -f /var/www/talentus/storage/logs/worker.log

# Reiniciar Workers (después de cambios en código)
sudo supervisorctl restart talentus-worker:*

# Detener Workers
sudo supervisorctl stop talentus-worker:*

# Detener un worker específico
sudo supervisorctl stop talentus-worker:talentus-worker_00

# Ver estado de todos los procesos
sudo supervisorctl status

# Recargar configuración después de cambios
sudo supervisorctl reread
sudo supervisorctl update

# Ver logs de supervisord
sudo tail -f /var/log/supervisor/supervisord.log

# Reiniciar supervisord completamente (usar con precaución)
sudo systemctl restart supervisord
```

### 9.5 Monitorear Colas

```bash
# Ver estadísticas de colas desde artisan
php /var/www/talentus/artisan queue:monitor default,emails,notifications,exports,facturacion

# Ver jobs en cola
php /var/www/talentus/artisan queue:work redis --once

# Ver tamaño de cada cola
php /var/www/talentus/artisan tinker
>>> Redis::connection()->llen('queues:default');
>>> Redis::connection()->llen('queues:emails');
>>> Redis::connection()->llen('queues:notifications');
>>> Redis::connection()->llen('queues:exports');
>>> Redis::connection()->llen('queues:facturacion');
```

### 9.6 Troubleshooting Colas

#### Jobs no se procesan

```bash
# Verificar que Redis está corriendo
sudo systemctl status redis

# Verificar que Workers están activos
sudo supervisorctl status talentus-worker:*

# Ver logs de Workers
sudo tail -f /var/www/talentus/storage/logs/worker.log

# Verificar conectividad con Redis
php /var/www/talentus/artisan tinker
>>> Redis::connection()->ping();
```

#### Reiniciar después de cambios en código

```bash
# SIEMPRE reiniciar Workers después de git pull o cambios
php /var/www/talentus/artisan queue:restart

# O reiniciar manualmente vía supervisord
sudo supervisorctl restart talentus-worker:*

# Verificar que se reiniciaron correctamente
sudo supervisorctl status talentus-worker:*
```

#### Jobs fallidos

```bash
# Ver lista de jobs fallidos
php /var/www/talentus/artisan queue:failed

# Reintentar job específico
php /var/www/talentus/artisan queue:retry JOB_ID

# Reintentar todos los fallidos
php /var/www/talentus/artisan queue:retry all

# Limpiar jobs fallidos
php /var/www/talentus/artisan queue:flush
```

---

## 10. Configurar Cron (Laravel Scheduler)

Laravel Scheduler ejecuta las siguientes tareas automáticas:

-   Backups diarios (limpieza 01:00, ejecución 22:00)
-   Recordatorios (07:40)
-   Detalle de cobros (08:50)
-   Limpieza de logs de actividad (diario)
-   Notificaciones de cumpleaños (07:50)
-   Limpieza de Telescope (diario)

### 10.1 Configurar Crontab

```bash
# Editar crontab para usuario apache
sudo crontab -u apache -e
```

**Agregar esta línea**:

```cron
* * * * * cd /var/www/talentus && php artisan schedule:run >> /dev/null 2>&1
```

**Verificar crontab**:

```bash
sudo crontab -u apache -l
```

---

## 11. Configurar Firewall

```bash
# Permitir HTTP y HTTPS
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https

# Recargar firewall
sudo firewall-cmd --reload

# Verificar reglas
sudo firewall-cmd --list-all
```

---

## 12. Configurar SELinux (Importante en AlmaLinux)

```bash
# Permitir que Apache se conecte a la red (para APIs externas)
sudo setsebool -P httpd_can_network_connect 1

# Permitir que Apache envíe correos
sudo setsebool -P httpd_can_sendmail 1

# Permitir conexión a Redis
sudo setsebool -P httpd_can_network_connect_db 1

# Verificar contextos de seguridad
ls -Z /var/www/talentus
```

---

## 13. Instalación de Certificado SSL con Cloudflare

Ya tienes configurado Cloudflare para tu dominio principal. **Puedes usar el mismo API Token** para generar el certificado del sistema.

### 13.1 Verificar Plugin de Cloudflare

```bash
# El plugin ya debería estar instalado, verificar
certbot --help | grep cloudflare

# Si no está instalado:
# sudo dnf install -y python3-certbot-dns-cloudflare
```

### 13.2 Configurar DNS para el Subdominio

**En el panel de Cloudflare**:

1. Ve a **DNS** → **Records**
2. Agrega un registro **A**:
    - **Type**: A
    - **Name**: sistema
    - **IPv4 address**: IP de tu servidor
    - **Proxy status**: ✅ Proxied (nube naranja activa)
    - **TTL**: Auto

### 13.3 Opción A: Script Automatizado (Recomendado)

Incluido en el repositorio: `docs/setup-talentus-sistema-ssl.sh`

```bash
# Copiar script al servidor
scp docs/setup-talentus-sistema-ssl.sh root@tu-servidor:/root/

# En el servidor, ejecutar
sudo bash /root/setup-talentus-sistema-ssl.sh
```

El script automáticamente:

-   ✅ Verifica credenciales de Cloudflare existentes
-   ✅ Verifica el registro DNS
-   ✅ Genera certificado SSL
-   ✅ Muestra instrucciones de próximos pasos

### 13.4 Opción B: Generar Certificado Manualmente

```bash
# Reiniciar sesión o reiniciar servidor
sudo reboot
```

#### B. Instalar ext-uv para mejor rendimiento (Opcional pero Recomendado)

```bash
# Instalar dependencias
sudo dnf install -y libuv libuv-devel

# Instalar extensión vía PECL
sudo pecl install uv

# Habilitar extensión
echo "extension=uv.so" | sudo tee /etc/php.d/40-uv.ini

# Verificar instalación
php -m | grep uv

# Reiniciar PHP-FPM
sudo systemctl restart php-fpm
```

#### C. Aumentar Puertos Disponibles

```bash
# Ver rango actual de puertos
cat /proc/sys/net/ipv4/ip_local_port_range

# Editar configuración del sistema
sudo nano /etc/sysctl.conf
```

**Agregar o modificar**:

```conf
# Aumentar rango de puertos disponibles
net.ipv4.ip_local_port_range = 15000 65000

# Optimizaciones de red para WebSockets
net.core.somaxconn = 4096
net.ipv4.tcp_max_syn_backlog = 4096
```

**Aplicar cambios**:

```bash
sudo sysctl -p
```

### 10.3 Configurar Apache como Reverse Proxy para Reverb

**Habilitar módulos necesarios**:

```bash
sudo dnf install -y mod_proxy_wstunnel

# Verificar módulos
sudo httpd -M | grep -E 'proxy|websocket'
```

**Editar VirtualHost SSL**:

```bash
sudo nano /etc/httpd/conf.d/talentus-sistema.conf
```

**Agregar dentro del bloque `<VirtualHost *:443>`** (antes del cierre):

```apache
    # WebSocket Reverse Proxy para Reverb
    # Manejar conexiones WebSocket en /app (conexiones de clientes)
    <Location /app>
        ProxyPass ws://127.0.0.1:8080/app
        ProxyPassReverse ws://127.0.0.1:8080/app
    </Location>

    # Manejar API requests en /apps (eventos de servidor)
    <Location /apps>
        ProxyPass http://127.0.0.1:8080/apps
        ProxyPassReverse http://127.0.0.1:8080/apps
    </Location>

    # Configuración de proxy para WebSockets
    ProxyRequests Off
    ProxyPreserveHost On

    <Proxy *>
        Require all granted
    </Proxy>
```

**Verificar y reiniciar Apache**:

```bash
sudo apachectl configtest
sudo systemctl restart httpd
```

### 10.4 Configurar Supervisor para Reverb

```bash
sudo nano /etc/supervisord.d/talentus-reverb.ini
```

**Contenido del archivo**:

```ini
[program:talentus-reverb]
process_name=%(program_name)s
command=/usr/bin/php /var/www/talentus/artisan reverb:start --host=0.0.0.0 --port=8080 --hostname=sistema.talentustechnology.com
autostart=true
autorestart=true
user=apache
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/talentus/storage/logs/reverb.log
stdout_logfile_maxbytes=10MB
stdout_logfile_backups=5
stopwaitsecs=10
stopasgroup=true
killasgroup=true
priority=100
```

**Explicación de parámetros específicos de Reverb**:

-   `--host=0.0.0.0`: Escucha en todas las interfaces de red (necesario para reverse proxy)
-   `--port=8080`: Puerto interno (Apache hace proxy de 443 → 8080)
-   `--hostname=sistema.talentustechnology.com`: Dominio público para validación CORS
-   `priority=100`: Prioridad media (inicia después de Horizon)
-   `stopwaitsecs=10`: Tiempo corto ya que Reverb cierra conexiones rápidamente
-   `numprocs=1`: Solo 1 proceso (Reverb es multi-threaded internamente)

**Explicación de parámetros específicos de Reverb**:

-   `--host=0.0.0.0`: Escucha en todas las interfaces de red (necesario para reverse proxy)
-   `--port=8080`: Puerto interno (Apache hace proxy de 443 → 8080)
-   `--hostname=sistema.talentustechnology.com`: Dominio público para validación CORS
-   `priority=100`: Prioridad media (inicia después de Workers)
-   `stopwaitsecs=10`: Tiempo corto ya que Reverb cierra conexiones rápidamente
-   `numprocs=1`: Solo 1 proceso (Reverb es multi-threaded internamente)

### 10.5 Iniciar Reverb

```bash
# Recargar configuración de Supervisor
sudo supervisorctl reread
sudo supervisorctl update

# Iniciar Reverb
sudo supervisorctl start talentus-reverb

# Verificar estado
sudo supervisorctl status talentus-reverb
```

**Salida esperada**:

```
talentus-reverb                  RUNNING   pid 12346, uptime 0:00:03
```

### 10.6 Verificar Todo el Stack de Supervisord

```bash
# Ver estado completo
sudo supervisorctl status
```

**Salida esperada**:

```
talentus-worker:talentus-worker_00   RUNNING   pid 12345, uptime 0:05:23
talentus-worker:talentus-worker_01   RUNNING   pid 12346, uptime 0:05:23
talentus-worker:talentus-worker_02   RUNNING   pid 12347, uptime 0:05:23
talentus-worker:talentus-worker_03   RUNNING   pid 12348, uptime 0:05:23
talentus-worker:talentus-worker_04   RUNNING   pid 12349, uptime 0:05:23
talentus-reverb                      RUNNING   pid 12350, uptime 0:03:15
```

### 10.7 Comandos Útiles para Reverb

```bash
# Ver logs de Reverb en tiempo real
sudo tail -f /var/www/talentus/storage/logs/reverb.log

# Reiniciar Reverb (después de cambios)
sudo supervisorctl restart talentus-reverb

# Detener Reverb
sudo supervisorctl stop talentus-reverb

# Ver conexiones WebSocket activas
sudo netstat -an | grep :8080

# Ver procesos de Reverb
ps aux | grep reverb

# Probar conexión WebSocket desde servidor
curl -i -N -H "Connection: Upgrade" -H "Upgrade: websocket" http://localhost:8080/app
```

### 10.8 Troubleshooting Reverb

#### Reverb no inicia

```bash
# Ver logs de error
sudo tail -f /var/www/talentus/storage/logs/reverb.log
sudo tail -f /var/log/supervisor/supervisord.log

# Verificar que el puerto 8080 no esté ocupado
sudo netstat -tulpn | grep :8080

# Si está ocupado, matar proceso
sudo lsof -ti:8080 | xargs kill -9

# Probar comando manualmente
sudo -u apache /usr/bin/php /var/www/talentus/artisan reverb:start --host=0.0.0.0 --port=8080
```

#### WebSocket no conecta desde navegador

```bash
# Verificar que Apache tiene el módulo WebSocket
sudo httpd -M | grep proxy_wstunnel

# Verificar configuración de VirtualHost
sudo apachectl configtest

# Ver logs de Apache
sudo tail -f /var/log/httpd/sistema-error.log

# Probar conexión directa (sin SSL)
wscat -c ws://localhost:8080/app
```

#### Verificar configuración completa

```bash
# Test desde Laravel Tinker
php /var/www/talentus/artisan tinker

>>> broadcast(new App\Events\TestEvent('Hola'));
>>> exit

# Escuchar desde navegador (abrir consola del navegador)
# Debería aparecer el evento en tiempo real
```

```bash
# Editar configuración global de Supervisor
sudo nano /etc/supervisord.conf
```

**Buscar la sección `[supervisord]` y agregar/modificar**:

```ini
[supervisord]
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid
childlogdir=/var/log/supervisor
minfds=10000
minprocs=200
```

**Crear directorio de logs si no existe**:

```bash
sudo mkdir -p /var/log/supervisor
```

### 10.6 Iniciar Reverb

```bash
# Recargar configuración de Supervisor
sudo supervisorctl reread
sudo supervisorctl update

# Iniciar Reverb
sudo supervisorctl start talentus-reverb:*

# Verificar estado
sudo supervisorctl status
```

**Deberías ver**:

```
talentus-horizon:talentus-horizon_00   RUNNING   pid 1234, uptime 0:00:05
talentus-reverb                        RUNNING   pid 1235, uptime 0:00:05
```

### 10.7 Configurar Firewall para Reverb

```bash
# Abrir puerto 8080 solo para localhost (Apache hace el proxy)
# No es necesario abrir el puerto externamente

# Si necesitas acceso directo al puerto (desarrollo):
# sudo firewall-cmd --permanent --add-port=8080/tcp
# sudo firewall-cmd --reload
```

### 10.8 Verificar Reverb

**Ver logs**:

```bash
sudo tail -f /var/www/talentus/storage/logs/reverb.log
```

**Test de conexión**:

```bash
# Desde el servidor
curl -I http://localhost:8080/apps

# Deberías recibir una respuesta 200 OK
```

**Test WebSocket desde navegador** (abrir DevTools → Console):

```javascript
// En la consola del navegador de tu aplicación
Echo.connector.pusher.connection.bind("connected", () => {
    console.log("✅ Conectado a Reverb!");
});

Echo.connector.pusher.connection.bind("error", (err) => {
    console.error("❌ Error Reverb:", err);
});
```

### 10.9 Comandos Útiles de Reverb

```bash
# Ver logs en tiempo real
sudo tail -f /var/www/talentus/storage/logs/reverb.log

# Reiniciar Reverb (después de cambios)
sudo supervisorctl restart talentus-reverb:*

# Ver estadísticas de conexiones (si está habilitado)
sudo -u apache php artisan reverb:status

# Detener Reverb
sudo supervisorctl stop talentus-reverb:*

# Ver todos los procesos
sudo supervisorctl status
```

### 10.10 Troubleshooting Reverb

#### Reverb no inicia

```bash
# Ver logs detallados
sudo tail -50 /var/www/talentus/storage/logs/reverb.log

# Verificar que el puerto 8080 esté libre
sudo netstat -tulpn | grep 8080

# Verificar permisos
sudo chown -R apache:apache /var/www/talentus/storage/logs
```

#### WebSocket no conecta desde el navegador

```bash
# Verificar configuración de Apache
sudo apachectl -M | grep proxy

# Verificar proxy en VirtualHost
sudo nano /etc/httpd/conf.d/talentus-sistema.conf

# Ver logs de Apache
sudo tail -f /var/log/httpd/talentus-sistema-ssl-error.log
```

#### "Too many open files"

```bash
# Verificar límites aplicados
sudo -u apache bash -c 'ulimit -n'

# Si no se aplicaron, reiniciar servidor
sudo reboot
```

---

## 11. Configurar Tareas Programadas (Cron)

Laravel Scheduler ejecuta las siguientes tareas:

-   Backups diarios (limpieza 01:00, ejecución 22:00)
-   Recordatorios (07:40)
-   Detalle de cobros (08:50)
-   Limpieza de logs de actividad (diario)
-   Notificaciones de cumpleaños (07:50)
-   Limpieza de Telescope (diario)

### 11.1 Configurar Crontab

```bash
# Editar crontab para usuario apache
sudo crontab -u apache -e
```

**Agregar esta línea**:

```cron
* * * * * cd /var/www/talentus && php artisan schedule:run >> /dev/null 2>&1
```

**Verificar crontab**:

```bash
sudo crontab -u apache -l
```

---

## 12. Configurar Firewall

```bash
# Permitir HTTP y HTTPS
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https

# Recargar firewall
sudo firewall-cmd --reload

# Verificar reglas
sudo firewall-cmd --list-all
```

---

## 13. Configurar SELinux (Importante en AlmaLinux)

```bash
# Permitir que Apache se conecte a la red (para APIs externas)
sudo setsebool -P httpd_can_network_connect 1

# Permitir que Apache envíe correos
sudo setsebool -P httpd_can_sendmail 1

# Permitir conexión a Redis
sudo setsebool -P httpd_can_network_connect_db 1

# Verificar contextos de seguridad
ls -Z /var/www/talentus
```

---

## 14. Instalación de Certificado SSL con Cloudflare

Ya tienes configurado Cloudflare para tu dominio principal. **Puedes usar el mismo API Token** para generar el certificado del sistema.

### 14.1 Verificar Plugin de Cloudflare

```bash
# El plugin ya debería estar instalado, verificar
certbot --help | grep cloudflare

# Si no está instalado:
# sudo dnf install -y python3-certbot-dns-cloudflare
```

### 14.2 Configurar DNS para el Subdominio

**En el panel de Cloudflare**:

1. Ve a **DNS** → **Records**
2. Agrega un registro **A**:
    - **Type**: A
    - **Name**: sistema
    - **IPv4 address**: IP de tu servidor
    - **Proxy status**: ✅ Proxied (nube naranja activa)
    - **TTL**: Auto

### 14.3 Opción A: Script Automatizado (Recomendado)

Incluido en el repositorio: `docs/setup-talentus-sistema-ssl.sh`

```bash
# Copiar script al servidor
scp docs/setup-talentus-sistema-ssl.sh root@tu-servidor:/root/

# En el servidor, ejecutar
sudo bash /root/setup-talentus-sistema-ssl.sh
```

El script automáticamente:

-   ✅ Verifica credenciales de Cloudflare existentes
-   ✅ Verifica el registro DNS
-   ✅ Genera certificado SSL
-   ✅ Muestra instrucciones de próximos pasos

### 14.4 Opción B: Generar Certificado Manualmente

```bash
# Usar el mismo archivo de credenciales de Cloudflare
CLOUDFLARE_CONFIG="/root/.secrets/cloudflare.ini"

# Generar certificado para el subdominio sistema
sudo certbot certonly \
  --dns-cloudflare \
  --dns-cloudflare-credentials "$CLOUDFLARE_CONFIG" \
  --dns-cloudflare-propagation-seconds 60 \
  -d sistema.talentustechnology.com \
  --email admin@talentustechnology.com \
  --agree-tos \
  --non-interactive \
  --preferred-challenges dns-01
```

**Salida esperada**:

```
Successfully received certificate.
Certificate is saved at: /etc/letsencrypt/live/sistema.talentustechnology.com/fullchain.pem
Key is saved at:         /etc/letsencrypt/live/sistema.talentustechnology.com/privkey.pem
```

### 14.5 Verificar Certificados Instalados

```bash
# Listar todos los certificados
sudo certbot certificates

# Deberías ver:
# 1. talentustechnology.com (dominio principal)
# 2. sistema.talentustechnology.com (nuevo)
```

### 14.6 Configurar Cloudflare SSL Mode

**En el panel de Cloudflare** → **SSL/TLS** → **Overview**:

-   **Modo SSL/TLS**: Seleccionar **Full (strict)**
-   **Always Use HTTPS**: ✅ Activado
-   **Automatic HTTPS Rewrites**: ✅ Activado
-   **Minimum TLS Version**: TLS 1.2

### 14.7 Actualizar .env de Laravel

```bash
sudo nano /var/www/talentus/.env
```

```env
APP_URL=https://sistema.talentustechnology.com
```

### 14.8 Reiniciar Apache

```bash
# Verificar configuración
sudo apachectl configtest

# Si todo está OK, reiniciar
sudo systemctl restart httpd
```

### 14.9 Probar HTTPS

```bash
# Desde el servidor
curl -I https://sistema.talentustechnology.com

# Verificar calidad SSL
# https://www.ssllabs.com/ssltest/analyze.html?d=sistema.talentustechnology.com
```

### 14.10 Renovación Automática

Los certificados se renovarán automáticamente. El hook de Apache ya está configurado:

```bash
# Ver próxima renovación
sudo systemctl list-timers | grep certbot

# Probar renovación (dry-run)
sudo certbot renew --dry-run
```

### 14.11 Forzar HTTPS (Ya configurado)

El VirtualHost HTTP ya tiene la redirección automática a HTTPS configurada en la sección 3.1.

---

## 15. Monitoreo y Logs

### 15.1 Logs de Laravel

```bash
# Ver logs de Laravel
sudo tail -f /var/www/talentus/storage/logs/laravel.log

# Ver logs de Horizon
sudo tail -f /var/www/talentus/storage/logs/horizon.log

# Ver logs de Reverb
sudo tail -f /var/www/talentus/storage/logs/reverb.log
```

### 15.2 Logs de Apache

```bash
# Error logs del sistema
sudo tail -f /var/log/httpd/talentus-sistema-ssl-error.log

# Access logs del sistema
sudo tail -f /var/log/httpd/talentus-sistema-ssl-access.log

# Logs generales de Apache
sudo tail -f /var/log/httpd/error_log
```

### 15.3 Acceder a Horizon Dashboard

```
https://sistema.talentustechnology.com/horizon
```

**Proteger Horizon en Producción** (editar `app/Providers/HorizonServiceProvider.php`):

```php
protected function gate()
{
    Gate::define('viewHorizon', function ($user) {
        return in_array($user->email, [
            'admin@talentustechnology.com',
        ]);
    });
}
```

---

## 16. Optimizaciones de Rendimiento

### 16.1 OPcache

Ya está configurado en `/etc/php.ini`. Verificar:

```bash
php -i | grep opcache
```

### 16.2 Cachear todo en Laravel

```bash
cd /var/www/talentus

sudo -u apache php artisan config:cache
sudo -u apache php artisan route:cache
sudo -u apache php artisan view:cache
sudo -u apache php artisan event:cache
```

### 16.3 Optimizar Composer Autoload

```bash
sudo -u apache composer dump-autoload --optimize --classmap-authoritative
```

---

## 17. Script de Despliegue

Crear script para futuros despliegues:

```bash
sudo nano /usr/local/bin/deploy-talentus.sh
```

**Contenido**:

```bash
#!/bin/bash

echo "🚀 Iniciando despliegue de Talentus..."

cd /var/www/talentus

# Modo mantenimiento
sudo -u apache php artisan down

# Actualizar código (si usas Git)
# sudo -u apache git pull origin main

# Actualizar dependencias
sudo -u apache composer install --no-dev --optimize-autoloader

# Ejecutar migraciones
sudo -u apache php artisan migrate --force

# Limpiar cachés
sudo -u apache php artisan cache:clear
sudo -u apache php artisan config:clear
sudo -u apache php artisan route:clear
sudo -u apache php artisan view:clear

# Cachear configuraciones
sudo -u apache php artisan config:cache
sudo -u apache php artisan route:cache
sudo -u apache php artisan view:cache
sudo -u apache php artisan event:cache

# Compilar assets (si hay cambios)
sudo -u apache npm install
sudo -u apache npm run build

# Reiniciar Horizon y Reverb
sudo supervisorctl restart talentus-horizon:*
sudo supervisorctl restart talentus-reverb:*

# Salir de modo mantenimiento
sudo -u apache php artisan up

echo "✅ Despliegue completado"
```

```bash
# Dar permisos de ejecución
sudo chmod +x /usr/local/bin/deploy-talentus.sh

# Ejecutar cuando necesites desplegar
sudo /usr/local/bin/deploy-talentus.sh
```

---

## 18. Troubleshooting Común

### 18.1 Error 500 - Internal Server Error

```bash
# Verificar logs
sudo tail -50 /var/www/talentus/storage/logs/laravel.log
sudo tail -50 /var/log/httpd/talentus-sistema-ssl-error.log

# Verificar permisos
sudo chown -R apache:apache /var/www/talentus
sudo chmod -R 775 /var/www/talentus/storage
sudo chmod -R 775 /var/www/talentus/bootstrap/cache

# Verificar SELinux contexts
sudo restorecon -Rv /var/www/talentus
```

### 18.2 Horizon no procesa Jobs

```bash
# Ver estado de Horizon
sudo supervisorctl status talentus-horizon:*

# Ver logs
sudo tail -f /var/www/talentus/storage/logs/horizon.log

# Reiniciar Horizon
sudo supervisorctl restart talentus-horizon:*

# Verificar conexión a Redis
redis-cli -a TU_CONTRASEÑA_REDIS PING
```

### 18.3 Assets no se cargan

```bash
# Verificar link simbólico
ls -la /var/www/talentus/public/storage

# Recrear si es necesario
sudo -u apache php artisan storage:link

# Recompilar assets
sudo -u apache npm run build
```

### 18.4 Error de conexión a Base de Datos

```bash
# Verificar MariaDB esté corriendo
sudo systemctl status mariadb

# Probar conexión
mysql -u talentus_user -p talentus

# Verificar credenciales en .env
sudo nano /var/www/talentus/.env
```

### 18.5 Reverb / WebSocket no conecta

```bash
# Verificar que Reverb esté corriendo
sudo supervisorctl status talentus-reverb:*

# Ver logs de Reverb
sudo tail -f /var/www/talentus/storage/logs/reverb.log

# Verificar puerto 8080 esté libre
sudo netstat -tulpn | grep 8080

# Verificar configuración de Apache proxy
sudo apachectl -M | grep proxy

# Reiniciar Reverb
sudo supervisorctl restart talentus-reverb:*
```

---

## 19. Seguridad Adicional

### 18.1 Configurar Fail2Ban

```bash
sudo dnf install -y fail2ban

sudo nano /etc/fail2ban/jail.d/apache.conf
```

```ini
[apache-auth]
enabled = true
port = http,https
filter = apache-auth
logpath = /var/log/httpd/*error.log
maxretry = 5
bantime = 3600
```

```bash
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### 18.2 Ocultar versión de PHP y Apache

```bash
# PHP
sudo nano /etc/php.ini
```

```ini
expose_php = Off
```

```bash
# Apache
sudo nano /etc/httpd/conf/httpd.conf
```

```apache
ServerTokens Prod
ServerSignature Off
```

```bash
sudo systemctl restart httpd
sudo systemctl restart php-fpm
```

---

## 20. Backup Automatizado

El sistema ya tiene configurado backups mediante `spatie/laravel-backup`.

### 20.1 Configurar destino de backups

```bash
sudo nano /var/www/talentus/config/backup.php
```

### 20.2 Verificar que los backups funcionen

```bash
# Ejecutar backup manual
sudo -u apache php artisan backup:run

# Ver backups
ls -lh /var/www/talentus/storage/app/backups/
```

---

## 21. Checklist Final

-   [ ] PHP 8.3+ instalado y configurado (con ext-uv para Reverb)
-   [ ] Apache HTTPD corriendo con VirtualHost configurado
-   [ ] MariaDB corriendo con base de datos creada
-   [ ] Redis corriendo con contraseña configurada
-   [ ] Composer instalado
-   [ ] Node.js y NPM instalados
-   [ ] Proyecto desplegado en `/var/www/talentus`
-   [ ] Permisos correctos en storage y cache
-   [ ] Variables de entorno configuradas en `.env` (incluye Reverb)
-   [ ] Migraciones ejecutadas
-   [ ] Assets compilados
-   [ ] Límites de sistema aumentados (open files, puertos)
-   [ ] Supervisord instalado, Horizon y Reverb corriendo
-   [ ] Apache configurado como reverse proxy para WebSockets
-   [ ] Crontab configurado para Laravel Scheduler
-   [ ] Firewall configurado (HTTP/HTTPS)
-   [ ] SELinux configurado correctamente
-   [ ] Certificado SSL instalado con Cloudflare
-   [ ] Logs rotando correctamente
-   [ ] Horizon Dashboard accesible y protegido
-   [ ] Reverb / WebSockets funcionando
-   [ ] Backups programados funcionando

---

## 22. Comandos Rápidos de Referencia

```bash
# Reiniciar servicios
sudo systemctl restart httpd
sudo systemctl restart mariadb
sudo systemctl restart redis
sudo systemctl restart php-fpm
sudo supervisorctl restart talentus-horizon:*
sudo supervisorctl restart talentus-reverb:*

# Ver logs en tiempo real
sudo tail -f /var/www/talentus/storage/logs/laravel.log
sudo tail -f /var/www/talentus/storage/logs/horizon.log
sudo tail -f /var/www/talentus/storage/logs/reverb.log
sudo tail -f /var/log/httpd/talentus-sistema-ssl-error.log

# Limpiar cachés de Laravel
sudo -u apache php artisan cache:clear
sudo -u apache php artisan config:clear
sudo -u apache php artisan route:clear
sudo -u apache php artisan view:clear

# Cachear configuraciones
sudo -u apache php artisan config:cache
sudo -u apache php artisan route:cache
sudo -u apache php artisan view:cache

# Verificar estado de colas y WebSockets
sudo -u apache php artisan queue:work --once  # Procesar 1 job
sudo -u apache php artisan horizon:status     # Estado de Horizon
sudo supervisorctl status                      # Estado de todos los procesos

# Test WebSocket
curl -I http://localhost:8080/apps            # Debe devolver 200 OK

# Ejecutar comando manualmente
sudo -u apache php artisan tinker

# Backups
sudo -u apache php artisan backup:run
sudo -u apache php artisan backup:list
sudo -u apache php artisan backup:clean
```

---

## Soporte y Contacto

Para dudas sobre la aplicación, contactar al equipo de desarrollo de Talentus Technology.

**Versión del documento**: 2.0  
**Fecha**: Enero 2026  
**Laravel Version**: 12.x  
**PHP Version**: 8.3.x  
**Incluye**: Horizon + Reverb + Cloudflare SSL

**Versión del documento**: 1.0  
**Fecha**: Enero 2026  
**Laravel Version**: 12.x  
**PHP Version**: 8.3.x
