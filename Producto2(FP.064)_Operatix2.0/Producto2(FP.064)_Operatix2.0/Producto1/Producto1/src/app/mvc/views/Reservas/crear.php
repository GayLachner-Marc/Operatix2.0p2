<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['cliente_id'])) {
    header("Location: /cliente/login");
    exit();
}

$tipo_cliente = $_SESSION['tipo_cliente'] ?? 'cliente';
$volver_url = ($tipo_cliente === 'administrador') ? '/admin/home' : '/cliente/home';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Reserva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <h2>Verifica los Detalles de tu Reserva</h2>

    <form action="/reserva/confirmar" method="POST">
        <label for="tipo_reserva">Tipo de Trayecto:</label>
        <input type="text" id="tipo_reserva" name="tipo_reserva" value="<?= htmlspecialchars($tipo_reserva ?? '') ?>" readonly>

        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="text" id="fecha_entrada" name="fecha_entrada" value="<?= htmlspecialchars($fecha_entrada ?? '') ?>" readonly>

        <label for="hora_entrada">Hora de Entrada:</label>
        <input type="text" id="hora_entrada" name="hora_entrada" value="<?= htmlspecialchars($hora_entrada ?? '') ?>" readonly>

        <label for="num_viajeros">Número de Viajeros:</label>
        <input type="text" id="num_viajeros" name="num_viajeros" value="<?= htmlspecialchars($num_viajeros ?? '') ?>" readonly>

        <label for="id_hotel">Hotel de Destino:</label>
        <input type="text" id="id_hotel" name="id_hotel" value="<?= htmlspecialchars($hotel_destino ?? '') ?>" readonly>

        <label for="numero_vuelo">Número de Vuelo:</label>
        <input type="text" id="numero_vuelo" name="numero_vuelo" value="<?= htmlspecialchars($numero_vuelo ?? '') ?>" readonly>

        <label for="hora_vuelo">Hora del Vuelo:</label>
        <input type="text" id="hora_vuelo" name="hora_vuelo" value="<?= htmlspecialchars($hora_vuelo ?? '') ?>" readonly>

        <label for="origen_vuelo">Origen del Vuelo:</label>
        <input type="text" id="origen_vuelo" name="origen_vuelo" value="<?= htmlspecialchars($origen_vuelo ?? '') ?>" readonly>

        <input type="hidden" name="email_cliente" value="<?= htmlspecialchars($email_cliente ?? '') ?>">

        <button type="submit" name="submit">Confirmar Reserva</button>
    </form>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <p><a href="<?= $volver_url ?>">← Volver al Panel</a></p>

</body>
</html>
