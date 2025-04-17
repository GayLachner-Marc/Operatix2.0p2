<!-- home_login.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Iniciar Sesión</title>
    
    <!-- Enlace a los estilos CSS para dar formato a la página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Iniciar Sesión</h2>

    <!-- Formulario de inicio de sesión -->
    <form action="login.php" method="POST">
        
        <!-- Campo para el correo electrónico -->
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>
        
        <!-- Campo para la contraseña -->
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <!-- Campo para seleccionar el tipo de usuario -->
        <label for="tipo_usuario">Tipo de Usuario:</label>
        <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="cliente">Cliente</option>
            <option value="hotel">Hotel</option>
            <option value="admin">Administrador</option>
        </select>

        <!-- Botón para iniciar sesión -->
        <button type="submit" name="submit">Iniciar sesión</button>
    </form>

    <!-- Bloque PHP para mostrar errores -->
    <?php
    // Si hay un error al iniciar sesión, lo mostramos en rojo
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>

    <!-- Enlace para ir al registro en caso de que el usuario no tenga cuenta -->
    <p>Aún no tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>

</body>
</html>
