<html>

<head>
    <style type="text/css">
        body,
        div,
        table,
        thead,
        tbody,
        tfoot,
        tr,
        th,
        td,
        p {
            font-family: "Calibri";
            font-size: x-small
        }

        a.comment-indicator:hover+comment {
            background: #ffd;
            position: absolute;
            display: block;
            border: 1px solid black;
            padding: 0.5em;
        }

        a.comment-indicator {
            background: red;
            display: inline-block;
            border: 1px solid black;
            width: 0.5em;
            height: 0.5em;
        }

        comment {
            display: none;
        }
    </style>

</head>

<body>
    <table cellspacing="0" border="0">
        <colgroup width="79"></colgroup>
        <colgroup width="246"></colgroup>
        <colgroup width="144"></colgroup>
        <colgroup width="147"></colgroup>
        <colgroup width="152"></colgroup>
        <colgroup width="198"></colgroup>
        <colgroup width="130"></colgroup>
        <colgroup width="184"></colgroup>
        <tr style="color: #fff">
            <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                height="21" align="center" valign=top bgcolor="#052c52">
                <font face="Arial" size=1 color="#FFFFFF">#</font>
            </td>
            <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                align="center" valign=top bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">RAZON SOCIAL</font>
                </b>
            </td>
            <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                align="center" valign=top bgcolor="#052c52"><b>
                    <font face="Arial" size=1 color="#FFFFFF">DNI/RUC</font>
                </b></td>
            <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                align="center" valign=top bgcolor="#052c52"><b>
                    <font face="Arial" size=1 color="#FFFFFF">TELEFONO</font>
                </b></td>
            <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                align="center" valign=top bgcolor="#052c52"><b>
                    <font face="Arial" size=1 color="#FFFFFF">WEB SITE</font>
                </b></td>
            <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                align="center" valign=top bgcolor="#052c52"><b>
                    <font face="Arial" size=1 color="#FFFFFF">DIRECCION</font>
                </b></td>
            <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                align="center" valign=top bgcolor="#052c52"><b>
                    <font face="Arial" size=1 color="#FFFFFF">ESTADO</font>
                </b></td>
            <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                align="center" valign=top bgcolor="#052c52"><b>
                    <font face="Arial" size=1 color="#FFFFFF">FECHA CREACION</font>
                </b></td>
        </tr>
        @foreach ($clientes as $cliente)
            <tr>
                <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                    height="21" align="left" valign=top bgcolor="#E5E5DE" sdval="0" sdnum="1033;">
                    <font face="Arial" size=1 color="#4A4A4A">0</font>
                </td>
                <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                    align="left" valign=top bgcolor="#E5E5DE">
                    <font face="Arial" size=1 color="#4A4A4A">{{ $cliente->razon_social }}</font>
                </td>
                <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                    align="left" valign=top bgcolor="#E5E5DE">
                    <font face="Arial" size=1 color="#4A4A4A">{{ $cliente->numero_documento }}</font>
                </td>
                <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                    align="left" valign=top bgcolor="#E5E5DE" sdval="44813" sdnum="1033;1033;M/D/YYYY">
                    <font face="Arial" size=1 color="#4A4A4A">{{ $cliente->telefono }}</font>
                </td>
                <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                    align="left" valign=top bgcolor="#E5E5DE" sdval="0.192719907407407" sdnum="1033;1033;H:MM:SS">
                    <font face="Arial" size=1 color="#4A4A4A">{{ $cliente->web_site }}</font>
                </td>
                <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                    align="left" valign=top bgcolor="#E5E5DE" sdval="44813.1927199074"
                    sdnum="1033;1033;M/D/YYYY H:MM">
                    <font face="Arial" size=1 color="#4A4A4A">{{ $cliente->direccion }}</font>
                </td>
                <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                    align="left" valign=top bgcolor="#E5E5DE" sdval="0.382048611111111" sdnum="1033;1033;H:MM:SS">
                    <font face="Arial" size=1 color="#4A4A4A">{{ $cliente->estado }}</font>
                </td>
                <td style="border-top: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-left: 2px solid #dee2e6; border-right: 2px solid #dee2e6"
                    align="left" valign=top bgcolor="#E5E5DE" sdval="0" sdnum="1033;">
                    <font face="Arial" size=1 color="#4A4A4A">{{ $cliente->created_at }}</font>
                </td>
            </tr>
        @endforeach


    </table>

</body>

</html>
