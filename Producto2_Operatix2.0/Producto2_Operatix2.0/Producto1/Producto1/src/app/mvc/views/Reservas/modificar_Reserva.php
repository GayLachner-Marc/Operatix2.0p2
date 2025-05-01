<!-- modificar_reserva.php -->
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Reserva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Modificar Reserva</h2>

    <form action="modificar_reserva.php" method="POST">
        <label for="tipo_reserva">Tipo de Trayecto:</label>
        <select id="tipo_reserva" name="tipo_reserva" required>
            <option value="aeropuerto_hotel" <?= $reserva['tipo_reserva'] == 'aeropuerto_hotel' ? 'selected' : ''; ?>>De Aeropuerto a Hotel</option>
            <option value="hotel_aeropuerto" <?= $reserva['tipo_reserva'] == 'hotel_aeropuerto' ? 'selected' : ''; ?>>De Hotel a Aeropuerto</option>
            <option value="ida_vuelta" <?= $reserva['tipo_reserva'] == 'ida_vuelta' ? 'selected' : ''; ?>>Ida y vuelta</option>
        </select>

        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="date" id="fecha_entrada" name="fecha_entrada" value="<?= htmlspecialchars($reserva['fecha_entrada']) ?>" required>

        <label for="hora_entrada">Hora de Entrada:</label>
        <input type="time" id="hora_entrada" name="hora_entrada" value="<?= htmlspecialchars($reserva['hora_entrada']) ?>" required>

        <label for="num_viajeros">Número de Viajeros:</label>
        <input type="number" id="num_viajeros" name="num_viajeros" value="<?= htmlspecialchars($reserva['num_viajeros']) ?>" required>

        <label for="id_hotel">Hotel de Destino:</label>
        <select id="id_hotel" name="id_hotel" required>
            <option value="1" <?= $reserva['id_hotel'] == 1 ? 'selected' : ''; ?>>Hotel Playa</option>
            <option value="2" <?= $reserva['id_hotel'] == 2 ? 'selected' : ''; ?>>Hotel Centro</option>
            <option value="3" <?= $reserva['id_hotel'] == 3 ? 'selected' : ''; ?>>Hotel Montaña</option>
        </select>

        <label for="numero_vuelo">Número de Vuelo:</label>
        <input type="text" id="numero_vuelo" name="numero_vuelo" value="<?= htmlspecialchars($reserva['numero_vuelo']) ?>">

        <label for="hora_vuelo">Hora del Vuelo:</label>
        <input type="time" id="hora_vuelo" name="hora_vuelo" value="<?= htmlspecialchars($reserva['hora_vuelo']) ?>">

        <label for="origen_vuelo">Origen del Vuelo:</label>
        <input type="text" id="origen_vuelo" name="origen_vuelo" value="<?= htmlspecialchars($reserva['origen_vuelo']) ?>">

        <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id_reserva']) ?>">

        <button type="submit" name="submit">Modificar Reserva</button>
    </form>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador'): ?>
        <p><a href="/admin/home">← Volver al Panel de Administración</a></p>
    <?php else: ?>
        <p><a href="/cliente/home">← Volver al Menú del Cliente</a></p>
    <?php endif; ?>

</body>
</html>
