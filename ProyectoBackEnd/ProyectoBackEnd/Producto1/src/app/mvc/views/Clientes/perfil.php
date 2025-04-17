<!-- perfil.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Editar Perfil</title>
    
    <!-- Se enlaza la hoja de estilos CSS para darle formato a la página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Editar Perfil</h2>

    <!-- Formulario para editar los datos del perfil del usuario -->
    <form action="/cliente/modificar" method="POST">

        
        <!-- Campo para el nombre de usuario -->
        <label for="username">Nombre de usuario:</label>
        <!-- El campo se llena con el valor actual del nombre de usuario del usuario logueado -->
        <input type="text" id="username" name="nombre" value="<?php echo htmlspecialchars($cliente->getNombre()); ?>" required>
        
        <!-- Campo para el correo electrónico -->
        <label for="email">Correo electrónico:</label>
        <!-- Este campo es editable, y se llena con el valor actual del correo del usuario -->
        <input type="email" id="email" name="correo" value="<?php echo htmlspecialchars($cliente->getEmail()); ?>" required>
        
        <!-- Campo para cambiar la contraseña -->
        <label for="password">Nueva contraseña:</label>
        <!-- Este campo permite que el usuario ingrese una nueva contraseña si lo desea -->
        <input type="password" id="password" name="password" placeholder="Escriba una nueva contraseña">
        
        <!-- Repetir la contraseña -->
        <label for="confirm_password">Confirmar nueva contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Repita la nueva contraseña">
        
        <!-- Botón para guardar los cambios -->
        <button type="submit" name="submit">Actualizar Perfil</button>
    </form>

    <!-- Bloque PHP para mostrar errores -->
    <?php
    // Si la variable $error está definida, significa que hubo un problema con la actualización de los datos
    if (isset($error)) {
        // Muestra el error en rojo
        echo "<p style='color:red;'>$error</p>";
    }
    
    // Si la variable $success está definida, significa que los cambios fueron guardados exitosamente
    if (isset($success)) {
        // Muestra un mensaje de éxito en verde
        echo "<p style='color:green;'>$success</p>";
    }
    ?>

    <!-- Enlace para volver a la página anterior (puede ser el home o cualquier página del usuario) -->
    <p><a href="home.php">Volver al inicio</a></p>

</body>
</html>
