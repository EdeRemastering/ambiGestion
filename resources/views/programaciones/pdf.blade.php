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
<h1>PROGRAMACIONES</h1> 
    <hr>

    <br><br>

    
<!-- Tabla de programación -->
<table id="programacionesTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Ficha</th>
            <th>Ambiente</th>
            <th>Instructor Asignante</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Estado</th>
  
        </tr>
    </thead>
    <tbody>
        @foreach ($programaciones as $programacion)
        <tr>
            <td>{{ $programacion->ficha }}</td>
            <td>{{ $programacion->ambiente }}</td>
            <td>{{ $programacion->nombre_instructor_asignante }}</td>
            <td>{{ $programacion->fecha_inicio }}</td>
            <td>{{ $programacion->fecha_fin }}</td>
            <td>{{ $programacion->estado }}</td>
     
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
