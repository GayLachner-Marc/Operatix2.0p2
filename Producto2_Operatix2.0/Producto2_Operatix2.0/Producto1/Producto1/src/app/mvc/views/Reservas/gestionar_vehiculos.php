<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['tipo_cliente']) || $_SESSION['tipo_cliente'] !== 'administrador') {
    header('Location: /cliente/login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Vehículos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

<div class="gestion-vehiculos-container">
    <h2>Gestión de Vehículos</h2>

    <p><a href="/admin/vehiculos/crear">+ Añadir nuevo vehículo</a></p>

    <table>
        <thead>
            <tr>
                <th>ID Vehículo</th>
                <th>Descripción</th>
                <th>Email Conductor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($vehiculos) && !empty($vehiculos)) : ?>
                <?php foreach ($vehiculos as $vehiculo) : ?>
                    <tr>
                        <td><?= htmlspecialchars($vehiculo['id_vehiculo'] ?? 'No disponible') ?></td>
                        <td><?= htmlspecialchars($vehiculo['description'] ?? 'No disponible') ?></td>
                        <td><?= htmlspecialchars($vehiculo['email_conductor'] ?? 'No disponible') ?></td>
                        <td>
                            <a href="/admin/vehiculos/editar?id=<?= htmlspecialchars($vehiculo['id_vehiculo']) ?>">Editar</a> |
                            <a href="/admin/vehiculos/eliminar?id=<?= htmlspecialchars($vehiculo['id_vehiculo']) ?>" onclick="return confirm('¿Deseas eliminar este vehículo?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No hay vehículos registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="volver-panel">
        <a href="/admin/home">← Volver al Panel de Administración</a>
    </div>
</div>

</body>
</html>
