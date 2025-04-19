<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirección automática si ya está logueado
if (isset($_SESSION['tipo_cliente'])) {
    if ($_SESSION['tipo_cliente'] === 'administrador') {
        header("Location: /admin/home");
        exit;
    } elseif ($_SESSION['tipo_cliente'] === 'corporativo') {
        header("Location: /cliente/home");
        exit;
    } else {
        header("Location: /cliente/home");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
</head>
<body>

    <h2>Iniciar sesión</h2>

    <!-- Formulario de inicio de sesión -->
    <form method="POST" action="/cliente/login">
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Iniciar sesión</button>
    </form>

    <!-- Mostrar mensajes de error -->
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color:red"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Mostrar mensaje de registro exitoso -->
    <?php if (isset($_SESSION['success'])): ?>
        <p style="color:green"><?= $_SESSION['success'] ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <p>¿No tienes cuenta? <a href="/cliente/registro">Regístrate aquí</a></p>

</body>
</html>
