<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$is_admin = isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador';
$volver_url = $is_admin ? '/admin/home' : '/cliente/home';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de la Reserva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <h2>Detalles de la Reserva</h2>

    <table>
        <tr>
            <th>Tipo de Trayecto</th>
            <td><?= htmlspecialchars($tipo_reserva ?? '') ?></td>
        </tr>
        <tr>
            <th>Fecha de Entrada</th>
            <td><?= htmlspecialchars($fecha_entrada ?? '') ?></td>
        </tr>
        <tr>
            <th>Hora de Entrada</th>
            <td><?= htmlspecialchars($hora_entrada ?? '') ?></td>
        </tr>
        <tr>
            <th>Número de Viajeros</th>
            <td><?= htmlspecialchars($num_viajeros ?? '') ?></td>
        </tr>
        <tr>
            <th>Hotel de Destino</th>
            <td><?= htmlspecialchars($hotel_destino ?? '') ?></td>
        </tr>
        <tr>
            <th>Número de Vuelo</th>
            <td><?= htmlspecialchars($numero_vuelo ?? '') ?></td>
        </tr>
        <tr>
            <th>Hora del Vuelo</th>
            <td><?= htmlspecialchars($hora_vuelo ?? '') ?></td>
        </tr>
        <tr>
            <th>Origen del Vuelo</th>
            <td><?= htmlspecialchars($origen_vuelo ?? '') ?></td>
        </tr>
        <tr>
            <th>Correo del Cliente</th>
            <td><?= htmlspecialchars($email_cliente ?? '') ?></td>
        </tr>
    </table>

    <p><strong>Estado de la Reserva:</strong> <?= htmlspecialchars($estado_reserva ?? 'Pendiente') ?></p>

    <?php if ($is_admin && isset($id_reserva)): ?>
        <p>
            <a href="/admin/reservas/editar?id_reserva=<?= urlencode($id_reserva) ?>">Editar Reserva</a> |
            <a href="/admin/reservas/cancelar?id_reserva=<?= urlencode($id_reserva) ?>" style="color:red;" onclick="return confirm('¿Estás seguro de cancelar esta reserva?');">Cancelar Reserva</a>
        </p>
    <?php endif; ?>

    <p><a href="<?= $volver_url ?>">← Volver al Panel</a></p>

</body>
</html>
