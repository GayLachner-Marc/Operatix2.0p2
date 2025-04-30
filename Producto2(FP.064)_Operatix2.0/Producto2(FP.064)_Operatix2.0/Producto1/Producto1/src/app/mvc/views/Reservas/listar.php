<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

<div class="reservas">
    <h2 class="titulo-reservas">Lista de Reservas</h2>

    <?php if (!empty($reservas) && is_array($reservas)): ?>
        <?php foreach ($reservas as $reserva): ?>
            <?php if (
                (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador') ||
                (isset($_SESSION['email']) && isset($reserva['email_cliente']) && $reserva['email_cliente'] === $_SESSION['email'])
            ): ?>
                <div class="reserva">
                    <h3>Reserva: <?= htmlspecialchars($reserva['localizador'] ?? '') ?></h3>
                    <p><strong>Hotel:</strong> <?= htmlspecialchars($reserva['id_hotel'] ?? '') ?></p>
                    <p><strong>Fecha de Reserva:</strong> <?= htmlspecialchars($reserva['fecha_reserva'] ?? '') ?></p>
                    <p><strong>Fecha de Modificación:</strong> <?= htmlspecialchars($reserva['fecha_modificacion'] ?? '') ?></p>
                    <p><strong>Fecha de Entrada:</strong> <?= htmlspecialchars($reserva['fecha_entrada'] ?? '') ?> <?= htmlspecialchars($reserva['hora_entrada'] ?? '') ?></p>
                    <p><strong>Origen del Vuelo:</strong> <?= htmlspecialchars($reserva['origen_vuelo_entrada'] ?? '') ?></p>
                    <p><strong>Fecha de Vuelo de Salida:</strong> <?= htmlspecialchars($reserva['fecha_vuelo_salida'] ?? '') ?></p>
                    <p><strong>Hora del Vuelo de Salida:</strong> <?= htmlspecialchars($reserva['hora_vuelo_salida'] ?? '') ?></p>
                    <p><strong>Hora de Recogida:</strong> <?= htmlspecialchars($reserva['hora_recogida'] ?? 'N/A') ?></p>
                    <p><strong>Número de Viajeros:</strong> <?= htmlspecialchars($reserva['num_viajeros'] ?? '') ?></p>
                    <p><strong>Vehículo:</strong> <?= htmlspecialchars($reserva['id_vehiculo'] ?? '') ?></p>
                    <p><strong>Número de Vuelo:</strong> <?= htmlspecialchars($reserva['numero_vuelo_entrada'] ?? '') ?></p>

                    <div class="reserva-botones">
                        <?php if (!empty($reserva['cancelable'])): ?>
                            <a href="/reserva/eliminar?id=<?= urlencode($reserva['id_reserva']) ?>">
                                <button>Cancelar Reserva</button>
                            </a>
                            <a href="/reserva/modificar?id=<?= urlencode($reserva['id_reserva']) ?>">
                                <button>Modificar Reserva</button>
                            </a>
                        <?php else: ?>
                            <button disabled>Cancelar no disponible (menos de 48 horas)</button>
                            <button disabled>Modificar no disponible (menos de 48 horas)</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No tienes reservas disponibles.</p>
    <?php endif; ?>

    <div class="volver-menu">
        <?php if (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador'): ?>
            <a href="/admin/home">← Volver al Panel de Administración</a>
        <?php else: ?>
            <a href="/cliente/home">← Volver al Panel del Usuario</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
