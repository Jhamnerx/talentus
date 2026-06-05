<?php

namespace Database\Seeders;

use App\Models\Kpi;
use App\Models\Wig;
use Illuminate\Database\Seeder;

class KpiSeeder extends Seeder
{
    public function run(): void
    {
        $empresas = \App\Models\Empresa::all();

        foreach ($empresas as $empresa) {
            $this->seedEmpresa($empresa->id);
        }

        if (isset($this->command)) {
            $this->command->info("KPIs, WIGs y equipos creados para {$empresas->count()} empresa(s).");
        }
    }

    private function seedEmpresa(int $empresaId): void
    {        // =============================================
        // KPIs POR AREA
        // =============================================

        $kpis = [

            // ----- COMERCIAL -----
            [
                'area'        => 'comercial',
                'nombre'      => 'Propuestas nuevas registradas',
                'slug'        => 'propuestas_registradas',
                'descripcion' => 'Cantidad de presupuestos/cotizaciones creados en el periodo por el equipo comercial.',
                'tipo'        => 'auto',
                'meta'        => 10,
                'meta_minima' => 8,
                'unidad'      => 'und',
                'frecuencia'  => 'semanal',
                'responsable' => 'Jefe Comercial',
                'formula'     => 'propuestas_registradas',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 1,
            ],
            [
                'area'        => 'comercial',
                'nombre'      => 'Propuestas enviadas al cliente',
                'slug'        => 'propuestas_enviadas',
                'descripcion' => 'Presupuestos marcados como enviados al cliente en el periodo.',
                'tipo'        => 'auto',
                'meta'        => 8,
                'meta_minima' => 6,
                'unidad'      => 'und',
                'frecuencia'  => 'semanal',
                'responsable' => 'Jefe Comercial',
                'formula'     => 'propuestas_enviadas',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 2,
            ],
            [
                'area'        => 'comercial',
                'nombre'      => 'Ventas cerradas',
                'slug'        => 'ventas_cerradas',
                'descripcion' => 'Presupuestos convertidos a recibo o CPE (boleta/factura) en el periodo.',
                'tipo'        => 'auto',
                'meta'        => 5,
                'meta_minima' => 4,
                'unidad'      => 'und',
                'frecuencia'  => 'semanal',
                'responsable' => 'Jefe Comercial',
                'formula'     => 'ventas_cerradas',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 3,
            ],
            [
                'area'        => 'comercial',
                'nombre'      => 'OT completas al primer envio',
                'slug'        => 'ot_completas_primer_envio_pct',
                'descripcion' => '% de presupuestos convertidos con OT asociada finalizada sin retrabajo.',
                'tipo'        => 'auto',
                'meta'        => 90,
                'meta_minima' => 75,
                'unidad'      => '%',
                'frecuencia'  => 'semanal',
                'responsable' => 'Jefe Comercial',
                'formula'     => 'ot_completas_primer_envio_pct',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 4,
            ],
            [
                'area'        => 'comercial',
                'nombre'      => 'Ventas con adelanto validado',
                'slug'        => 'ventas_con_adelanto_pct',
                'descripcion' => '% de ventas cerradas que registraron adelanto de pago.',
                'tipo'        => 'auto',
                'meta'        => 80,
                'meta_minima' => 60,
                'unidad'      => '%',
                'frecuencia'  => 'semanal',
                'responsable' => 'Jefe Comercial',
                'formula'     => 'ventas_con_adelanto_pct',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 5,
            ],

            // ----- OPERACIONES -----
            [
                'area'        => 'operaciones',
                'nombre'      => 'Instalaciones realizadas',
                'slug'        => 'instalaciones_realizadas',
                'descripcion' => 'Ordenes de trabajo de tipo instalacion finalizadas en el periodo.',
                'tipo'        => 'auto',
                'meta'        => 8,
                'meta_minima' => 6,
                'unidad'      => 'und',
                'frecuencia'  => 'semanal',
                'responsable' => 'Jefe de Operaciones',
                'formula'     => 'instalaciones_realizadas',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 1,
            ],
            [
                'area'        => 'operaciones',
                'nombre'      => 'Instalaciones a tiempo',
                'slug'        => 'instalaciones_a_tiempo_pct',
                'descripcion' => '% de instalaciones finalizadas el mismo dia de la fecha programada.',
                'tipo'        => 'auto',
                'meta'        => 90,
                'meta_minima' => 75,
                'unidad'      => '%',
                'frecuencia'  => 'semanal',
                'responsable' => 'Jefe de Operaciones',
                'formula'     => 'instalaciones_a_tiempo_pct',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 2,
            ],
            [
                'area'        => 'operaciones',
                'nombre'      => 'Instalaciones sin retrabajo',
                'slug'        => 'instalaciones_sin_retrabajo_pct',
                'descripcion' => '% de instalaciones que no generaron OT de mantenimiento/revision en 30 dias.',
                'tipo'        => 'auto',
                'meta'        => 97,
                'meta_minima' => 90,
                'unidad'      => '%',
                'frecuencia'  => 'semanal',
                'responsable' => 'Jefe de Operaciones',
                'formula'     => 'instalaciones_sin_retrabajo_pct',
                'activo'      => true,
                'es_wig'      => true,
                'orden'       => 3,
            ],
            [
                'area'        => 'operaciones',
                'nombre'      => 'Unidades activas dentro del plazo',
                'slug'        => 'unidades_activas_plazo_pct',
                'descripcion' => '% de cobros activos con fecha de vencimiento vigente (no vencidos).',
                'tipo'        => 'auto',
                'meta'        => 100,
                'meta_minima' => 90,
                'unidad'      => '%',
                'frecuencia'  => 'semanal',
                'responsable' => 'Jefe de Operaciones',
                'formula'     => 'unidades_activas_plazo_pct',
                'activo'      => true,
                'es_wig'      => true,
                'orden'       => 4,
            ],

            // ----- ADMINISTRACION -----
            [
                'area'        => 'administracion',
                'nombre'      => 'Expedientes completos',
                'slug'        => 'expedientes_completos_pct',
                'descripcion' => '% de clientes activos con al menos un contrato registrado.',
                'tipo'        => 'auto',
                'meta'        => 100,
                'meta_minima' => 85,
                'unidad'      => '%',
                'frecuencia'  => 'mensual',
                'responsable' => 'Jefa Administrativa',
                'formula'     => 'expedientes_completos_pct',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 1,
            ],
            [
                'area'        => 'administracion',
                'nombre'      => 'Comprobantes emitidos dentro de 24h',
                'slug'        => 'comprobantes_24h_pct',
                'descripcion' => '% de OTs finalizadas con presupuesto cuyo comprobante se emitio en 24h.',
                'tipo'        => 'auto',
                'meta'        => 95,
                'meta_minima' => 80,
                'unidad'      => '%',
                'frecuencia'  => 'semanal',
                'responsable' => 'Jefa Administrativa',
                'formula'     => 'comprobantes_24h_pct',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 2,
            ],
            [
                'area'        => 'administracion',
                'nombre'      => 'Cobranza al dia',
                'slug'        => 'cobranza_al_dia_pct',
                'descripcion' => '% de cobros activos con fecha de vencimiento vigente (cobranza no vencida).',
                'tipo'        => 'auto',
                'meta'        => 95,
                'meta_minima' => 80,
                'unidad'      => '%',
                'frecuencia'  => 'mensual',
                'responsable' => 'Jefa Administrativa',
                'formula'     => 'cobranza_al_dia_pct',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 3,
            ],

            // ----- POST VENTA -----
            [
                'area'        => 'postventa',
                'nombre'      => 'Reclamos criticos atendidos en < 2h',
                'slug'        => 'reclamos_atendidos_2h_pct',
                'descripcion' => '% de tickets HIGH/URGENT con primera respuesta dentro de 2 horas.',
                'tipo'        => 'auto',
                'meta'        => 90,
                'meta_minima' => 70,
                'unidad'      => '%',
                'frecuencia'  => 'semanal',
                'responsable' => 'Coordinador Post Venta',
                'formula'     => 'reclamos_atendidos_2h_pct',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 1,
            ],
            [
                'area'        => 'postventa',
                'nombre'      => 'Reclamos criticos sin resolver > 24h',
                'slug'        => 'reclamos_criticos_sin_resolver_24h',
                'descripcion' => 'Conteo de tickets HIGH/URGENT sin resolver pasadas 24h (meta = 0).',
                'tipo'        => 'auto',
                'meta'        => 0,
                'meta_minima' => 0,
                'unidad'      => 'und',
                'frecuencia'  => 'diario',
                'responsable' => 'Coordinador Post Venta',
                'formula'     => 'reclamos_criticos_sin_resolver_24h',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 2,
            ],
            [
                'area'        => 'postventa',
                'nombre'      => 'Satisfaccion de visitas tecnicas',
                'slug'        => 'visitas_tecnicas_satisfaccion',
                'descripcion' => 'Calificacion promedio de visitas tecnicas por el cliente (escala 1-5).',
                'tipo'        => 'auto',
                'meta'        => 4.5,
                'meta_minima' => 3.5,
                'unidad'      => '/ 5',
                'frecuencia'  => 'semanal',
                'responsable' => 'Coordinador Post Venta',
                'formula'     => 'visitas_tecnicas_satisfaccion',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 3,
            ],

            // ----- MONITOREO GPS -----
            [
                'area'        => 'monitoreo',
                'nombre'      => 'Unidades inactivas con ticket abierto',
                'slug'        => 'unidades_inactivas_con_ticket_pct',
                'descripcion' => '% de unidades GPS criticas (>24h sin transmitir) con ticket abierto el mismo dia.',
                'tipo'        => 'auto',
                'meta'        => 100,
                'meta_minima' => 80,
                'unidad'      => '%',
                'frecuencia'  => 'diario',
                'responsable' => 'Supervisor Monitoreo',
                'formula'     => 'unidades_inactivas_con_ticket_pct',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 1,
            ],
            [
                'area'        => 'monitoreo',
                'nombre'      => 'Tickets de fallas resueltos en SLA',
                'slug'        => 'tickets_fallas_sla_pct',
                'descripcion' => '% de tickets resueltos antes del plazo SLA (due_at).',
                'tipo'        => 'auto',
                'meta'        => 90,
                'meta_minima' => 75,
                'unidad'      => '%',
                'frecuencia'  => 'semanal',
                'responsable' => 'Supervisor Monitoreo',
                'formula'     => 'tickets_fallas_sla_pct',
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 2,
            ],

            // ----- GERENCIA -----
            [
                'area'        => 'gerencia',
                'nombre'      => 'Cumplimiento global de KPIs',
                'slug'        => 'cumplimiento_global',
                'descripcion' => 'Porcentaje promedio de cumplimiento de todos los KPIs de la empresa.',
                'tipo'        => 'manual',
                'meta'        => 90,
                'meta_minima' => 75,
                'unidad'      => '%',
                'frecuencia'  => 'semanal',
                'responsable' => 'Gerente General',
                'formula'     => null,
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 1,
            ],
            [
                'area'        => 'gerencia',
                'nombre'      => 'Rentabilidad del periodo',
                'slug'        => 'rentabilidad_periodo',
                'descripcion' => 'Margen de rentabilidad neta del periodo (manual).',
                'tipo'        => 'manual',
                'meta'        => 20,
                'meta_minima' => 10,
                'unidad'      => '%',
                'frecuencia'  => 'mensual',
                'responsable' => 'Gerente General',
                'formula'     => null,
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 2,
            ],
            [
                'area'        => 'gerencia',
                'nombre'      => 'NPS — Satisfaccion del cliente',
                'slug'        => 'nps_satisfaccion',
                'descripcion' => 'Net Promoter Score consolidado del periodo (manual).',
                'tipo'        => 'manual',
                'meta'        => 70,
                'meta_minima' => 50,
                'unidad'      => 'pts',
                'frecuencia'  => 'mensual',
                'responsable' => 'Gerente General',
                'formula'     => null,
                'activo'      => true,
                'es_wig'      => false,
                'orden'       => 3,
            ],
        ];

        foreach ($kpis as $data) {
            Kpi::updateOrCreate(
                ['empresa_id' => $empresaId, 'slug' => $data['slug']],
                array_merge($data, ['empresa_id' => $empresaId])
            );
        }

        // =============================================
        // WIGs
        // =============================================

        $wigs = [
            [
                'titulo'      => 'Instalaciones sin retrabajo',
                'descripcion' => 'Al menos el 97% de instalaciones deben completarse sin necesitar retrabajo en 30 dias.',
                'meta'        => 97,
                'valor_actual' => 0,
                'unidad'      => '%',
                'responsable' => 'Jefe de Operaciones',
                'fecha_inicio' => now()->startOfYear()->toDateString(),
                'fecha_fin'   => now()->endOfYear()->toDateString(),
                'formula'     => 'wig_instalaciones_sin_retrabajo',
                'tipo'        => 'auto',
                'estado'      => 'activo',
                'orden'       => 1,
            ],
            [
                'titulo'      => 'Unidades activas dentro del plazo',
                'descripcion' => '100% de unidades GPS con cobro vigente sin vencer.',
                'meta'        => 100,
                'valor_actual' => 0,
                'unidad'      => '%',
                'responsable' => 'Jefe de Operaciones',
                'fecha_inicio' => now()->startOfYear()->toDateString(),
                'fecha_fin'   => now()->endOfYear()->toDateString(),
                'formula'     => 'wig_unidades_activas_plazo',
                'tipo'        => 'auto',
                'estado'      => 'activo',
                'orden'       => 2,
            ],
            [
                'titulo'      => 'Clientes en plataforma GPS',
                'descripcion' => '100% de clientes con cobro activo y servicio GPS vigente.',
                'meta'        => 100,
                'valor_actual' => 0,
                'unidad'      => '%',
                'responsable' => 'Gerente General',
                'fecha_inicio' => now()->startOfYear()->toDateString(),
                'fecha_fin'   => now()->endOfYear()->toDateString(),
                'formula'     => 'wig_clientes_plataforma_7dias',
                'tipo'        => 'auto',
                'estado'      => 'activo',
                'orden'       => 3,
            ],
            [
                'titulo'      => 'Renovacion de contratos',
                'descripcion' => 'Al menos el 80% de clientes activos con contrato vigente registrado.',
                'meta'        => 80,
                'valor_actual' => 0,
                'unidad'      => '%',
                'responsable' => 'Jefa Administrativa',
                'fecha_inicio' => now()->startOfYear()->toDateString(),
                'fecha_fin'   => now()->endOfYear()->toDateString(),
                'formula'     => 'wig_renovacion_contratos',
                'tipo'        => 'auto',
                'estado'      => 'activo',
                'orden'       => 4,
            ],
        ];

        foreach ($wigs as $data) {
            Wig::updateOrCreate(
                ['empresa_id' => $empresaId, 'titulo' => $data['titulo']],
                array_merge($data, ['empresa_id' => $empresaId])
            );
        }

        // =============================================
        // EQUIPOS KPI (un team por area)
        // =============================================
        foreach (\App\Models\Team::KPI_AREAS as $slug => $nombre) {
            \App\Models\Team::withoutGlobalScope(\App\Scopes\EmpresaScope::class)
                ->updateOrCreate(
                    ['empresa_id' => $empresaId, 'kpi_area' => $slug],
                    [
                        'name'        => 'Equipo ' . $nombre,
                        'description' => 'Equipo del area de ' . $nombre . ' para medicion de KPIs.',
                        'is_active'   => true,
                    ]
                );
        }
    }
}
