<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Observers\UserObserver;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

//Spatie Permisos
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Livewire\Admin\Vehiculos\Reportes\Recordatorio;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'tipo_documento',
        'numero_documento',
        'telefonos',
        'password',
        'series_id',
    ];

    // protected $attributes = [
    //     'delayed' => false,
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function scopeExcludeEmail($query, $email)
    {
        return $query->where('email', '!=', $email);
    }

    public function cambios()
    {

        return $this->hasMany(CambiosLineas::class);
    }

    public function reportes()
    {

        return $this->hasMany(Reportes::class);
    }


    public function reportes_detalle()
    {

        return $this->hasMany(DetalleReportes::class);
    }

    public function recordatorio()
    {

        return $this->hasMany(Recordatorio::class, 'user_id');
    }

    public function payments()
    {

        return $this->hasMany(Payments::class, 'user_id');
    }

    public function dispositivos(): BelongsToMany
    {
        return $this->belongsToMany(Dispositivos::class, 'dispositivos_users', 'tecnico_id', 'imei', 'id', 'imei')->using(DispositivosUsers::class)
            ->withPivot('user_id', 'guia_remision_id ', 'created_at')->withTimestamps();
    }

    public function sim_cards(): BelongsToMany
    {
        return $this->belongsToMany(SimCard::class, 'sim_card_users', 'tecnico_id', 'sim_card', 'id', 'sim_card')->using(SimCardUsers::class)
            ->withPivot('user_id', 'guia_remision_id ', 'created_at')->withTimestamps();
    }
    //relacion uno a muchos

    public function guia()
    {
        return $this->hasMany(GuiaRemision::class, 'users_id');
    }

    public function tareas()
    {
        return $this->hasMany(Tareas::class, 'user_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function series()
    {
        return $this->hasOne(Series::class, 'id', 'series_id');
    }
}
