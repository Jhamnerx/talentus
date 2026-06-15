<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Notifications\Portal\ResetPortalPasswordNotification;
use App\Notifications\Portal\VerifyPortalEmailNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ClienteUser extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\ClienteUserFactory> */
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $table = 'cliente_users';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'cliente_id',
        'name',
        'email',
        'password',
        'rol',
        'estado',
        'telefono',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')
            ->withTrashed()
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function estaAprobado(): bool
    {
        return $this->estado === 'aprobado' && $this->email_verified_at !== null;
    }

    public function esTitular(): bool
    {
        return $this->rol === 'titular';
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyPortalEmailNotification());
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPortalPasswordNotification($token));
    }
}
