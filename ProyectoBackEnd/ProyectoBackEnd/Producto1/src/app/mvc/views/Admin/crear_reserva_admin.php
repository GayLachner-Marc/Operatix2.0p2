<!-- crear_reserva_admin.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reserva</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Crear Nueva Reserva</h2>

    <form action="crear_reserva_admin.php" method="POST">
        <label for="tipo_reserva">Tipo de Trayecto:</label>
        <select id="tipo_reserva" name="tipo_reserva" required>
            <option value="aeropuerto_hotel">De Aeropuerto a Hotel</option>
            <option value="hotel_aeropuerto">De Hotel a Aeropuerto</option>
            <option value="ida_vuelta">Ida y vuelta</option>
        </select>

        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="date" id="fecha_entrada" name="fecha_entrada" required>

        <label for="hora_entrada">Hora de Entrada:</label>
        <input type="time" id="hora_entrada" name="hora_entrada" required>

        <label for="num_viajeros">Número de Viajeros:</label>
        <input type="number" id="num_viajeros" name="num_viajeros" required>

        <label for="id_hotel">Hotel de Destino:</label>
        <select id="id_hotel" name="id_hotel" required>
            <option value="1">Hotel Playa</option>
            <option value="2">Hotel Centro</option>
            <option value="3">Hotel Montaña</option>
        </select>

        <label for="numero_vuelo">Número de Vuelo:</label>
        <input type="text" id="numero_vuelo" name="numero_vuelo">

        <label for="hora_vuelo">Hora del Vuelo:</label>
        <input type="time" id="hora_vuelo" name="hora_vuelo">

        <label for="origen_vuelo">Origen del Vuelo:</label>
        <input type="text" id="origen_vuelo" name="origen_vuelo">

        <label for="email_cliente">Correo del Cliente:</label>
        <input type="email" id="email_cliente" name="email_cliente" required>

        <button type="submit" name="submit">Crear Reserva</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }

    if (isset($success)) {
        echo "<p style='color:green;'>Reserva creada con éxito.</p>";
    }

    // Enlace dinámico según el tipo de cliente
    $volverUrl = (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador')
                    ? '/admin/home'
                    : '/cliente/home';
    ?>

    <p><a href="<?= $volverUrl ?>">← Volver al Panel</a></p>

</body>
</html>
