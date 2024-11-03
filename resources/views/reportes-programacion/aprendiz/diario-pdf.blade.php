<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Diario de Programación</title>
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
        .ficha-info {
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
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: left;
            position: fixed;
            bottom: 0;
            width: 100%;
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
            <h3>Reporte Diario de Programación</h3>
        </div>

        <div class="ficha-info">
            <p><strong>Código:</strong> {{ Auth::user()->persona->ficha->codigo_ficha }}</p>
            <p><strong>Programa:</strong> {{ Auth::user()->persona->ficha->nombre }}</p>
            <p><strong>Jornada:</strong> {{ Auth::user()->persona->ficha->jornada?->descripcion }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($fecha)->isoFormat('LL') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="15%">Hora</th>
                    <th width="20%">Ambiente</th>
                    <th width="20%">Instructor</th>
                    <th width="30%">Competencia</th>
                    <th width="15%">Estado</th>
                </tr>
            </thead>
            <tbody>
                @if($programaciones->isNotEmpty())
                    @foreach($programaciones as $programacion)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($programacion->hora_inicio)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($programacion->hora_fin)->format('H:i') }}
                            </td>
                            <td>
                                {{ $programacion->ambiente->numero }} - 
                                {{ $programacion->ambiente->alias }}
                            </td>
                            <td>
                                {{ $programacion->instructor->pnombre }} 
                                {{ $programacion->instructor->papellido }}
                            </td>
                            <td>
                                {{ $programacion->competencia->codigo }} - 
                                {{ $programacion->competencia->descripcion }}
                            </td>
                            <td>
                                <span class="estado estado-{{ $programacion->estado }}">
                                    {{ ucfirst($programacion->estado) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center;">
                            No hay programaciones para este día
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="footer">
            <p>Fecha de generación: {{ now()->format('d/m/Y H:i') }}</p>
            <p>Documento generado por SGPAC</p>
        </div>
    </div>
</body>
</html>