<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Evita que los administradores vean este panel por error
if (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador') {
    header("Location: /admin/home");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <h2>Bienvenido al Panel de Cliente</h2>

    <?php if (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'corporativo'): ?>
        <p><strong>Acceso corporativo:</strong> Estás identificado como un cliente corporativo. Disfruta de nuestros servicios especiales.</p>
    <?php else: ?>
        <p>Desde este panel, puedes gestionar tus reservas, editar tu perfil y más.</p>
    <?php endif; ?>

    <div class="menu">
        <ul>
            <li><a href="/reserva/listar">Mis Reservas</a></li>
            <li><a href="/reserva/crear">Crear Nueva Reserva</a></li>
            <li><a href="/cliente/perfil">Editar Perfil</a></li>
            <li><a href="/cliente/logout">Cerrar sesión</a></li>
        </ul>
    </div>

</body>
</html>
