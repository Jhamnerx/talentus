<?php

namespace App\Actions\WhatsFleep;

use App\Models\Clientes;
use App\Models\Contactos;
use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\Device;
use App\Scopes\EmpresaScope;

class ResolveWhatsappContactAction
{
    /**
     * Resuelve (o crea) el contacto WhatsApp para un número entrante,
     * intentando vincularlo a un Cliente GPS por teléfono.
     *
     * @return array{contact: Contact, empresa_id: int, cliente_id: int|null}
     */
    public function execute(Device $device, string $rawNumber, ?string $waJid, ?string $pushName): array
    {
        $number = normalize_wa_number($rawNumber);

        [$clienteId, $empresaId] = $this->matchCliente($number);

        $contact = Contact::firstOrNew([
            'empresa_id' => $empresaId,
            'number' => $number,
        ]);

        $contact->user_id = $contact->user_id ?: $device->user_id;
        $contact->cliente_id = $clienteId ?? $contact->cliente_id;
        $contact->wa_jid = $waJid ?: $contact->wa_jid;
        $contact->push_name = $pushName ?: $contact->push_name;
        $contact->name = $contact->name ?: $pushName;
        $contact->save();

        return [
            'contact' => $contact,
            'empresa_id' => $empresaId,
            'cliente_id' => $clienteId,
        ];
    }

    /**
     * Busca el número normalizado en clientes.telefono y contactos.telefono.
     *
     * @return array{0: int|null, 1: int}  [cliente_id|null, empresa_id]
     */
    private function matchCliente(string $number): array
    {
        $default = (int) config('whatsapp.default_empresa_id', 1);

        if ($number === '') {
            return [null, $default];
        }

        $cliente = Clientes::withoutGlobalScope(EmpresaScope::class)
            ->whereNotNull('telefono')
            ->whereRaw("REPLACE(REPLACE(REPLACE(telefono, ' ', ''), '-', ''), '+', '') LIKE ?", ['%' . $number])
            ->first();

        if ($cliente) {
            return [(int) $cliente->id, (int) $cliente->empresa_id];
        }

        $contacto = Contactos::withoutGlobalScope(EmpresaScope::class)
            ->whereNotNull('telefono')
            ->whereNotNull('cliente_id')
            ->whereRaw("REPLACE(REPLACE(REPLACE(telefono, ' ', ''), '-', ''), '+', '') LIKE ?", ['%' . $number])
            ->first();

        if ($contacto) {
            return [(int) $contacto->cliente_id, (int) ($contacto->empresa_id ?? $default)];
        }

        return [null, $default];
    }
}
