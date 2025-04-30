<!-- registro_hotel.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Registro de Hotel</title>
    
    <!-- Se enlaza la hoja de estilos CSS para darle formato a la página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Registro de Hotel</h2>

    <!-- Formulario para registrar un nuevo hotel -->
    <form action="registro_hotel.php" method="POST">
        
        <!-- Campo para el nombre del hotel -->
        <label for="nombre_hotel">Nombre del Hotel:</label>
        <!-- El campo es obligatorio, y se usa para el nombre del hotel -->
        <input type="text" id="nombre_hotel" name="nombre_hotel" required>

        <!-- Campo para la zona del hotel -->
        <label for="id_zona">Zona:</label>
        <!-- El campo es obligatorio, y se usa para la zona del hotel -->
        <input type="text" id="id_zona" name="id_zona" required>
        
        <!-- Campo para la comisión que cobra el hotel -->
        <label for="comision">Comisión:</label>
        <!-- El campo es obligatorio, y se usa para la comisión -->
        <input type="number" id="comision" name="comision" required>
        
        <!-- Campo para el correo electrónico del hotel -->
        <label for="email">Correo electrónico del hotel:</label>
        <!-- El campo es obligatorio, y se usa para autenticar el hotel -->
        <input type="email" id="email" name="email" required>
        
        <!-- Campo para la contraseña del hotel -->
        <label for="password">Contraseña:</label>
        <!-- El campo es obligatorio para establecer una contraseña de acceso -->
        <input type="password" id="password" name="password" required>
        
        <!-- Botón para registrar el hotel -->
        <button type="submit" name="submit">Registrar Hotel</button>
    </form>

    <!-- Bloque PHP para mostrar errores o éxito -->
    <?php
    // Si la variable $error está definida, significa que hubo un problema con el registro
    if (isset($error)) {
        // Muestra el error en rojo
        echo "<p style='color:red;'>$error</p>";
    }
    
    // Si la variable $success está definida, significa que el registro fue exitoso
    if (isset($success)) {
        // Muestra un mensaje de éxito en verde
        echo "<p style='color:green;'>$success</p>";
    }
    ?>

    <!-- Enlace para volver a la página de inicio de sesión si ya tiene cuenta -->
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>

</body>
</html>
