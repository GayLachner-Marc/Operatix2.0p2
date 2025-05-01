<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$panelURL = (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador') ? '/admin/home' : '/cliente/home';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

<div class="usuarios-container">
    <h1 class="titulo-usuarios">Gestión de Usuarios</h1>
    <p class="subtexto">Aquí el administrador podrá ver, modificar o eliminar usuarios del sistema.</p>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert-success">✅ <?= htmlspecialchars($_SESSION['mensaje']) ?></div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert-error">❌ <?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <table class="tabla-estilizada">
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
            <tr><td colspan="4" style="text-align: center;">No hay usuarios registrados.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="volver-menu">
        <a href="<?= $panelURL ?>">&larr; Volver al Panel de Administración</a>
    </div>
</div>

</body>
</html>
