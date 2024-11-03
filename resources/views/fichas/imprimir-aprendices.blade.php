<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Aprendices - Ficha {{ $ficha->codigo_ficha }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #39A900;
            padding-bottom: 10px;
        }
        .header img {
            width: 150px;
            margin-bottom: 10px;
        }
        .ficha-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .ficha-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
            text-align: left;
        }
        th {
            background-color: #39A900;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .firma-seccion {
            margin-top: 50px;
            text-align: center;
        }
        .firma-linea {
            border-top: 1px solid #000;
            width: 200px;
            margin: 10px auto;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/sena-logo.png') }}" alt="SENA">
        <h2>Listado de Aprendices</h2>
    </div>

    <div class="ficha-info">
        <p><strong>Ficha:</strong> {{ $ficha->codigo_ficha }}</p>
        <p><strong>Programa de Formación:</strong> {{ $ficha->programaFormacion->nombre }}</p>
        <p><strong>Instructor Líder:</strong> 
            {{ $ficha->instructor->pnombre }} {{ $ficha->instructor->snombre }} 
            {{ $ficha->instructor->papellido }} {{ $ficha->instructor->sapellido }}
        </p>
        <p><strong>Jornada:</strong> {{ $ficha->jornada->nombre }}</p>
        <p><strong>Fecha de Inicio:</strong> {{ Carbon\Carbon::parse($ficha->fecha_inicio)->format('d/m/Y') }}</p>
        <p><strong>Total Aprendices:</strong> {{ $aprendices->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">Documento</th>
                <th width="30%">Nombre Completo</th>
                <th width="25%">Correo Electrónico</th>
                <th width="15%">Teléfono</th>
                <th width="15%">Firma</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aprendices as $aprendiz)
                <tr>
                    <td>{{ $aprendiz->documento }}</td>
                    <td>{{ $aprendiz->pnombre }} {{ $aprendiz->snombre }} {{ $aprendiz->papellido }} {{ $aprendiz->sapellido }}</td>
                    <td>{{ $aprendiz->correo }}</td>
                    <td>{{ $aprendiz->telefono }}</td>
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center">No hay aprendices registrados en esta ficha</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="firma-seccion">
        <div class="firma-linea"></div>
        <p>{{ $ficha->instructor->pnombre }} {{ $ficha->instructor->papellido }}</p>
        <p>Instructor Líder</p>
        <p>CC: {{ $ficha->instructor->documento }}</p>
    </div>

    <div class="footer">
        <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>SENA - Centro de Servicios y Gestión Empresarial</p>
        <p>Sistema de Gestión de Programación Académica</p>
    </div>
</body>
</html>