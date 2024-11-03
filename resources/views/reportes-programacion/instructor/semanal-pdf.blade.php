<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Semanal de Programación - Instructor</title>
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
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .dia {
            background-color: #f8f9fa;
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
        .sin-programacion {
            text-align: center;
            color: #666;
            font-style: italic;
        }
        .competencia {
            font-size: 10px;
            color: #666;
        }
        .resumen {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .resumen table {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Servicio Nacional de Aprendizaje SENA</h1>
            <h2>Centro de Servicios y Gestión Empresarial</h2>
            <h3>Reporte Semanal de Programación - Instructor</h3>
        </div>

        <div class="instructor-info">
            <p><strong>Instructor:</strong> {{ Auth::user()->persona->pnombre }} {{ Auth::user()->persona->papellido }}</p>
            <p><strong>Documento:</strong> {{ Auth::user()->persona->numero_documento }}</p>
            <p><strong>Semana del:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->isoFormat('LL') }}
               <strong>al</strong> {{ \Carbon\Carbon::parse($fechaFin)->isoFormat('LL') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="15%">Día</th>
                    <th width="12%">Hora</th>
                    <th width="13%">Ambiente</th>
                    <th width="20%">Ficha</th>
                    <th width="30%">Competencia</th>
                    <th width="10%">Estado</th>
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
                                <td class="dia">
                                    {{ ucfirst($fechaDia->isoFormat('dddd D [de] MMMM')) }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($programacion->hora_inicio)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($programacion->hora_fin)->format('H:i') }}
                                </td>
                                <td>
                                    {{ $programacion->ambiente->numero }} - 
                                    {{ $programacion->ambiente->alias }}
                                </td>
                                <td>
                                    {{ $programacion->ficha->codigo_ficha }}
                                    <div class="competencia">
                                        {{ Str::limit($programacion->ficha->nombre, 30) }}
                                    </div>
                                </td>
                                <td>
                                    {{ $programacion->competencia->codigo }}
                                    <div class="competencia">
                                        {{ Str::limit($programacion->competencia->descripcion, 50) }}
                                    </div>
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
                            <td class="dia">
                                {{ ucfirst($fechaDia->isoFormat('dddd D [de] MMMM')) }}
                            </td>
                            <td colspan="5" class="sin-programacion">
                                No hay programaciones para este día
                            </td>
                        </tr>
                    @endif
                @endfor

                @if(!$hayProgramaciones)
                    <tr>
                        <td colspan="6" class="sin-programacion">
                            No hay programaciones para esta semana
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- Resumen estadístico --}}
        <div class="resumen">
            <h4>Resumen de la Semana</h4>
            <table>
                <tr>
                    <th>Total Programaciones</th>
                    <th>Fichas Diferentes</th>
                    <th>Ambientes Utilizados</th>
                    <th>Total Horas</th>
                </tr>
                <tr>
                    <td style="text-align: center">{{ $programaciones->count() }}</td>
                    <td style="text-align: center">{{ $programaciones->unique('ficha_id')->count() }}</td>
                    <td style="text-align: center">{{ $programaciones->unique('ambiente_id')->count() }}</td>
                    <td style="text-align: center">
                        {{ $programaciones->sum(function($prog) {
                            return Carbon\Carbon::parse($prog->hora_fin)->diffInHours(Carbon\Carbon::parse($prog->hora_inicio));
                        }) }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
            <p>Este documento es generado automáticamente por el sistema SGPAC</p>
            <p>Página 1</p>
        </div>
    </div>
</body>
</html>