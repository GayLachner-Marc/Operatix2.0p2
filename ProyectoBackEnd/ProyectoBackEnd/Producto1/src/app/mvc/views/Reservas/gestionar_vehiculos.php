<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php if (!isset($_SESSION['tipo_cliente']) || $_SESSION['tipo_cliente'] !== 'administrador') {
    header('Location: /cliente/login');
    exit;
} ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Vehículos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<h2>Gestión de Vehículos</h2>

<a href="/admin/vehiculos/crear">Añadir nuevo vehículo</a>

<!-- Aquí iría el listado de vehículos -->
<table border="1">
    <tr>
        <th>ID Vehículo</th>
        <th>Descripción</th>
        <th>Email Conductor</th>
        <th>Acciones</th>
    </tr>
    <?php if (isset($vehiculos)) : ?>
        <?php foreach ($vehiculos as $vehiculo) : ?>
            <tr>
                <td><?= htmlspecialchars($vehiculo['id_vehiculo'] ?? 'No disponible') ?></td> <!-- ID Vehículo -->
                <td><?= htmlspecialchars($vehiculo['description'] ?? 'No disponible') ?></td> <!-- Descripción -->
                <td><?= htmlspecialchars($vehiculo['email_conductor'] ?? 'No disponible') ?></td> <!-- Email Conductor -->
                <td>
                    <a href="/admin/vehiculos/editar?id=<?= htmlspecialchars($vehiculo['id_vehiculo']) ?>">Editar</a> |
                    <a href="/admin/vehiculos/eliminar?id=<?= htmlspecialchars($vehiculo['id_vehiculo']) ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

</body>
</html>
