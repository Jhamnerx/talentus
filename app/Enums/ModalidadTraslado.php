<?php

namespace App\Enums;

enum ModalidadTraslado: string
{

    case TRANSPORTE_PUBLICO = "01";
    case TRANSPORTE_PRIVADO =  "02";

    public function color(): string
    {
        return match ($this) {
            ModalidadTraslado::TRANSPORTE_PUBLICO => 'emerald',
            ModalidadTraslado::TRANSPORTE_PRIVADO => 'rose',
        };
    }

    public function name(): string
    {
        return match ($this) {
            ModalidadTraslado::TRANSPORTE_PUBLICO => 'TRANSPORTE PUBLICO',
            ModalidadTraslado::TRANSPORTE_PRIVADO => 'TRANSPORTE PRIVADO',
        };
    }
}
