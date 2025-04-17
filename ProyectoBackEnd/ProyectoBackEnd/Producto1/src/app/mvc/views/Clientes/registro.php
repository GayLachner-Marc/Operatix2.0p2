<!-- registro.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Registro de Usuario</title>
    
    <!-- Se enlaza la hoja de estilos CSS para darle formato a la página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Registro de Usuario</h2>

    <!-- Formulario para crear una cuenta -->
    <form action="registro.php" method="POST">
        
        <!-- Campo para el nombre de usuario -->
        <label for="username">Nombre de usuario:</label>
        <!-- Este campo es obligatorio, y se usa para el nombre de usuario -->
        <input type="text" id="username" name="username" required>

        <!-- Campo para el correo electrónico -->
        <label for="email">Correo electrónico:</label>
        <!-- Este campo es obligatorio, y se usa para el correo del usuario -->
        <input type="email" id="email" name="email" required>
        
        <!-- Campo para la contraseña -->
        <label for="password">Contraseña:</label>
        <!-- Este campo es obligatorio, y se usa para la contraseña -->
        <input type="password" id="password" name="password" required>
        
        <!-- Repetir la contraseña -->
        <label for="confirm_password">Confirmar contraseña:</label>
        <!-- Este campo es obligatorio, y debe coincidir con la contraseña anterior -->
        <input type="password" id="confirm_password" name="confirm_password" required>
        
        <!-- Botón para registrar al usuario -->
        <button type="submit" name="submit">Registrar</button>
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

    <!-- Enlace para volver a la página de inicio de sesión si ya tiene una cuenta -->
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>

</body>
</html>
