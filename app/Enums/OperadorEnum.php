<?php

namespace App\Enums;

enum OperadorEnum: string
{
    case CLARO = "claro";
    case MOVISTAR = "movistar";
    case PERSONAL = "personal";
    case MULTIOPERADOR = "multioperador";
    case ENTEL = "entel";
    case CUY = "cuy";
    case INKACEL = "INKACEL";


    public function labels(): string
    {
        return match ($this) {
            OperadorEnum::CLARO => 'Claro',
            OperadorEnum::MOVISTAR => 'Movistar',
            OperadorEnum::PERSONAL => 'Personal',
            OperadorEnum::MULTIOPERADOR => 'Multioperador',
            OperadorEnum::ENTEL => 'Entel',
            OperadorEnum::CUY => 'Cuy',
            OperadorEnum::INKACEL => 'Inkacel',
        };
    }

    public function labelPowergridFilter(): string
    {
        return $this->labels();
    }
}
