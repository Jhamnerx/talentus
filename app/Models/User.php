<?php

namespace App\Models;

use App\Http\Livewire\Admin\Vehiculos\Reportes\Recordatorio;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

//Spatie Permisos
use Spatie\Permission\Traits\HasRoles;

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
        'password',
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
}
