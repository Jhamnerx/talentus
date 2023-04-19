<?php

namespace App\Models;

use App\Models\Clientes;
use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\ContactosFlotasFactory;
use App\Notifications\Birthday\NotifyContactBirthday;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contactos extends Model
{

    protected static function newFactory()
    {
        return ContactosFlotasFactory::new();
    }

    use HasFactory, SoftDeletes, Notifiable;
    use LogsActivity;
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'contactos';


    protected $casts = [
        'is_gerente' => 'boolean',

    ];

    // Scope local de activo
    public function scopeGerente($query, $value)
    {
        return $query->where('is_gerente', $value);
    }

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id');
    }

    public function notifyContactBirthday()
    {

        // $pdf = PDF::loadView('pdf.birthday.pdf');
        // return $pdf->stream('pdf.pdf');
        //$user = User::where('email', 'monitoreo@talentustechnology.com')->first();

        $this->notify(new NotifyContactBirthday($this));
    }
}
