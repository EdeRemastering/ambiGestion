<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
            color: green;
            font-size: 24px;
        }
        hr {
            margin-bottom: 20px;
        }
        .tabla {
            background-color: black;
            color: white;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table, .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: black;
            color: white;
            text-align: center;
        }
        .table td {
            text-align: center;
        }
    </style>
</head>
<body>
<h1>FICHAS</h1> 
    <hr>

    <br><br>

<!-- Tabla de novedades -->
<table id="novedadesTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha de Registro</th>
            <th>Estado de Novedad</th>
            <th>Fecha de Solución</th>
            <th>Descripción Solución</th>
   
        </tr>
    </thead>
    <tbody>
        @foreach ($novedades as $novedad)
        <tr>
            <td>{{ $novedad->id }}</td>
            <td>{{ $novedad->nombre }}</td>
            <td>{{ $novedad->descripcion }}</td>
            <td>{{ $novedad->fecha_registro }}</td>
            <td>{{ $novedad->nombre_estado_novedad }}</td>
            <td>{{ $novedad->fecha_solucion }}</td>
            <td>{{ $novedad->descripcion_solucion }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
