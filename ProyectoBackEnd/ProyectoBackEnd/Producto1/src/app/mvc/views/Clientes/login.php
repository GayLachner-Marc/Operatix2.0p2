<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Iniciar sesión</h2>

    <?php
    if (isset($_SESSION['error_login'])) {
        echo "<p style='color:red'>" . $_SESSION['error_login'] . "</p>";
        unset($_SESSION['error_login']);
    }
    ?>

    <form method="POST" action="/cliente/login">
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>
