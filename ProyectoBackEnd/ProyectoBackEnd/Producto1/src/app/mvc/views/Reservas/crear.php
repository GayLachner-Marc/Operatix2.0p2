<!-- prear.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Confirmar Reserva</title>
    
    <!-- Enlace a los estilos CSS para dar formato a la página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Verifica los Detalles de tu Reserva</h2>

    <!-- Formulario para confirmar la reserva -->
    <form action="confirmar_reserva.php" method="POST">
        
        <!-- Mostrar tipo de trayecto -->
        <label for="tipo_reserva">Tipo de Trayecto:</label>
        <input type="text" id="tipo_reserva" name="tipo_reserva" value="<?php echo htmlspecialchars($tipo_reserva); ?>" readonly>
        
        <!-- Mostrar fecha de entrada -->
        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="text" id="fecha_entrada" name="fecha_entrada" value="<?php echo htmlspecialchars($fecha_entrada); ?>" readonly>
        
        <!-- Mostrar hora de entrada -->
        <label for="hora_entrada">Hora de Entrada:</label>
        <input type="text" id="hora_entrada" name="hora_entrada" value="<?php echo htmlspecialchars($hora_entrada); ?>" readonly>
        
        <!-- Mostrar número de viajeros -->
        <label for="num_viajeros">Número de Viajeros:</label>
        <input type="text" id="num_viajeros" name="num_viajeros" value="<?php echo htmlspecialchars($num_viajeros); ?>" readonly>
        
        <!-- Mostrar hotel de destino -->
        <label for="id_hotel">Hotel de Destino:</label>
        <input type="text" id="id_hotel" name="id_hotel" value="<?php echo htmlspecialchars($hotel_destino); ?>" readonly>

        <!-- Mostrar número de vuelo (si aplica) -->
        <label for="numero_vuelo">Número de Vuelo:</label>
        <input type="text" id="numero_vuelo" name="numero_vuelo" value="<?php echo htmlspecialchars($numero_vuelo); ?>" readonly>
        
        <!-- Mostrar hora del vuelo (si aplica) -->
        <label for="hora_vuelo">Hora del Vuelo:</label>
        <input type="text" id="hora_vuelo" name="hora_vuelo" value="<?php echo htmlspecialchars($hora_vuelo); ?>" readonly>

        <!-- Mostrar origen del vuelo (si aplica) -->
        <label for="origen_vuelo">Origen del Vuelo:</label>
        <input type="text" id="origen_vuelo" name="origen_vuelo" value="<?php echo htmlspecialchars($origen_vuelo); ?>" readonly>

        <!-- Campo oculto para el correo del cliente -->
        <input type="hidden" name="email_cliente" value="<?php echo htmlspecialchars($email_cliente); ?>">

        <!-- Botón para confirmar la reserva -->
        <button type="submit" name="submit">Confirmar Reserva</button>
    </form>

    <!-- Bloque PHP para mostrar errores -->
    <?php
    // Si la variable $error está definida, significa que hubo un problema al confirmar la reserva
    if (isset($error)) {
        // Muestra el error en rojo
        echo "<p style='color:red;'>$error</p>";
    }

    // Si la variable $success está definida, significa que la reserva fue confirmada correctamente
    if (isset($success)) {
        // Muestra un mensaje de éxito en verde
        echo "<p style='color:green;'>Reserva confirmada con éxito.</p>";
    }
    ?>

    <!-- Enlace para volver a la página anterior (puede ser el panel de reservas) -->
    <p><a href="/cliente/home">Volver al Panel de Cliente</a></p>

</body>
</html>
