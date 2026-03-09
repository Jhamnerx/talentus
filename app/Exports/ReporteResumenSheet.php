<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReporteResumenSheet implements FromView, WithTitle, ShouldAutoSize
{
    public function __construct(
        private readonly array  $resumen,
        private readonly string $contexto
    ) {}

    public function title(): string
    {
        return 'RESUMEN';
    }

    public function view(): View
    {
        return view('exports.reporte-resumen', [
            'resumen'  => $this->resumen,
            'contexto' => $this->contexto,
        ]);
    }
}
