<!-- gestionar_usuarios.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <h1>Gestión de Usuarios</h1>

    <p>Aquí el administrador podrá ver, modificar o eliminar usuarios del sistema.</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?= htmlspecialchars($cliente['id_viajero']) ?></td>
            <td><?= htmlspecialchars($cliente['nombre']) ?></td>
            <td><?= htmlspecialchars($cliente['email']) ?></td>
            <td>
                
            <a href="/admin/usuarios/editar?id=<?= $cliente['id_viajero'] ?>">Editar</a> |
            <a href="/admin/usuarios/eliminar?id=<?= $cliente['id_viajero'] ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>

            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

    </table>

    <p><a href="/admin/home">← Volver al panel</a></p>

</body>
</html>
