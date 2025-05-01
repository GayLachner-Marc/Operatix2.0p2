<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

    <div class="panel-container">
        <h2>Bienvenido al Panel de Administración</h2>
        <p>Desde este panel, el administrador puede gestionar todas las reservas, usuarios y otros aspectos del sistema.</p>

        <ul class="panel-links">
            <li><a href="/reserva/calendario">📅 Ver Calendario de Reservas</a></li>
            <li><a href="/reserva/crear/admin">➕ Crear Nueva Reserva</a></li>
            <li><a href="/admin/usuarios">👥 Gestionar Usuarios</a></li>
            <li><a href="/admin/hoteles">🏨 Gestionar Hoteles</a></li>
            <li><a href="/admin/vehiculos">🚗 Gestionar Vehículos</a></li>
            <li><a href="/admin/reportes">📊 Ver Reportes de Actividad</a></li>
        </ul>

        <div class="volver-menu">
            <a href="/cliente/logout">← Cerrar sesión</a>
        </div>
    </div>

</body>
</html>
