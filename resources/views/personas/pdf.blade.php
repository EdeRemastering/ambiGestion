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
<h1>PERSONAS</h1> 
    <hr>

    <br><br>
    
<table id="personasTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Rol</th>
         
            </tr>
        </thead>
        <tbody>
            @foreach($personas as $persona)
            <tr>
                <td>{{ $persona->documento }}</td>
                <td>{{ $persona->pnombre }}</td>
                <td>{{ $persona->papellido }}</td>
                <td>{{ $persona->correo }}</td>
                <td>{{ $persona->role_name }}</td>
        
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
