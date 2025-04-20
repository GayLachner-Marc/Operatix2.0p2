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

    <?php if (isset($_SESSION['mensaje'])): ?>
    <p style="color: green;">✅ <?= htmlspecialchars($_SESSION['mensaje']) ?></p>
    <?php unset($_SESSION['mensaje']); ?>
<?php elseif (isset($_SESSION['error'])): ?>
    <p style="color: red;">❌ <?= htmlspecialchars($_SESSION['error']) ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


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
            <?php if (!empty($clientes)): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= htmlspecialchars($cliente['id_viajero']) ?></td>
                        <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                        <td><?= htmlspecialchars($cliente['email']) ?></td>
                        <td>
                            <a href="/admin/usuarios/editar?id=<?= urlencode($cliente['id_viajero']) ?>">Editar</a> |
                            <a href="/admin/usuarios/eliminar?id=<?= urlencode($cliente['id_viajero']) ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php
    // Redirige al panel según tipo de cliente
    $panelURL = (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador') ? '/admin/home' : '/cliente/home';
    ?>
    <p><a href="<?= $panelURL ?>">← Volver al Panel</a></p>

</body>
</html>
