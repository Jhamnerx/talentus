<div class="tabla_borde mb-4">
    <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tbody>
            <tr>
                <td align="left" class="bold" colspan="4">Dispositivos y Sim cards Enviados</td>
            </tr>
            <tr class="border_top">
                <td align="left">Tecnico:</td>
                <td align="left" colspan="3">{{ $guia->tecnico ? $guia->tecnico->name : '' }}</td>
            </tr>
            <tr class="border_top border_bottom">
                <td align="left">Enviado por:</td>
                <td align="left" colspan="3">{{ $guia->user ? $guia->user->name : '' }}</td>
            </tr>
            <tr class="border_top">
                @if ($guia->dispositivos->count() > 0)
                    <td colspan="{{ $guia->sim_cards->count() > 0 ? '2' : '4' }}" align="left" class="v50"
                        style="vertical-align: top;">
                        <table class="tabla_extra" border="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td align="left" class="bold">IMEI</td>
                                    <td align="left" class="bold">MODELO</td>
                                </tr>
                                @foreach ($guia->dispositivos as $dispositivo)
                                    <tr>
                                        <td align="left">{{ $dispositivo->imei }}</td>
                                        <td align="left">{{ $dispositivo->modelo->modelo }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                @endif

                @if ($guia->sim_cards->count() > 0)
                    <td colspan="{{ $guia->dispositivos->count() > 0 ? '2' : '4' }}" class="v50"
                        style="vertical-align: top;">
                        <table class="tabla_extra" border="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td align="left" class="bold">SIM CARD</td>
                                    <td align="left" class="bold">OPERADOR</td>
                                </tr>
                                @foreach ($guia->sim_cards as $sim_card)
                                    <tr>
                                        <td align="left">{{ $sim_card->sim_card }}</td>
                                        <td align="left">{{ $sim_card->operador }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                @endif
            </tr>

        </tbody>
    </table>
</div>
