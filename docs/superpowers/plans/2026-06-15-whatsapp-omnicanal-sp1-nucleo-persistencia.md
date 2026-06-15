# WhatsApp Omnicanal · SP#1 Núcleo Conversacional + Persistencia — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Persistir de forma confiable todo mensaje de WhatsApp (entrante y saliente) en un modelo conversacional, vía un pipeline Node→Laravel(Job), sin depender del navegador.

**Architecture:** Node/Baileys descarga media y hace `POST` a un endpoint interno de Laravel; un Job en la cola `whatsapp` resuelve contacto/empresa/cliente, hila la conversación (1 abierta por contacto+device), persiste el mensaje (idempotente por `device_id+wa_message_id`) y emite eventos Reverb. El envío saliente persiste antes de delegar al `WhatsappService` existente.

**Tech Stack:** Laravel 12, Livewire (consumo en SP#2), MySQL, Reverb, PHPUnit (solo `php -l`, ver nota), Node/Baileys.

> **Restricción de validación (OVERRIDE del usuario):** NUNCA ejecutar `php artisan test` — el suite usa la BD real con `RefreshDatabase` y la borraría. La verificación de cada archivo PHP es `php -l <archivo>`. `php artisan migrate` SÍ es seguro (es aditivo). Los commits son frecuentes pero **no se hace push** salvo que el usuario lo pida.

**Spec:** `docs/superpowers/specs/2026-06-15-whatsapp-omnicanal-sp1-nucleo-persistencia-design.md`

---

## File Structure

**Config / helpers**
- Modify `config/whatsapp.php` — claves `internal_token`, `default_empresa_id`, `media_disk`, `media_path`
- Modify `app/helpers.php` — `normalize_wa_number()`
- Modify `.env.example` — variables nuevas

**Migrations** (`database/migrations/`)
- `*_add_whatsapp_fields_to_contacts_table.php`
- `*_create_whatsapp_conversations_table.php`
- `*_create_whatsapp_messages_table.php`
- `*_create_whatsapp_assignments_table.php`
- `*_create_whatsapp_tags_table.php`
- `*_create_whatsapp_conversation_tag_table.php`

**Enums** (`app/Enums/WhatsFleep/`)
- `ConversationStatus.php`, `ConversationPriority.php`, `MessageType.php`, `MessageSenderType.php`, `MessageStatus.php`

**Models** (`app/Models/WhatsFleep/`)
- Modify `Contact.php`
- Create `WhatsappConversation.php`, `WhatsappMessage.php`, `WhatsappAssignment.php`, `WhatsappTag.php`

**Events** (`app/Events/WhatsFleep/`)
- `NewWhatsappMessage.php`, `ConversationUpdated.php`

**Actions** (`app/Actions/WhatsFleep/`)
- `ResolveWhatsappContactAction.php`, `ResolveConversationAction.php`, `PersistIncomingMessageAction.php`, `SendWhatsappMessageAction.php`

**Ingesta HTTP**
- Create `app/Http/Middleware/VerifyInternalToken.php`; Modify `app/Http/Kernel.php`
- Create `app/Http/Requests/WhatsFleep/StoreIncomingWhatsappRequest.php`
- Create `app/Http/Requests/WhatsFleep/UpdateWhatsappStatusRequest.php`
- Create `app/Jobs/WhatsFleep/ProcessIncomingWhatsappMessage.php`
- Create `app/Http/Controllers/Api/WhatsFleep/IncomingWhatsappController.php`
- Modify `routes/api.php`

**Node** (`server/`)
- Modify `server/controllers/incomingMessage.js`
- Modify `server/whatsapp.js`

---

## Task 1: Config y variables de entorno

**Files:**
- Modify: `config/whatsapp.php`
- Modify: `.env.example`

- [ ] **Step 1: Añadir claves a `config/whatsapp.php`**

Reemplaza el `return [...]` existente para que quede así:

```php
<?php

return [
    'ip_protection_enabled' => env('IP_PROTECTION_ENABLED', false),
    'allowed_ips' => env('ALLOWED_IPS', '127.0.0.1,::1'),
    'allowed_domains' => env('ALLOWED_DOMAINS', 'localhost'),
    'node_server_url' => env('NODE_SERVER_URL', 'http://localhost:3000'),
    'socket_url' => env('SOCKET_URL', 'http://localhost:3000'),
    'server_url' => env('WA_URL_SERVER', 'http://localhost:3000'),

    // Omnicanal SP#1
    'internal_token' => env('WHATSAPP_INTERNAL_TOKEN'),
    'default_empresa_id' => (int) env('WHATSAPP_DEFAULT_EMPRESA_ID', 1),
    'media_disk' => env('WHATSAPP_MEDIA_DISK', 'public'),
    'media_path' => 'whatsapp',
    'country_code' => env('WHATSAPP_COUNTRY_CODE', '51'),
];
```

- [ ] **Step 2: Añadir variables a `.env.example`**

Agrega al final del archivo:

```
# WhatsApp Omnicanal (SP#1)
WHATSAPP_INTERNAL_TOKEN=
WHATSAPP_DEFAULT_EMPRESA_ID=1
WHATSAPP_MEDIA_DISK=public
WHATSAPP_COUNTRY_CODE=51
```

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l config/whatsapp.php`
Expected: `No syntax errors detected in config/whatsapp.php`

- [ ] **Step 4: Commit**

```bash
git add config/whatsapp.php .env.example
git commit -m "feat(wa): add omnichannel config keys (internal token, default empresa, media, country code)"
```

---

## Task 2: Helper `normalize_wa_number`

**Files:**
- Modify: `app/helpers.php`

- [ ] **Step 1: Añadir la función al final de `app/helpers.php` (dentro del bloque sin namespace, junto a las funciones existentes)**

```php
if (! function_exists('normalize_wa_number')) {
    /**
     * Normaliza un número de WhatsApp a su forma comparable:
     * elimina todo lo que no sea dígito y, si tiene el código de país
     * configurado como prefijo y queda más largo que un celular local,
     * lo retira para dejar el número nacional (Perú: 9 dígitos).
     */
    function normalize_wa_number(?string $raw): string
    {
        $digits = preg_replace('/\D+/', '', (string) $raw);

        if ($digits === '') {
            return '';
        }

        $cc = (string) config('whatsapp.country_code', '51');

        if ($cc !== '' && str_starts_with($digits, $cc) && strlen($digits) > 9) {
            $digits = substr($digits, strlen($cc));
        }

        return $digits;
    }
}
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/helpers.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verificación funcional rápida (no toca la BD)**

Run: `php -r "require 'vendor/autoload.php'; \$app = require 'bootstrap/app.php'; \$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); echo normalize_wa_number('+51 987-654-321').PHP_EOL; echo normalize_wa_number('987654321').PHP_EOL;"`
Expected: dos líneas `987654321`

- [ ] **Step 4: Commit**

```bash
git add app/helpers.php
git commit -m "feat(wa): add normalize_wa_number helper (strips country code 51)"
```

---

## Task 3: Migración — extender `contacts`

**Files:**
- Create: `database/migrations/2026_06_15_100001_add_whatsapp_fields_to_contacts_table.php`

- [ ] **Step 1: Crear la migración**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')->default(1)->after('id')->index();
            $table->unsignedBigInteger('cliente_id')->nullable()->after('empresa_id');
            $table->string('wa_jid')->nullable()->after('number');
            $table->string('push_name')->nullable()->after('wa_jid');
            $table->string('profile_pic_url')->nullable()->after('push_name');
            $table->json('metadata')->nullable()->after('profile_pic_url');

            $table->unique(['empresa_id', 'number']);
            $table->index('cliente_id');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropUnique(['empresa_id', 'number']);
            $table->dropIndex(['cliente_id']);
            $table->dropIndex(['empresa_id']);
            $table->dropColumn([
                'empresa_id', 'cliente_id', 'wa_jid',
                'push_name', 'profile_pic_url', 'metadata',
            ]);
        });
    }
};
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l database/migrations/2026_06_15_100001_add_whatsapp_fields_to_contacts_table.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit (la migración se corre al final, Task 23)**

```bash
git add database/migrations/2026_06_15_100001_add_whatsapp_fields_to_contacts_table.php
git commit -m "feat(wa): migration to extend contacts with whatsapp identity fields"
```

---

## Task 4: Migración — `whatsapp_conversations`

**Files:**
- Create: `database/migrations/2026_06_15_100002_create_whatsapp_conversations_table.php`

- [ ] **Step 1: Crear la migración**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_conversations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('empresa_id')->index();
            $table->foreignId('device_id')->constrained('devices')->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained('contacts')->cascadeOnDelete();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->unsignedBigInteger('assigned_user_id')->nullable();
            $table->enum('status', ['open', 'pending', 'closed'])->default('open');
            $table->enum('priority', ['low', 'normal', 'high', 'emergency'])->default('normal');
            $table->unsignedInteger('unread_count')->default(0);
            $table->unsignedBigInteger('last_message_id')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->json('metadata')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['empresa_id', 'status', 'last_message_at']);
            $table->index(['contact_id', 'status']);
            $table->index('cliente_id');
            $table->index('assigned_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_conversations');
    }
};
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l database/migrations/2026_06_15_100002_create_whatsapp_conversations_table.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add database/migrations/2026_06_15_100002_create_whatsapp_conversations_table.php
git commit -m "feat(wa): migration whatsapp_conversations"
```

---

## Task 5: Migración — `whatsapp_messages`

**Files:**
- Create: `database/migrations/2026_06_15_100003_create_whatsapp_messages_table.php`

- [ ] **Step 1: Crear la migración**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('empresa_id')->index();
            $table->foreignId('conversation_id')->constrained('whatsapp_conversations')->cascadeOnDelete();
            $table->foreignId('device_id')->constrained('devices')->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained('contacts')->cascadeOnDelete();
            $table->string('wa_message_id')->nullable();
            $table->enum('sender_type', ['contact', 'agent', 'system'])->default('contact');
            $table->unsignedBigInteger('sender_user_id')->nullable();
            $table->enum('type', ['text', 'image', 'audio', 'video', 'document', 'location', 'contact', 'sticker'])->default('text');
            $table->text('body')->nullable();
            $table->string('media_path')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('file_name')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->enum('status', ['pending', 'sent', 'delivered', 'read', 'failed'])->default('pending');
            $table->boolean('is_read')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['conversation_id', 'created_at']);
            $table->unique(['device_id', 'wa_message_id']);
            $table->index('sender_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_messages');
    }
};
```

> Nota: MySQL permite múltiples filas con `wa_message_id = NULL` aun bajo índice único, así que los mensajes salientes aún sin id de WhatsApp no chocan.

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l database/migrations/2026_06_15_100003_create_whatsapp_messages_table.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add database/migrations/2026_06_15_100003_create_whatsapp_messages_table.php
git commit -m "feat(wa): migration whatsapp_messages with idempotency unique (device_id, wa_message_id)"
```

---

## Task 6: Migración — `whatsapp_assignments`

**Files:**
- Create: `database/migrations/2026_06_15_100004_create_whatsapp_assignments_table.php`

- [ ] **Step 1: Crear la migración**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->index();
            $table->foreignId('conversation_id')->constrained('whatsapp_conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->string('note')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index('conversation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_assignments');
    }
};
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l database/migrations/2026_06_15_100004_create_whatsapp_assignments_table.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add database/migrations/2026_06_15_100004_create_whatsapp_assignments_table.php
git commit -m "feat(wa): migration whatsapp_assignments (audit append-only)"
```

---

## Task 7: Migraciones — `whatsapp_tags` + pivote

**Files:**
- Create: `database/migrations/2026_06_15_100005_create_whatsapp_tags_table.php`
- Create: `database/migrations/2026_06_15_100006_create_whatsapp_conversation_tag_table.php`

- [ ] **Step 1: Crear `whatsapp_tags`**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->index();
            $table->string('name');
            $table->string('slug');
            $table->string('color')->nullable();
            $table->timestamps();

            $table->unique(['empresa_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_tags');
    }
};
```

- [ ] **Step 2: Crear pivote `whatsapp_conversation_tag`**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_conversation_tag', function (Blueprint $table) {
            $table->foreignId('whatsapp_conversation_id')->constrained('whatsapp_conversations')->cascadeOnDelete();
            $table->foreignId('whatsapp_tag_id')->constrained('whatsapp_tags')->cascadeOnDelete();
            $table->primary(['whatsapp_conversation_id', 'whatsapp_tag_id'], 'wa_conv_tag_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_conversation_tag');
    }
};
```

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l database/migrations/2026_06_15_100005_create_whatsapp_tags_table.php && php -l database/migrations/2026_06_15_100006_create_whatsapp_conversation_tag_table.php`
Expected: dos `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add database/migrations/2026_06_15_100005_create_whatsapp_tags_table.php database/migrations/2026_06_15_100006_create_whatsapp_conversation_tag_table.php
git commit -m "feat(wa): migrations whatsapp_tags and conversation_tag pivot"
```

---

## Task 8: Enums

**Files:**
- Create: `app/Enums/WhatsFleep/ConversationStatus.php`
- Create: `app/Enums/WhatsFleep/ConversationPriority.php`
- Create: `app/Enums/WhatsFleep/MessageType.php`
- Create: `app/Enums/WhatsFleep/MessageSenderType.php`
- Create: `app/Enums/WhatsFleep/MessageStatus.php`

- [ ] **Step 1: `ConversationStatus.php`**

```php
<?php

namespace App\Enums\WhatsFleep;

enum ConversationStatus: string
{
    case Open = 'open';
    case Pending = 'pending';
    case Closed = 'closed';
}
```

- [ ] **Step 2: `ConversationPriority.php`**

```php
<?php

namespace App\Enums\WhatsFleep;

enum ConversationPriority: string
{
    case Low = 'low';
    case Normal = 'normal';
    case High = 'high';
    case Emergency = 'emergency';
}
```

- [ ] **Step 3: `MessageType.php`**

```php
<?php

namespace App\Enums\WhatsFleep;

enum MessageType: string
{
    case Text = 'text';
    case Image = 'image';
    case Audio = 'audio';
    case Video = 'video';
    case Document = 'document';
    case Location = 'location';
    case Contact = 'contact';
    case Sticker = 'sticker';
}
```

- [ ] **Step 4: `MessageSenderType.php`**

```php
<?php

namespace App\Enums\WhatsFleep;

enum MessageSenderType: string
{
    case Contact = 'contact';
    case Agent = 'agent';
    case System = 'system';
}
```

- [ ] **Step 5: `MessageStatus.php`**

```php
<?php

namespace App\Enums\WhatsFleep;

enum MessageStatus: string
{
    case Pending = 'pending';
    case Sent = 'sent';
    case Delivered = 'delivered';
    case Read = 'read';
    case Failed = 'failed';
}
```

- [ ] **Step 6: Verificar sintaxis**

Run: `php -l app/Enums/WhatsFleep/ConversationStatus.php && php -l app/Enums/WhatsFleep/ConversationPriority.php && php -l app/Enums/WhatsFleep/MessageType.php && php -l app/Enums/WhatsFleep/MessageSenderType.php && php -l app/Enums/WhatsFleep/MessageStatus.php`
Expected: cinco `No syntax errors detected`

- [ ] **Step 7: Commit**

```bash
git add app/Enums/WhatsFleep/
git commit -m "feat(wa): conversation and message enums"
```

---

## Task 9: Extender el modelo `Contact`

**Files:**
- Modify: `app/Models/WhatsFleep/Contact.php`

- [ ] **Step 1: Reemplazar el contenido por la versión extendida**

```php
<?php

namespace App\Models\WhatsFleep;

use App\Models\Clientes;
use App\Models\User;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'user_id',
        'tag_id',
        'name',
        'number',
        'wa_jid',
        'push_name',
        'profile_pic_url',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(WaTag::class, 'tag_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')
            ->withTrashed()
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(WhatsappConversation::class, 'contact_id');
    }
}
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Models/WhatsFleep/Contact.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Models/WhatsFleep/Contact.php
git commit -m "feat(wa): extend Contact model with empresa/cliente/wa fields and relations"
```

---

## Task 10: Modelo `WhatsappConversation`

**Files:**
- Create: `app/Models/WhatsFleep/WhatsappConversation.php`

- [ ] **Step 1: Crear el modelo**

```php
<?php

namespace App\Models\WhatsFleep;

use App\Enums\WhatsFleep\ConversationPriority;
use App\Enums\WhatsFleep\ConversationStatus;
use App\Models\Clientes;
use App\Models\Ticket;
use App\Models\User;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsappConversation extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'empresa_id',
        'device_id',
        'contact_id',
        'cliente_id',
        'ticket_id',
        'assigned_user_id',
        'status',
        'priority',
        'unread_count',
        'last_message_id',
        'last_message_at',
        'closed_at',
        'metadata',
    ];

    /**
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getKeyName(): string
    {
        return 'id';
    }

    protected function casts(): array
    {
        return [
            'status' => ConversationStatus::class,
            'priority' => ConversationPriority::class,
            'unread_count' => 'integer',
            'last_message_at' => 'datetime',
            'closed_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')
            ->withTrashed()
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(WhatsappMessage::class, 'conversation_id');
    }

    public function lastMessage(): BelongsTo
    {
        return $this->belongsTo(WhatsappMessage::class, 'last_message_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(WhatsappAssignment::class, 'conversation_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            WhatsappTag::class,
            'whatsapp_conversation_tag',
            'whatsapp_conversation_id',
            'whatsapp_tag_id'
        );
    }

    public function scopeForTenant(Builder $query, int $empresaId): Builder
    {
        return $query->where('empresa_id', $empresaId);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', ConversationStatus::Open->value);
    }

    public function scopeAssignedTo(Builder $query, int $userId): Builder
    {
        return $query->where('assigned_user_id', $userId);
    }
}
```

> `HasUuids` autogenera `uuid` al crear; sobreescribimos `uniqueIds()` para que aplique a la columna `uuid` y mantenemos `id` como primary key.

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Models/WhatsFleep/WhatsappConversation.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Models/WhatsFleep/WhatsappConversation.php
git commit -m "feat(wa): WhatsappConversation model with relations, enums casts, scopes"
```

---

## Task 11: Modelo `WhatsappMessage`

**Files:**
- Create: `app/Models/WhatsFleep/WhatsappMessage.php`

- [ ] **Step 1: Crear el modelo**

```php
<?php

namespace App\Models\WhatsFleep;

use App\Enums\WhatsFleep\MessageSenderType;
use App\Enums\WhatsFleep\MessageStatus;
use App\Enums\WhatsFleep\MessageType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class WhatsappMessage extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'uuid',
        'empresa_id',
        'conversation_id',
        'device_id',
        'contact_id',
        'wa_message_id',
        'sender_type',
        'sender_user_id',
        'type',
        'body',
        'media_path',
        'mime_type',
        'file_name',
        'file_size',
        'status',
        'is_read',
        'metadata',
        'sent_at',
        'delivered_at',
        'read_at',
    ];

    /**
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getKeyName(): string
    {
        return 'id';
    }

    protected function casts(): array
    {
        return [
            'sender_type' => MessageSenderType::class,
            'type' => MessageType::class,
            'status' => MessageStatus::class,
            'is_read' => 'boolean',
            'file_size' => 'integer',
            'metadata' => 'array',
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
            'read_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(WhatsappConversation::class, 'conversation_id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function senderUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function mediaUrl(): ?string
    {
        if (empty($this->media_path)) {
            return null;
        }

        return Storage::disk(config('whatsapp.media_disk', 'public'))->url($this->media_path);
    }

    public function scopeFromContact(Builder $query): Builder
    {
        return $query->where('sender_type', MessageSenderType::Contact->value);
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }
}
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Models/WhatsFleep/WhatsappMessage.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Models/WhatsFleep/WhatsappMessage.php
git commit -m "feat(wa): WhatsappMessage model with enum casts, relations, mediaUrl()"
```

---

## Task 12: Modelos `WhatsappAssignment` y `WhatsappTag`

**Files:**
- Create: `app/Models/WhatsFleep/WhatsappAssignment.php`
- Create: `app/Models/WhatsFleep/WhatsappTag.php`

- [ ] **Step 1: `WhatsappAssignment.php`**

```php
<?php

namespace App\Models\WhatsFleep;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappAssignment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'empresa_id',
        'conversation_id',
        'from_user_id',
        'to_user_id',
        'assigned_by',
        'note',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(WhatsappConversation::class, 'conversation_id');
    }

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
```

- [ ] **Step 2: `WhatsappTag.php`**

```php
<?php

namespace App\Models\WhatsFleep;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WhatsappTag extends Model
{
    protected $fillable = [
        'empresa_id',
        'name',
        'slug',
        'color',
    ];

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(
            WhatsappConversation::class,
            'whatsapp_conversation_tag',
            'whatsapp_tag_id',
            'whatsapp_conversation_id'
        );
    }
}
```

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l app/Models/WhatsFleep/WhatsappAssignment.php && php -l app/Models/WhatsFleep/WhatsappTag.php`
Expected: dos `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Models/WhatsFleep/WhatsappAssignment.php app/Models/WhatsFleep/WhatsappTag.php
git commit -m "feat(wa): WhatsappAssignment and WhatsappTag models"
```

---

## Task 13: Eventos de broadcasting

**Files:**
- Create: `app/Events/WhatsFleep/NewWhatsappMessage.php`
- Create: `app/Events/WhatsFleep/ConversationUpdated.php`

- [ ] **Step 1: `NewWhatsappMessage.php`**

```php
<?php

namespace App\Events\WhatsFleep;

use App\Models\WhatsFleep\WhatsappMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewWhatsappMessage implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public WhatsappMessage $message)
    {
    }

    /**
     * @return array<int, PrivateChannel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('whatsapp.conversation.' . $this->message->conversation->uuid),
        ];
    }

    public function broadcastAs(): string
    {
        return 'wa.message.new';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'uuid' => $this->message->uuid,
            'conversation_id' => $this->message->conversation_id,
            'sender_type' => $this->message->sender_type->value,
            'type' => $this->message->type->value,
            'body' => $this->message->body,
            'media_url' => $this->message->mediaUrl(),
            'status' => $this->message->status->value,
            'created_at' => $this->message->created_at?->toIso8601String(),
        ];
    }
}
```

- [ ] **Step 2: `ConversationUpdated.php`**

```php
<?php

namespace App\Events\WhatsFleep;

use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationUpdated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public WhatsappConversation $conversation)
    {
    }

    /**
     * @return array<int, PrivateChannel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('whatsapp.empresa.' . $this->conversation->empresa_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'wa.conversation.updated';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->conversation->id,
            'uuid' => $this->conversation->uuid,
            'status' => $this->conversation->status->value,
            'unread_count' => $this->conversation->unread_count,
            'assigned_user_id' => $this->conversation->assigned_user_id,
            'last_message_at' => $this->conversation->last_message_at?->toIso8601String(),
        ];
    }
}
```

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l app/Events/WhatsFleep/NewWhatsappMessage.php && php -l app/Events/WhatsFleep/ConversationUpdated.php`
Expected: dos `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Events/WhatsFleep/
git commit -m "feat(wa): broadcast events NewWhatsappMessage and ConversationUpdated"
```

---

## Task 14: `ResolveWhatsappContactAction`

**Files:**
- Create: `app/Actions/WhatsFleep/ResolveWhatsappContactAction.php`

- [ ] **Step 1: Crear la Action**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Models\Clientes;
use App\Models\Contactos;
use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\Device;
use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;

class ResolveWhatsappContactAction
{
    /**
     * Resuelve (o crea) el contacto WhatsApp para un número entrante,
     * intentando vincularlo a un Cliente GPS por teléfono.
     *
     * @return array{contact: Contact, empresa_id: int, cliente_id: int|null}
     */
    public function execute(Device $device, string $rawNumber, ?string $waJid, ?string $pushName): array
    {
        $number = normalize_wa_number($rawNumber);

        [$clienteId, $empresaId] = $this->matchCliente($number);

        $contact = Contact::firstOrNew([
            'empresa_id' => $empresaId,
            'number' => $number,
        ]);

        $contact->user_id = $contact->user_id ?: $device->user_id;
        $contact->cliente_id = $clienteId ?? $contact->cliente_id;
        $contact->wa_jid = $waJid ?: $contact->wa_jid;
        $contact->push_name = $pushName ?: $contact->push_name;
        $contact->name = $contact->name ?: $pushName;
        $contact->save();

        return [
            'contact' => $contact,
            'empresa_id' => $empresaId,
            'cliente_id' => $clienteId,
        ];
    }

    /**
     * Busca el número normalizado en clientes.telefono y contactos.telefono.
     *
     * @return array{0: int|null, 1: int}  [cliente_id|null, empresa_id]
     */
    private function matchCliente(string $number): array
    {
        $default = (int) config('whatsapp.default_empresa_id', 1);

        if ($number === '') {
            return [null, $default];
        }

        $cc = (string) config('whatsapp.country_code', '51');
        $candidates = array_values(array_unique([$number, $cc . $number]));
        $placeholders = implode(',', array_fill(0, count($candidates), '?'));
        $normalized = "REPLACE(REPLACE(REPLACE(telefono, ' ', ''), '-', ''), '+', '')";

        $cliente = Clientes::withoutGlobalScope(EmpresaScope::class)
            ->whereNotNull('telefono')
            ->whereRaw("{$normalized} IN ({$placeholders})", $candidates)
            ->first();

        if ($cliente) {
            return [(int) $cliente->id, (int) $cliente->empresa_id];
        }

        $contacto = Contactos::withoutGlobalScope(EmpresaScope::class)
            ->whereNotNull('telefono')
            ->whereNotNull('clientes_id')
            ->whereRaw("{$normalized} IN ({$placeholders})", $candidates)
            ->first();

        if ($contacto) {
            return [(int) $contacto->clientes_id, (int) ($contacto->empresa_id ?? $default)];
        }

        return [null, $default];
    }
}
```

> El `whereRaw` normaliza la columna en SQL (quita espacios, guiones y `+`) y compara por **igualdad exacta** contra `[number, cc+number]` (no sufijo `LIKE`), evitando enlazar a la empresa equivocada por coincidencia de cola. La columna de cliente en `contactos` es **`clientes_id`** (plural). `Contactos` aplica solo `EmpresaScope` (no `EliminadoScope`), por eso solo se omite ese scope.

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Actions/WhatsFleep/ResolveWhatsappContactAction.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verificar el nombre real del scope de eliminado (evita un fatal en runtime)**

Run: `ls app/Scopes/ | grep -i eliminad`
Expected: confirma el archivo `EliminadoScope.php`. Si no existe o el modelo `Contactos` no lo aplica, quita la línea `->withoutGlobalScope(EliminadoScope::class)` y su `use`.

- [ ] **Step 4: Commit**

```bash
git add app/Actions/WhatsFleep/ResolveWhatsappContactAction.php
git commit -m "feat(wa): ResolveWhatsappContactAction (normalize, firstOrNew, cliente match)"
```

---

## Task 15: `ResolveConversationAction`

**Files:**
- Create: `app/Actions/WhatsFleep/ResolveConversationAction.php`

- [ ] **Step 1: Crear la Action**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\ConversationStatus;
use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappConversation;

class ResolveConversationAction
{
    /**
     * Reabre la conversación abierta de (contacto, device) o crea una nueva.
     * Debe ejecutarse dentro de una transacción (usa lockForUpdate).
     */
    public function execute(Device $device, Contact $contact, int $empresaId, ?int $clienteId): WhatsappConversation
    {
        $conversation = WhatsappConversation::query()
            ->where('device_id', $device->id)
            ->where('contact_id', $contact->id)
            ->where('status', ConversationStatus::Open->value)
            ->lockForUpdate()
            ->first();

        if ($conversation) {
            if ($clienteId && ! $conversation->cliente_id) {
                $conversation->cliente_id = $clienteId;
                $conversation->save();
            }

            return $conversation;
        }

        return WhatsappConversation::create([
            'empresa_id' => $empresaId,
            'device_id' => $device->id,
            'contact_id' => $contact->id,
            'cliente_id' => $clienteId,
            'status' => ConversationStatus::Open,
            'unread_count' => 0,
        ]);
    }
}
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Actions/WhatsFleep/ResolveConversationAction.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Actions/WhatsFleep/ResolveConversationAction.php
git commit -m "feat(wa): ResolveConversationAction (reopen-or-create with lockForUpdate)"
```

---

## Task 16: `PersistIncomingMessageAction`

**Files:**
- Create: `app/Actions/WhatsFleep/PersistIncomingMessageAction.php`

- [ ] **Step 1: Crear la Action**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\MessageSenderType;
use App\Enums\WhatsFleep\MessageStatus;
use App\Enums\WhatsFleep\MessageType;
use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Models\WhatsFleep\WhatsappMessage;
use Illuminate\Support\Carbon;

class PersistIncomingMessageAction
{
    /**
     * Persiste el mensaje entrante de forma idempotente y actualiza la conversación.
     *
     * @param  array<string, mixed>  $payload
     */
    public function execute(
        WhatsappConversation $conversation,
        Device $device,
        Contact $contact,
        array $payload
    ): WhatsappMessage {
        $type = MessageType::tryFrom($payload['type'] ?? 'text') ?? MessageType::Text;
        $sentAt = isset($payload['timestamp'])
            ? Carbon::createFromTimestamp((int) $payload['timestamp'])
            : now();

        $message = WhatsappMessage::firstOrCreate(
            [
                'device_id' => $device->id,
                'wa_message_id' => $payload['wa_message_id'],
            ],
            [
                'empresa_id' => $conversation->empresa_id,
                'conversation_id' => $conversation->id,
                'contact_id' => $contact->id,
                'sender_type' => MessageSenderType::Contact,
                'type' => $type,
                'body' => $payload['body'] ?? null,
                'media_path' => $payload['media_path'] ?? null,
                'mime_type' => $payload['mime_type'] ?? null,
                'file_name' => $payload['file_name'] ?? null,
                'file_size' => $payload['file_size'] ?? null,
                'status' => MessageStatus::Delivered,
                'is_read' => false,
                'sent_at' => $sentAt,
                'delivered_at' => now(),
            ]
        );

        if (! $message->wasRecentlyCreated) {
            return $message;
        }

        $conversation->forceFill([
            'last_message_id' => $message->id,
            'last_message_at' => $message->sent_at,
            'unread_count' => $conversation->unread_count + 1,
        ])->save();

        return $message;
    }
}
```

> `firstOrCreate` por `(device_id, wa_message_id)` garantiza idempotencia; el `unread_count` solo sube si el mensaje fue creado en esta ejecución (`wasRecentlyCreated`).

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Actions/WhatsFleep/PersistIncomingMessageAction.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Actions/WhatsFleep/PersistIncomingMessageAction.php
git commit -m "feat(wa): PersistIncomingMessageAction (idempotent persist + conversation bump)"
```

---

## Task 17: `SendWhatsappMessageAction` (esqueleto de salida)

**Files:**
- Create: `app/Actions/WhatsFleep/SendWhatsappMessageAction.php`

- [ ] **Step 1: Crear la Action**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\MessageSenderType;
use App\Enums\WhatsFleep\MessageStatus;
use App\Enums\WhatsFleep\MessageType;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Models\WhatsFleep\WhatsappMessage;
use App\Services\WhatsFleep\WhatsappService;
use Throwable;

class SendWhatsappMessageAction
{
    public function __construct(private WhatsappService $whatsapp)
    {
    }

    /**
     * Persiste el mensaje del agente ANTES de enviarlo y delega el envío al
     * WhatsappService existente. El estado evoluciona con los acks vía /status.
     */
    public function execute(WhatsappConversation $conversation, User $sender, string $body): WhatsappMessage
    {
        $message = WhatsappMessage::create([
            'empresa_id' => $conversation->empresa_id,
            'conversation_id' => $conversation->id,
            'device_id' => $conversation->device_id,
            'contact_id' => $conversation->contact_id,
            'sender_type' => MessageSenderType::Agent,
            'sender_user_id' => $sender->id,
            'type' => MessageType::Text,
            'body' => $body,
            'status' => MessageStatus::Pending,
        ]);

        try {
            $device = $conversation->device;
            $number = $conversation->contact->number;
            $response = $this->whatsapp->sendText($device->body, $number, $body);

            $waMessageId = data_get((array) $response, 'key.id')
                ?? data_get((array) $response, 'messageId');

            $message->forceFill([
                'wa_message_id' => $waMessageId,
                'status' => MessageStatus::Sent,
                'sent_at' => now(),
            ])->save();
        } catch (Throwable $e) {
            $message->forceFill([
                'status' => MessageStatus::Failed,
                'metadata' => ['error' => $e->getMessage()],
            ])->save();
        }

        return $message;
    }
}
```

> Reutiliza `App\Services\WhatsFleep\WhatsappService` (enlazado a `Impl` en `AppServiceProvider`). `sendText($token, $number, $message)` ya existe. El parsing de `wa_message_id` se tolera flexible porque la forma exacta de la respuesta del Node puede variar.

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Actions/WhatsFleep/SendWhatsappMessageAction.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Actions/WhatsFleep/SendWhatsappMessageAction.php
git commit -m "feat(wa): SendWhatsappMessageAction (persist-then-send via WhatsappService)"
```

---

## Task 18: Middleware `VerifyInternalToken`

**Files:**
- Create: `app/Http/Middleware/VerifyInternalToken.php`
- Modify: `app/Http/Kernel.php`

- [ ] **Step 1: Crear el middleware**

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyInternalToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = config('whatsapp.internal_token');

        if (empty($expected) || ! hash_equals((string) $expected, (string) $request->header('X-Internal-Token'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
```

- [ ] **Step 2: Registrar el alias en `app/Http/Kernel.php`**

En el array `$routeMiddleware`, después de la línea `'role_or_permission' => ...`, añade:

```php
        // WhatsApp omnicanal
        'whatsapp.internal' => \App\Http\Middleware\VerifyInternalToken::class,
```

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l app/Http/Middleware/VerifyInternalToken.php && php -l app/Http/Kernel.php`
Expected: dos `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Http/Middleware/VerifyInternalToken.php app/Http/Kernel.php
git commit -m "feat(wa): VerifyInternalToken middleware + kernel alias"
```

---

## Task 19: FormRequests de ingesta

**Files:**
- Create: `app/Http/Requests/WhatsFleep/StoreIncomingWhatsappRequest.php`
- Create: `app/Http/Requests/WhatsFleep/UpdateWhatsappStatusRequest.php`

- [ ] **Step 1: `StoreIncomingWhatsappRequest.php`**

```php
<?php

namespace App\Http\Requests\WhatsFleep;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIncomingWhatsappRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'device' => ['required', 'string'],
            'wa_message_id' => ['required', 'string'],
            'from' => ['required', 'string'],
            'wa_jid' => ['nullable', 'string'],
            'push_name' => ['nullable', 'string'],
            'type' => ['required', Rule::in(['text', 'image', 'audio', 'video', 'document', 'location', 'contact', 'sticker'])],
            'body' => ['nullable', 'string'],
            'media_path' => ['nullable', 'string'],
            'mime_type' => ['nullable', 'string'],
            'file_name' => ['nullable', 'string'],
            'file_size' => ['nullable', 'integer'],
            'timestamp' => ['nullable', 'integer'],
            'is_group' => ['nullable', 'boolean'],
        ];
    }
}
```

- [ ] **Step 2: `UpdateWhatsappStatusRequest.php`**

```php
<?php

namespace App\Http\Requests\WhatsFleep;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWhatsappStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'device' => ['required', 'string'],
            'wa_message_id' => ['required', 'string'],
            'status' => ['required', Rule::in(['sent', 'delivered', 'read', 'failed'])],
        ];
    }
}
```

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l app/Http/Requests/WhatsFleep/StoreIncomingWhatsappRequest.php && php -l app/Http/Requests/WhatsFleep/UpdateWhatsappStatusRequest.php`
Expected: dos `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Http/Requests/WhatsFleep/
git commit -m "feat(wa): ingestion form requests (incoming + status)"
```

---

## Task 20: Job `ProcessIncomingWhatsappMessage`

**Files:**
- Create: `app/Jobs/WhatsFleep/ProcessIncomingWhatsappMessage.php`

- [ ] **Step 1: Crear el Job**

```php
<?php

namespace App\Jobs\WhatsFleep;

use App\Actions\WhatsFleep\PersistIncomingMessageAction;
use App\Actions\WhatsFleep\ResolveConversationAction;
use App\Actions\WhatsFleep\ResolveWhatsappContactAction;
use App\Events\WhatsFleep\ConversationUpdated;
use App\Events\WhatsFleep\NewWhatsappMessage;
use App\Models\WhatsFleep\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessIncomingWhatsappMessage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(public array $payload)
    {
        $this->onQueue('whatsapp');
    }

    public function handle(
        ResolveWhatsappContactAction $resolveContact,
        ResolveConversationAction $resolveConversation,
        PersistIncomingMessageAction $persistMessage
    ): void {
        if (! empty($this->payload['is_group'])) {
            return;
        }

        $device = Device::where('body', $this->payload['device'])->first();

        if (! $device) {
            Log::warning('WA ingest: device not found', ['device' => $this->payload['device']]);
            return;
        }

        [$message, $conversation] = DB::transaction(function () use (
            $device,
            $resolveContact,
            $resolveConversation,
            $persistMessage
        ) {
            $resolved = $resolveContact->execute(
                $device,
                $this->payload['from'],
                $this->payload['wa_jid'] ?? null,
                $this->payload['push_name'] ?? null
            );

            $conversation = $resolveConversation->execute(
                $device,
                $resolved['contact'],
                $resolved['empresa_id'],
                $resolved['cliente_id']
            );

            $message = $persistMessage->execute(
                $conversation,
                $device,
                $resolved['contact'],
                $this->payload
            );

            return [$message, $conversation->refresh()];
        });

        broadcast(new NewWhatsappMessage($message));
        broadcast(new ConversationUpdated($conversation));
    }
}
```

> El Job NO toca `session('empresa')`: la empresa se resuelve y se persiste explícita. Idempotente vía `(device_id, wa_message_id)`; reintentos seguros.

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Jobs/WhatsFleep/ProcessIncomingWhatsappMessage.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Jobs/WhatsFleep/ProcessIncomingWhatsappMessage.php
git commit -m "feat(wa): ProcessIncomingWhatsappMessage job (transactional, idempotent, broadcasts)"
```

---

## Task 21: Controller de ingesta

**Files:**
- Create: `app/Http/Controllers/Api/WhatsFleep/IncomingWhatsappController.php`

- [ ] **Step 1: Crear el controller**

```php
<?php

namespace App\Http\Controllers\Api\WhatsFleep;

use App\Enums\WhatsFleep\MessageStatus;
use App\Events\WhatsFleep\ConversationUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsFleep\StoreIncomingWhatsappRequest;
use App\Http\Requests\WhatsFleep\UpdateWhatsappStatusRequest;
use App\Jobs\WhatsFleep\ProcessIncomingWhatsappMessage;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappMessage;
use Illuminate\Http\JsonResponse;

class IncomingWhatsappController extends Controller
{
    public function store(StoreIncomingWhatsappRequest $request): JsonResponse
    {
        ProcessIncomingWhatsappMessage::dispatch($request->validated());

        return response()->json(['accepted' => true], 202);
    }

    public function status(UpdateWhatsappStatusRequest $request): JsonResponse
    {
        $device = Device::where('body', $request->input('device'))->first();

        if (! $device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $message = WhatsappMessage::where('device_id', $device->id)
            ->where('wa_message_id', $request->input('wa_message_id'))
            ->first();

        if (! $message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        $status = MessageStatus::from($request->input('status'));

        $message->status = $status;

        if ($status === MessageStatus::Delivered && $message->delivered_at === null) {
            $message->delivered_at = now();
        }

        if ($status === MessageStatus::Read) {
            $message->read_at = $message->read_at ?? now();
            $message->is_read = true;
        }

        $message->save();

        broadcast(new ConversationUpdated($message->conversation));

        return response()->json(['updated' => true]);
    }
}
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Http/Controllers/Api/WhatsFleep/IncomingWhatsappController.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Http/Controllers/Api/WhatsFleep/IncomingWhatsappController.php
git commit -m "feat(wa): IncomingWhatsappController (store dispatches job, status updates acks)"
```

---

## Task 22: Rutas API

**Files:**
- Modify: `routes/api.php`

- [ ] **Step 1: Añadir el grupo de rutas**

Al final de `routes/api.php`, añade (y asegúrate de que el `use` del controller esté arriba con los demás imports, o usa el FQCN como abajo):

```php
Route::prefix('internal/whatsapp')
    ->middleware('whatsapp.internal')
    ->name('api.internal.whatsapp.')
    ->group(function () {
        Route::post('incoming', [\App\Http\Controllers\Api\WhatsFleep\IncomingWhatsappController::class, 'store'])
            ->name('incoming');
        Route::post('status', [\App\Http\Controllers\Api\WhatsFleep\IncomingWhatsappController::class, 'status'])
            ->name('status');
    });
```

- [ ] **Step 2: Verificar sintaxis y que las rutas se registran**

Run: `php -l routes/api.php`
Expected: `No syntax errors detected`

Run: `php artisan route:list --path=internal/whatsapp`
Expected: aparecen `api.internal.whatsapp.incoming` y `api.internal.whatsapp.status`

- [ ] **Step 3: Commit**

```bash
git add routes/api.php
git commit -m "feat(wa): internal ingestion routes (incoming + status)"
```

---

## Task 23: Correr migraciones y enlazar storage

**Files:** _(ninguno; operaciones de entorno)_

> Estas operaciones son seguras: `migrate` es aditivo, `storage:link` crea un symlink. NO ejecutar `migrate:fresh` ni el suite de tests.

- [ ] **Step 1: Correr las migraciones nuevas**

Run: `php artisan migrate`
Expected: corren las 6 migraciones nuevas (`add_whatsapp_fields_to_contacts_table` ... `create_whatsapp_conversation_tag_table`) con `DONE`.

- [ ] **Step 2: Asegurar el symlink de storage (para servir media)**

Run: `php artisan storage:link`
Expected: el enlace `public/storage` existe (o "already exists").

- [ ] **Step 3: Crear la carpeta de media**

Run: `mkdir -p storage/app/public/whatsapp`
Expected: la carpeta existe.

- [ ] **Step 4: Commit (gitkeep para versionar la carpeta vacía)**

```bash
printf '' > storage/app/public/whatsapp/.gitkeep
git add storage/app/public/whatsapp/.gitkeep
git commit -m "chore(wa): ensure whatsapp media directory exists"
```

---

## Task 24: Node — persistir entrantes desde `incomingMessage.js`

**Files:**
- Modify: `server/controllers/incomingMessage.js`

> Objetivo: tras el flujo actual de autoreply/webhook, **siempre** descargar media (si la hay) y hacer `POST` al endpoint interno de Laravel. No se elimina nada del comportamiento existente.

- [ ] **Step 1: Añadir imports y helpers al inicio del archivo**

Debajo de los imports existentes (después de `import logger from "../lib/pino.js";`), añade:

```js
import { downloadMediaMessage } from "baileys";
import { writeFile, mkdir } from "fs/promises";
import path from "path";

const LARAVEL_URL = process.env.LARAVEL_URL || "http://localhost";
const INTERNAL_TOKEN = process.env.INTERNAL_TOKEN || "";
const MEDIA_ROOT = process.env.WA_MEDIA_ROOT || "./storage/app/public/whatsapp";

const MEDIA_EXT = {
    image: "jpg",
    video: "mp4",
    audio: "ogg",
    document: "bin",
    sticker: "webp",
};

function mapMessageType(messageType) {
    const map = {
        conversation: "text",
        extendedTextMessage: "text",
        imageMessage: "image",
        videoMessage: "video",
        audioMessage: "audio",
        documentMessage: "document",
        stickerMessage: "sticker",
        locationMessage: "location",
        contactMessage: "contact",
    };
    return map[messageType] || "text";
}
```

- [ ] **Step 2: Añadir la función de descarga de media y de POST al final del archivo (antes de cierre, fuera de `IncomingMessage`)**

```js
/**
 * Descarga el media del mensaje y lo guarda en el disco compartido de Laravel.
 * Devuelve metadatos o null si no hay media.
 */
async function storeIncomingMedia(message, deviceToken, waMessageId, type) {
    const mediaTypes = ["image", "video", "audio", "document", "sticker"];
    if (!mediaTypes.includes(type)) return null;

    try {
        const buffer = await downloadMediaMessage(message, "buffer", {});
        const ext = MEDIA_EXT[type] || "bin";
        const safeId = String(waMessageId).replace(/[^a-zA-Z0-9_-]/g, "_");
        const dir = path.join(MEDIA_ROOT, deviceToken);
        await mkdir(dir, { recursive: true });

        const fileName = `${safeId}.${ext}`;
        const fullPath = path.join(dir, fileName);
        await writeFile(fullPath, buffer);

        const content = message.message || {};
        const node =
            content.imageMessage ||
            content.videoMessage ||
            content.audioMessage ||
            content.documentMessage ||
            content.stickerMessage ||
            {};

        return {
            media_path: `whatsapp/${deviceToken}/${fileName}`,
            mime_type: node.mimetype || null,
            file_name: node.fileName || fileName,
            file_size: buffer.length,
        };
    } catch (error) {
        logger.error("Error descargando media WA:", error.message);
        return null;
    }
}

/**
 * Persiste el mensaje entrante en Laravel (endpoint interno).
 */
async function persistIncomingToLaravel(payload) {
    try {
        await axios.post(`${LARAVEL_URL}/api/internal/whatsapp/incoming`, payload, {
            timeout: 10000,
            headers: {
                "Content-Type": "application/json",
                "X-Internal-Token": INTERNAL_TOKEN,
            },
        });
    } catch (error) {
        logger.error(
            "Error persistiendo mensaje en Laravel:",
            error?.response?.status || error.message,
        );
    }
}
```

- [ ] **Step 3: Llamar a la persistencia dentro de `IncomingMessage`, justo antes del bloque `if (!responseFound && device.webhook)`**

Inserta este bloque (después del `for (const autoreply ...)` y antes del webhook):

```js
        // === Persistencia omnicanal (siempre, independiente de autoreply/webhook) ===
        const waMessageId = message.key.id;
        const normalizedType = mapMessageType(messageType);
        const mediaMeta = await storeIncomingMedia(
            message,
            deviceNumber,
            waMessageId,
            normalizedType,
        );

        await persistIncomingToLaravel({
            device: deviceNumber,
            wa_message_id: waMessageId,
            from: cleanFromNumber,
            wa_jid: remoteJid,
            push_name: senderName || null,
            type: normalizedType,
            body: fullBody || messageText || null,
            timestamp: Math.floor(Date.now() / 1000),
            is_group: isGroupMessage,
            ...(mediaMeta || {}),
        });
```

- [ ] **Step 4: Verificar sintaxis JS**

Run: `node --check server/controllers/incomingMessage.js`
Expected: sin salida (exit 0)

- [ ] **Step 5: Añadir variables al `.env` del proyecto (Node lee el mismo `.env`)**

Confirma/añade en `.env`:
```
LARAVEL_URL=http://talentus.test
INTERNAL_TOKEN=<mismo valor que WHATSAPP_INTERNAL_TOKEN>
WA_MEDIA_ROOT=./storage/app/public/whatsapp
```

- [ ] **Step 6: Commit**

```bash
git add server/controllers/incomingMessage.js
git commit -m "feat(wa): node persists incoming messages + media to Laravel internal endpoint"
```

---

## Task 25: Node — reportar acks de estado desde `whatsapp.js`

**Files:**
- Modify: `server/whatsapp.js`

> El handler `messages.update` actualmente solo hace `logger.debug`. Le añadimos el POST a `/status`.

- [ ] **Step 1: Añadir un helper de POST de estado cerca de los imports/utilidades de `server/whatsapp.js`**

Después de la línea `import logger from "./lib/pino.js";`, añade:

```js
import axios from "axios";

const LARAVEL_URL = process.env.LARAVEL_URL || "http://localhost";
const INTERNAL_TOKEN = process.env.INTERNAL_TOKEN || "";

const WA_STATUS_MAP = {
    1: "sent",       // PENDING/SERVER_ACK
    2: "delivered",  // DELIVERY_ACK
    3: "read",       // READ
    4: "read",       // PLAYED
};

async function reportStatusToLaravel(deviceToken, waMessageId, statusCode) {
    const status = WA_STATUS_MAP[statusCode];
    if (!status || !waMessageId) return;

    try {
        await axios.post(
            `${LARAVEL_URL}/api/internal/whatsapp/status`,
            { device: deviceToken, wa_message_id: waMessageId, status },
            {
                timeout: 8000,
                headers: {
                    "Content-Type": "application/json",
                    "X-Internal-Token": INTERNAL_TOKEN,
                },
            },
        );
    } catch (error) {
        logger.error(
            "Error reportando estado a Laravel:",
            error?.response?.status || error.message,
        );
    }
}
```

> Si `axios` ya estuviera importado en este archivo, no lo dupliques (revisa los imports actuales; hoy `whatsapp.js` no lo importa).

- [ ] **Step 2: Llamar al reporte dentro del handler `messages.update`**

Reemplaza el bloque actual:

```js
        sock.ev.on("messages.update", (updates) => {
            for (const update of updates) {
                if (update.update.status) {
                    logger.debug(
                        `Mensaje ${update.key.id} → estado ${update.update.status}`,
                    );
                }
            }
        });
```

por:

```js
        sock.ev.on("messages.update", (updates) => {
            for (const update of updates) {
                if (update.update.status) {
                    logger.debug(
                        `Mensaje ${update.key.id} → estado ${update.update.status}`,
                    );
                    if (update.key?.fromMe) {
                        reportStatusToLaravel(
                            token,
                            update.key.id,
                            update.update.status,
                        );
                    }
                }
            }
        });
```

> Solo se reportan acks de mensajes salientes (`fromMe`), que son los que tenemos persistidos con `wa_message_id`.

- [ ] **Step 3: Verificar sintaxis JS**

Run: `node --check server/whatsapp.js`
Expected: sin salida (exit 0)

- [ ] **Step 4: Commit**

```bash
git add server/whatsapp.js
git commit -m "feat(wa): node reports outgoing message acks to Laravel /status"
```

---

## Task 26: Verificación de integración (smoke manual, sin tests del suite)

**Files:** _(ninguno)_

> Verificación de extremo a extremo sin `php artisan test`. Requiere: worker de cola corriendo y servidor Node activo.

- [ ] **Step 1: Levantar el worker de la cola whatsapp**

Run (en una terminal aparte): `php artisan queue:work --queue=whatsapp --tries=3`
Expected: el worker queda escuchando.

- [ ] **Step 2: Simular un POST de ingesta (con el token configurado)**

Run:
```bash
curl -s -X POST http://talentus.test/api/internal/whatsapp/incoming \
  -H "Content-Type: application/json" \
  -H "X-Internal-Token: <WHATSAPP_INTERNAL_TOKEN>" \
  -d '{"device":"<device_body_existente>","wa_message_id":"SMOKE-1","from":"51987654321","type":"text","body":"hola","timestamp":1718400000,"is_group":false}'
```
Expected: HTTP `202` `{"accepted":true}`. En el worker, el Job procesa sin error.

- [ ] **Step 3: Verificar persistencia (solo lectura)**

Run: `php artisan tinker --execute="echo App\Models\WhatsFleep\WhatsappMessage::where('wa_message_id','SMOKE-1')->count();"`
Expected: `1`

- [ ] **Step 4: Verificar idempotencia (repetir el mismo POST)**

Repite el `curl` del Step 2 con el mismo `wa_message_id`.
Run: `php artisan tinker --execute="echo App\Models\WhatsFleep\WhatsappMessage::where('wa_message_id','SMOKE-1')->count();"`
Expected: sigue `1` (no se duplica); `unread_count` de la conversación no subió por segunda vez.

- [ ] **Step 5: Limpiar el registro de smoke (opcional)**

Run: `php artisan tinker --execute="App\Models\WhatsFleep\WhatsappMessage::where('wa_message_id','SMOKE-1')->delete();"`
Expected: sin error.

- [ ] **Step 6: Sin commit** (esta tarea no produce archivos)

---

## Self-Review (completado al escribir el plan)

- **Cobertura del spec:** D1 ingesta (T18–T22, T24), D2 threading (T15), D3 cliente match (T14), D4 contacts unificado (T3, T9), D5 media (T24), D6 multi-tenancy del Job (T20). Modelo de datos §4 (T3–T7). Modelos/enums §5 (T8–T12). Ingesta §6 (T18–T22). Reverb emisión §7 (T13, usados en T20/T21). Cambios Node §8 (T24–T25). Config §9 (T1, T23). Idempotencia/concurrencia §10 (T5 unique, T15 lockForUpdate, T16 firstOrCreate, T20 tries/backoff). Criterios §14 (T26 smoke).
- **Placeholders:** ninguno; todo el código está completo.
- **Consistencia de tipos:** `ResolveWhatsappContactAction::execute` retorna `['contact','empresa_id','cliente_id']` y así lo consume el Job (T20). `ResolveConversationAction::execute(device, contact, empresaId, clienteId)` y `PersistIncomingMessageAction::execute(conversation, device, contact, payload)` coinciden con sus llamadas. Enums usados por `value` en eventos coinciden con los definidos en T8.
- **Fuera de alcance:** Policies (SP#3), UI/canales auth (SP#2), tickets/GPS (SP#4), automatización (SP#5) — no incluidos, según spec §11.
