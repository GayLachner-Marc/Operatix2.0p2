<!-- crear_reserva_cliente.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Crear Reserva</title>
    
    <!-- Enlace a los estilos CSS para dar formato a la página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Crear Nueva Reserva</h2>

    <!-- Formulario para crear una nueva reserva -->
    <form action="crear_reserva_cliente.php" method="POST">
        
        <!-- Campo para seleccionar el tipo de reserva (aeropuerto a hotel, hotel a aeropuerto, ida y vuelta) -->
        <label for="tipo_reserva">Tipo de Trayecto:</label>
        <select id="tipo_reserva" name="tipo_reserva" required>
            <option value="aeropuerto_hotel">De Aeropuerto a Hotel</option>
            <option value="hotel_aeropuerto">De Hotel a Aeropuerto</option>
            <option value="ida_vuelta">Ida y vuelta</option>
        </select>
        
        <!-- Campo para seleccionar la fecha de entrada -->
        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="date" id="fecha_entrada" name="fecha_entrada" required>
        
        <!-- Campo para seleccionar la hora de entrada -->
        <label for="hora_entrada">Hora de Entrada:</label>
        <input type="time" id="hora_entrada" name="hora_entrada" required>
        
        <!-- Campo para el número de viajeros -->
        <label for="num_viajeros">Número de Viajeros:</label>
        <input type="number" id="num_viajeros" name="num_viajeros" required>
        
        <!-- Campo para seleccionar el hotel (destino) -->
        <label for="id_hotel">Hotel de Destino:</label>
        <select id="id_hotel" name="id_hotel" required>
            <!-- Aquí debes llenar las opciones con los hoteles disponibles -->
            <option value="1">Hotel Playa</option>
            <option value="2">Hotel Centro</option>
            <option value="3">Hotel Montaña</option>
        </select>

        <!-- Campo para el número de vuelo (en caso de trayecto de aeropuerto a hotel o ida y vuelta) -->
        <label for="numero_vuelo">Número de Vuelo:</label>
        <input type="text" id="numero_vuelo" name="numero_vuelo">
        
        <!-- Campo para la hora del vuelo (si aplica) -->
        <label for="hora_vuelo">Hora del Vuelo:</label>
        <input type="time" id="hora_vuelo" name="hora_vuelo">
        
        <!-- Campo para seleccionar el origen del vuelo (si aplica) -->
        <label for="origen_vuelo">Origen del Vuelo:</label>
        <input type="text" id="origen_vuelo" name="origen_vuelo">
        
        <!-- El email del cliente se tomará automáticamente desde la sesión, por lo que no es necesario ingresarlo -->
        <input type="hidden" name="email_cliente" value="<?php echo $_SESSION['email']; ?>">

        <!-- Botón para crear la reserva -->
        <button type="submit" name="submit">Crear Reserva</button>
    </form>

    <!-- Bloque PHP para mostrar errores -->
    <?php
    // Si la variable $error está definida, significa que hubo un problema al crear la reserva
    if (isset($error)) {
        // Muestra el error en rojo
        echo "<p style='color:red;'>$error</p>";
    }

    // Si la variable $success está definida, significa que la reserva fue creada correctamente
    if (isset($success)) {
        // Muestra un mensaje de éxito en verde
        echo "<p style='color:green;'>Reserva creada con éxito.</p>";
    }
    ?>

    <!-- Enlace para volver al Panel de Cliente -->
    <p><a href="/cliente/home">Volver al Panel de Cliente</a></p>

</body>
</html>
