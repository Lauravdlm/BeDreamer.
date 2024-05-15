<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Usuarios</title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 2px;
            font-size: 12px
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Informe de Usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Nombre de usuario</th>
                <th>Email</th>
                <th>Instagram</th>
                <th>Página web</th>
                <th>Ciudad</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->instagram }}</td>
                    <td>{{ $user->webpage }}</td>
                    <td>{{ $user->city->name }}</td>
                    <td>{{ $user->role->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
