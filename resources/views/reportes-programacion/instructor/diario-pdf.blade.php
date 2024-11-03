<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Diario de Programación - Instructor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 16px;
            text-transform: uppercase;
            margin: 0 0 5px 0;
        }
        .header h2 {
            font-size: 14px;
            margin: 0 0 5px 0;
        }
        .header h3 {
            font-size: 14px;
            margin: 10px 0;
        }
        .instructor-info {
            margin: 15px 0;
            padding: 10px;
            background-color: #f5f5f5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 10px;
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #000;
        }
        .estado {
            font-weight: bold;
        }
        .estado-programado { color: #B45309; }
        .estado-en-curso { color: #1D4ED8; }
        .estado-completado { color: #047857; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Servicio Nacional de Aprendizaje SENA</h1>
            <h2>Centro de Servicios y Gestión Empresarial</h2>
            <h3>Reporte Diario de Programación - Instructor</h3>
        </div>

        <div class="instructor-info">
            <p><strong>Instructor:</strong> {{ Auth::user()->persona->pnombre }} {{ Auth::user()->persona->papellido }}</p>
            <p><strong>Documento:</strong> {{ Auth::user()->persona->numero_documento }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($fecha)->isoFormat('LL') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="15%">Hora</th>
                    <th width="15%">Ambiente</th>
                    <th width="15%">Ficha</th>
                    <th width="20%">Programa</th>
                    <th width="25%">Competencia</th>
                    <th width="10%">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programaciones as $programacion)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($programacion->hora_inicio)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($programacion->hora_fin)->format('H:i') }}
                        </td>
                        <td>
                            {{ $programacion->ambiente->numero }} - 
                            {{ $programacion->ambiente->alias }}
                        </td>
                        <td>{{ $programacion->ficha->codigo_ficha }}</td>
                        <td>{{ $programacion->ficha->nombre }}</td>
                        <td>
                            {{ $programacion->competencia->codigo }} - 
                            {{ Str::limit($programacion->competencia->descripcion, 50) }}
                        </td>
                        <td>
                            <span class="estado estado-{{ $programacion->estado }}">
                                {{ ucfirst($programacion->estado) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">
                            No hay programaciones para este día
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
            <p>Este documento es generado automáticamente por el sistema SGPAC</p>
        </div>
    </div>
</body>
</html>