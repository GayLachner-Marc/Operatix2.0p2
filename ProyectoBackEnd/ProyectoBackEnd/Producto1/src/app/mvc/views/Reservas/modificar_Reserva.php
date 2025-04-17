<!-- modificar_reserva.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Modificar Reserva</title>
    
    <!-- Enlace a los estilos CSS para dar formato a la página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Modificar Reserva</h2>

    <!-- Formulario para modificar la reserva -->
    <form action="modificar_reserva.php" method="POST">
        
        <!-- Campo para seleccionar el tipo de reserva (aeropuerto a hotel, hotel a aeropuerto, ida y vuelta) -->
        <label for="tipo_reserva">Tipo de Trayecto:</label>
        <select id="tipo_reserva" name="tipo_reserva" required>
            <option value="aeropuerto_hotel" <?php echo $reserva['tipo_reserva'] == 'aeropuerto_hotel' ? 'selected' : ''; ?>>De Aeropuerto a Hotel</option>
            <option value="hotel_aeropuerto" <?php echo $reserva['tipo_reserva'] == 'hotel_aeropuerto' ? 'selected' : ''; ?>>De Hotel a Aeropuerto</option>
            <option value="ida_vuelta" <?php echo $reserva['tipo_reserva'] == 'ida_vuelta' ? 'selected' : ''; ?>>Ida y vuelta</option>
        </select>
        
        <!-- Campo para seleccionar la nueva fecha de entrada -->
        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="date" id="fecha_entrada" name="fecha_entrada" value="<?= htmlspecialchars($reserva['fecha_entrada']) ?>" required>
        
        <!-- Campo para seleccionar la nueva hora de entrada -->
        <label for="hora_entrada">Hora de Entrada:</label>
        <input type="time" id="hora_entrada" name="hora_entrada" value="<?= htmlspecialchars($reserva['hora_entrada']) ?>" required>
        
        <!-- Campo para número de viajeros -->
        <label for="num_viajeros">Número de Viajeros:</label>
        <input type="number" id="num_viajeros" name="num_viajeros" value="<?= htmlspecialchars($reserva['num_viajeros']) ?>" required>
        
        <!-- Campo para seleccionar el hotel (destino) -->
        <label for="id_hotel">Hotel de Destino:</label>
        <select id="id_hotel" name="id_hotel" required>
            <!-- Aquí debes llenar las opciones con los hoteles disponibles -->
            <option value="1" <?= $reserva['id_hotel'] == 1 ? 'selected' : ''; ?>>Hotel Playa</option>
            <option value="2" <?= $reserva['id_hotel'] == 2 ? 'selected' : ''; ?>>Hotel Centro</option>
            <option value="3" <?= $reserva['id_hotel'] == 3 ? 'selected' : ''; ?>>Hotel Montaña</option>
        </select>

        <!-- Campo para modificar el número de vuelo (si aplica) -->
        <label for="numero_vuelo">Número de Vuelo:</label>
        <input type="text" id="numero_vuelo" name="numero_vuelo" value="<?= htmlspecialchars($reserva['numero_vuelo']) ?>">
        
        <!-- Campo para modificar la hora del vuelo (si aplica) -->
        <label for="hora_vuelo">Hora del Vuelo:</label>
        <input type="time" id="hora_vuelo" name="hora_vuelo" value="<?= htmlspecialchars($reserva['hora_vuelo']) ?>">
        
        <!-- Campo para seleccionar el origen del vuelo (si aplica) -->
        <label for="origen_vuelo">Origen del Vuelo:</label>
        <input type="text" id="origen_vuelo" name="origen_vuelo" value="<?= htmlspecialchars($reserva['origen_vuelo']) ?>">
        
        <!-- Campo oculto para el ID de la reserva -->
        <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id_reserva']) ?>">

        <!-- Botón para confirmar la modificación de la reserva -->
        <button type="submit" name="submit">Modificar Reserva</button>
    </form>

    <!-- Bloque PHP para mostrar errores -->
    <?php
    // Si hay un error al modificar la reserva, se muestra el mensaje en rojo
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>

    <!-- Enlace para volver al menú del cliente -->
    <p><a href="/cliente/home">Volver al Menú del Cliente</a></p>

</body>
</html>
