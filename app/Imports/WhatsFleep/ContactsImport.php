<?php

namespace App\Imports\WhatsFleep;

use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\WaTag;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContactsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected int $rowCount = 0;

    public function __construct(
        protected WaTag $tag,
        protected int $userId
    ) {}

    public function model(array $row): ?Contact
    {
        $name   = $row['nombre'] ?? $row['name'] ?? null;
        $number = $row['numero'] ?? $row['number'] ?? $row['telefono'] ?? $row['phone'] ?? null;

        if (!$number) {
            return null;
        }

        $number = preg_replace('/\D/', '', (string) $number);

        $this->rowCount++;

        return new Contact([
            'user_id' => $this->userId,
            'tag_id'  => $this->tag->id,
            'name'    => $name,
            'number'  => $number,
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function rules(): array
    {
        return [
            '*.numero'   => 'nullable|string',
            '*.number'   => 'nullable|string',
            '*.telefono' => 'nullable|string',
            '*.phone'    => 'nullable|string',
        ];
    }
}
