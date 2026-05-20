<?php

namespace App\Exports\WhatsFleep;

use App\Models\WhatsFleep\WaTag;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContactsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected WaTag $tag) {}

    public function collection()
    {
        return $this->tag->contacts;
    }

    public function headings(): array
    {
        return ['Nombre', 'Número', 'Fecha de creación'];
    }

    public function map($contact): array
    {
        return [
            $contact->name,
            $contact->number,
            $contact->created_at->format('d/m/Y H:i'),
        ];
    }
}
