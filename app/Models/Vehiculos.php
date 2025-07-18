<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use App\Observers\VehiculosObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(VehiculosObserver::class)]
class Vehiculos extends Model
{
    use HasFactory;
    use SoftDeletes;
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
    protected $table = 'vehiculos';
    protected $primaryKey = 'id';

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    protected function placa(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value),
            set: fn($value) => strtoupper($value),
        );
    }
    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }

    public function scopeWhereCompany($query)
    {
        return $query->where('vehiculos.empresa_id', session('empresa'));
    }

    // Scope local de activo
    public function order($query, $order)
    {
        return $query->orderBy($order, 'desc');
    }

    //Relacion uno a muchos inversa
    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion uno a muchos a modelos
    public function sim_card()
    {
        return $this->belongsTo(SimCard::class, 'sim_card_id');
    }

    //relacion uno a muchos a reportes
    public function reportes()
    {
        return $this->hasMany(Reportes::class, 'vehiculos_id');
    }

    //relacion uno a muchos a actas
    public function actas()
    {
        return $this->hasMany(Actas::class, 'vehiculos_id');
    }

    //relacion uno a muchos a actas
    public function certificados()
    {
        return $this->hasMany(Certificados::class, 'vehiculos_id');
    }

    //relacion uno a muchos a actas
    public function cert_velocimetros()
    {
        return $this->hasMany(CertificadosVelocimetros::class, 'vehiculos_id');
    }

    //Relacion muchos a ,muchos
    public function detalle_contrato()
    {
        return $this->hasMany(DetalleContratos::class, 'vehiculos_id')->withTrashed();
    }


    //Relacion muchos a ,muchos
    public function contratos()
    {
        return $this->belongsToMany(Contratos::class, 'detalle_contratos', 'vehiculos_id', 'contratos_id')->withTrashed();
    }

    //relacion uno a muchos
    public function cobros()
    {
        return $this->hasMany(Cobros::class, 'vehiculos_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function flotas()
    {
        return $this->belongsToMany(Flotas::class, 'vehiculos_flotas', 'vehiculos_id', 'flotas_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function tareas()
    {

        return $this->hasMany(Tareas::class, 'vehiculo_id')->withoutGlobalScope(EmpresaScope::class);
    }


    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'vehiculo_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function numero()
    {
        return $this->hasOne(Lineas::class, 'numero', 'numero')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function detalleCobro()
    {
        return $this->belongsTo(DetalleCobros::class, 'vehiculo_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function dispositivos()
    {
        // Relación 1:N con todos los dispositivos instalados (histórico)
        return $this->hasMany(\App\Models\VehiculoDispositivos::class, 'vehiculo_id');
    }

    public function dispositivoPrincipal()
    {
        // Relación 1:1 con el dispositivo principal (el más reciente sin fecha de desinstalación)
        return $this->hasOne(\App\Models\VehiculoDispositivos::class, 'vehiculo_id')
            ->whereNull('fecha_desinstalacion')
            ->where('is_principal', true)
            ->latestOfMany('fecha_instalacion');
    }

    /**
     * Sincroniza los dispositivos asociados al vehículo
     * 
     * @param array $dispositivos Lista de dispositivos a sincronizar [['imei' => '...', 'id' => '...'], ...]
     * @param int|null $dispositivo_principal Índice del dispositivo principal en el array
     * @return array [bool $success, string $mensaje]
     */
    public function sincronizarDispositivos(array $dispositivos, $dispositivo_principal = null)
    {
        try {
            // Obtener los dispositivos actualmente asociados
            $dispositivos_actuales = $this->dispositivos()
                ->whereNull('fecha_desinstalacion')
                ->get()
                ->keyBy('dispositivo_id');

            // Array para llevar registro de los dispositivos que permanecen
            $dispositivos_que_permanecen = [];

            // Si no hay dispositivos nuevos, marcar todos como desinstalados
            if (empty($dispositivos)) {
                // Limpiar los campos del vehículo
                $this->update([
                    'dispositivo_imei' => null,
                    'dispositivos_id' => null
                ]);

                // Marcar todos como desinstalados
                if ($dispositivos_actuales->count() > 0) {
                    $this->dispositivos()
                        ->whereNull('fecha_desinstalacion')
                        ->update(['fecha_desinstalacion' => now(), 'is_principal' => false]);
                }

                return [true, 'Todos los dispositivos han sido desinstalados'];
            }

            // Crear un dispositivo principal por defecto si no existe
            if ($dispositivo_principal === null && count($dispositivos) > 0) {
                $dispositivo_principal = 0;
            }

            // Procesar cada dispositivo de la lista
            foreach ($dispositivos as $index => $dispositivo) {
                $es_principal = $dispositivo_principal == $index;

                // Buscar el modelo del dispositivo
                $modeloDispositivo = Dispositivos::where('imei', $dispositivo['imei'])->first();
                if (!$modeloDispositivo) continue;

                // Verificar si es un dispositivo nuevo
                if (!$dispositivos_actuales->has($modeloDispositivo->id)) {
                    // Verificar disponibilidad solo para dispositivos nuevos
                    [$disponible, $vehiculoAsignado, $mensaje] = $modeloDispositivo->verificarDisponibilidad($this->id);

                    if (!$disponible) {
                        continue;
                    }

                    // Cambiar estado y crear nuevo registro
                    $modeloDispositivo->estado = Dispositivos::VENDIDO;
                    $modeloDispositivo->save();

                    VehiculoDispositivos::create([
                        'vehiculo_id' => $this->id,
                        'imei' => $dispositivo['imei'],
                        'dispositivo_id' => $modeloDispositivo->id,
                        'fecha_instalacion' => now(),
                        'is_principal' => $es_principal
                    ]);
                } else {
                    // Si ya existía, actualizar solo si cambió la condición de principal
                    $dispositivo_actual = $dispositivos_actuales[$modeloDispositivo->id];

                    if ($dispositivo_actual->is_principal != $es_principal) {
                        $dispositivo_actual->is_principal = $es_principal;
                        $dispositivo_actual->save();
                    }
                }

                // Marcar este dispositivo para que no sea desinstalado
                $dispositivos_que_permanecen[] = $modeloDispositivo->id;

                // Si es principal, actualizar los campos directos
                if ($es_principal) {
                    $this->update([
                        'dispositivo_imei' => $dispositivo['imei'],
                        'dispositivos_id' => $modeloDispositivo->id
                    ]);
                }
            }

            // Marcar como desinstalados solo los que no están en la nueva lista
            foreach ($dispositivos_actuales as $dispositivo_actual) {
                if (!in_array($dispositivo_actual->dispositivo_id, $dispositivos_que_permanecen)) {
                    $dispositivo_actual->fecha_desinstalacion = now();
                    $dispositivo_actual->is_principal = false;
                    $dispositivo_actual->save();
                }
            }

            return [true, 'Dispositivos sincronizados correctamente'];
        } catch (\Exception $e) {
            return [false, 'Error al sincronizar dispositivos: ' . $e->getMessage()];
        }
    }

    /**
     * Relación directa a los dispositivos (a través de la tabla pivot)
     * Esta relación permite acceder directamente a los modelos Dispositivo
     */
    public function dispositivosAsignados()
    {
        return $this->belongsToMany(Dispositivos::class, 'vehiculos_dispositivos', 'vehiculo_id', 'dispositivo_id')
            ->whereNull('vehiculos_dispositivos.fecha_desinstalacion')
            ->withPivot('is_principal', 'fecha_instalacion')
            ->withTimestamps();
    }
}
