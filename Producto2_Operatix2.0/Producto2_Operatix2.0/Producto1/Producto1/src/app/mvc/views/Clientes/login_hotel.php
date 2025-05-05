<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'hotel') {
    header("Location: /hotel/home");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Hotel</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

    <div class="login-container">
        <form method="POST" action="/hotel/login">
            <h2>Iniciar sesión como Hotel</h2>

            <label for="usuario">Usuario del Hotel:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Acceder</button>

            <p class="register-link">¿Eres cliente? <a href="/cliente/login">Inicia sesión aquí</a></p>
        </form>
    </div>

</body>
</html>
