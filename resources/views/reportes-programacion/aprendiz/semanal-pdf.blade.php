<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Semanal de Programación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Servicio Nacional de Aprendizaje SENA</h1>
        <h2>Centro de Servicios y Gestión Empresarial</h2>
        <h3>Reporte Semanal de Programación</h3>
        
        <p>
            Semana del {{ \Carbon\Carbon::parse($fechaInicio)->isoFormat('LL') }}
            al {{ \Carbon\Carbon::parse($fechaInicio)->addDays(6)->isoFormat('LL') }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Día y Fecha</th>
                <th>Hora</th>
                <th>Ambiente</th>
                <th>Instructor</th>
                <th>Competencia</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @php
                $fechaActual = \Carbon\Carbon::parse($fechaInicio);
                $hayProgramaciones = false;
            @endphp

            @for($i = 0; $i < 7; $i++)
                @php
                    $fechaDia = $fechaActual->copy()->addDays($i);
                    $fechaDiaStr = $fechaDia->format('Y-m-d');
                    $programacionesDia = $programacionesPorDia->get($fechaDiaStr, collect());
                @endphp

                @if($programacionesDia->isNotEmpty())
                    @php $hayProgramaciones = true; @endphp
                    @foreach($programacionesDia as $programacion)
                        <tr>
                            <td>{{ ucfirst($fechaDia->isoFormat('dddd D [de] MMMM')) }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($programacion->hora_inicio)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($programacion->hora_fin)->format('H:i') }}
                            </td>
                            <td>{{ $programacion->ambiente->numero }} - {{ $programacion->ambiente->alias }}</td>
                            <td>{{ $programacion->instructor->pnombre }} {{ $programacion->instructor->papellido }}</td>
                            <td>{{ $programacion->competencia->codigo }} - {{ $programacion->competencia->descripcion }}</td>
                            <td>{{ ucfirst($programacion->estado) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ ucfirst($fechaDia->isoFormat('dddd D [de] MMMM')) }}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endif
            @endfor
        </tbody>
    </table>

    <div class="footer">
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>