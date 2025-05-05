<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Verificación: solo tipo 'hotel' puede acceder
if (!isset($_SESSION['cliente_id']) || $_SESSION['tipo_cliente'] !== 'hotel') {
    header("Location: /cliente/login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Hotel</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <h2>Bienvenido al Panel del Hotel</h2>
    <p>Desde este panel, puedes gestionar las reservas de los clientes y ver la información relevante de tu hotel.</p>

    <div class="menu">
        <ul>
            <li><a href="/hotel/reservas">Ver Reservas</a></li>
            <li><a href="/hotel/crear_reserva">Realizar Nueva Reserva</a></li>
            <li><a href="/hotel/perfil">Editar Perfil del Hotel</a></li>
        </ul>
    </div>

    <p><a href="/cliente/logout">Cerrar sesión</a></p>

        <h3>Resumen de comisiones mensuales</h3>
    <ul>
        <?php if (!empty($comisionesPorMes)): ?>
            <?php foreach ($comisionesPorMes as $mes => $importe): ?>
                <li><?= $mes ?>: <?= number_format($importe, 2) ?> €</li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No tienes comisiones registradas aún.</li>
        <?php endif; ?>
    </ul>


</body>
</html>
