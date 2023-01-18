<?php

namespace App\Models\Admin;

use App\Models\User;
use App\Models\Reportes;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recordatorios extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    //Relacion uno a muchos inversa

    public function reporte()
    {
        return $this->belongsTo(Reportes::class, 'reportes_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
