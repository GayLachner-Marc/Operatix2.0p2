<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

<div class="login-container">
    <form action="/cliente/registro" method="POST">
        <h2>Registro de Usuario</h2>

        <div class="form-grid">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div>
                <label for="apellido1">Primer Apellido:</label>
                <input type="text" id="apellido1" name="apellido1" required>
            </div>

            <div>
                <label for="apellido2">Segundo Apellido:</label>
                <input type="text" id="apellido2" name="apellido2">
            </div>

            <div>
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>

            <div>
                <label for="codigoPostal">Código Postal:</label>
                <input type="text" id="codigoPostal" name="codigoPostal" required>
            </div>

            <div>
                <label for="ciudad">Ciudad:</label>
                <input type="text" id="ciudad" name="ciudad" required>
            </div>

            <div>
                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais" required>
            </div>

            <div>
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="confirm_password">Confirmar contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div>
                <label for="tipo_cliente">Tipo de Cliente:</label>
                <select name="tipo_cliente" id="tipo_cliente" required>
                    <option value="particular">Particular</option>
                    <option value="corporativo">Corporativo</option>
                </select>
            </div>
        </div>

        <button type="submit">Registrarse</button>

        <?php if (isset($_SESSION['error'])): ?>
            <p style="color:red"><?= $_SESSION['error'] ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <p style="color:green"><?= $_SESSION['success'] ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <p class="register-link">¿Ya tienes una cuenta? <a href="/cliente/login">Inicia sesión</a></p>
    </form>
</div>


</body>
</html>
