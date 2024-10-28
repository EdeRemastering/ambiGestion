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
    <h1>AMBIENTES</h1> 
    <hr>

    <br><br>

    {{-- Tabla de ambientes --}}
    <table class="table">
        <thead>
            <tr>
                <th>Número</th>
                <th>Alias</th>
                <th>Capacidad</th>
                <th>Tipo</th>
                <th>Red de Conocimiento</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ambientes as $ambiente)
                <tr>
                    <td>{{ $ambiente->numero ?? 'N/A' }}</td>
                    <td>{{ $ambiente->alias ?? 'N/A' }}</td>
                    <td>{{ $ambiente->capacidad ?? 'N/A' }}</td>
                    <td>{{ $ambiente->tipo_ambiente ?? 'N/A' }}</td>
                    <td>{{ $ambiente->nombre_red_de_conocimiento ?? 'N/A' }}</td>
                    <td>{{ $ambiente->estado_ambiente ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
