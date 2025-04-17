<!-- crear_reserva_cliente.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Reserva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        form {
            max-width: 600px;
            margin: auto;
        }
        label, input, select, button {
            display: block;
            width: 100%;
            margin: 10px 0;
        }
        button {
            padding: 10px;
        }
    </style>
</head>
<body>

    <h2>Crear Nueva Reserva</h2>

    <form action="/reserva/crear" method="POST">
        <label for="id_tipo_reserva">Tipo de Trayecto:</label>
        <select id="id_tipo_reserva" name="id_tipo_reserva" required>
            <option value="1">De Aeropuerto a Hotel</option>
            <option value="2">De Hotel a Aeropuerto</option>
            <option value="3">Ida y Vuelta</option>
        </select>

        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="date" id="fecha_entrada" name="fecha_entrada" required max="2099-12-31">


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

        <label for="numero_vuelo_entrada">Número de Vuelo:</label>
        <input type="text" id="numero_vuelo_entrada" name="numero_vuelo_entrada" required>


        <label for="hora_vuelo_salida">Hora del Vuelo:</label>
        <input type="time" id="hora_vuelo_salida" name="hora_vuelo_salida">

        <label for="origen_vuelo_entrada">Origen del Vuelo:</label>
        <input type="text" id="origen_vuelo_entrada" name="origen_vuelo_entrada">

        <!-- Ocultos: generados automáticamente -->
        <?php if (isset($_SESSION['email'])): ?>
    <input type="hidden" name="email_cliente" value="<?= htmlspecialchars($_SESSION['email']) ?>">
<?php else: ?>
    <p style="color:red;">⚠️ No hay correo en la sesión. Por favor vuelve a iniciar sesión.</p>
<?php endif; ?>

        <input type="hidden" name="id_destino" value="1">
        <input type="hidden" name="fecha_vuelo_salida" value="<?= date('Y-m-d') ?>">
        <input type="hidden" name="id_vehiculo" value="1">
        <input type="hidden" name="localizador" value="<?= uniqid('RES-') ?>">

        <button type="submit" name="submit">Crear Reserva</button>
    </form>

    <p><a href="/cliente/home">← Volver al Panel de Cliente</a></p>

</body>
</html>
