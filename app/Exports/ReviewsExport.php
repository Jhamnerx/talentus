<?php

namespace App\Exports;

use App\Models\Cliente\Review;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class ReviewsExport extends StringValueBinder implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return Review::query();
    }
    public function headings(): array
    {
        return [
            '#',
            'EMPRESA',
            'NOMBRE',
            'TELEFONO',
            'FECHA DE NACIMIENTO',
            '¿QUÉ TAN SATISFECHO SE SIENTE CON LA ATENCIÓN BRINDADA A SUS CONSULTAS Y REQUERIMIENTOS?',
            '¿EN QUÉ ASPECTO CREE UD., QUE DEBERÍA MEJORAR NUESTRO SERVICIO?',
            '¿TIENE ALGÚN INCONVENIENTE EN EL MANEJO DE NUESTRAS PLATAFORMAS DE MONITOREO?',
            '¿TIENE ALGUNA SOLICITUD PENDIENTE QUE NO SE HAYA ATENDIDO?',
            '¿RECOMENDARÍA NUESTRO SERVICIO A UN FAMILIAR O AMIGO?',
            'Fecha Registro'
        ];
    }

    public function map($review): array
    {
        return [
            $review->id,
            $review->empresa,
            $review->name,
            $review->telefono,
            $review->birthday,
            $review->question["q1"],
            $review->question["q2"],
            $review->question["q3"],
            $review->question["q4"],
            $review->question["q5"] . ", " . $review->question["q5_why"],
            $review->created_at->format('d-m-Y')
        ];
    }
}
