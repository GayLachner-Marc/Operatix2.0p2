<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

<div class="formulario-perfil">
    <h2 class="titulo-reservas">Editar Perfil</h2>

    <!-- Mensaje de éxito -->
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert success"><?= htmlspecialchars($_SESSION['mensaje']) ?></div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($cliente)): ?>
    <form action="/cliente/editar" method="POST" id="perfilForm">

        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>

        <label for="password">Nueva contraseña:</label>
        <input type="password" id="password" name="password" placeholder="Escriba una nueva contraseña">

        <label for="confirm_password">Confirmar nueva contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Repita la nueva contraseña">

        <button type="submit">Actualizar Perfil</button>
    </form>
    <?php else: ?>
        <p class="alert error">⚠️ Usuario no encontrado.</p>
    <?php endif; ?>

    <div class="volver-menu">
        <a href="/cliente/home">← Volver al inicio</a>
    </div>
</div>

<script>
    document.getElementById('perfilForm').addEventListener('submit', function(e) {
        const pass = document.getElementById('password').value;
        const confirm = document.getElementById('confirm_password').value;
        if (pass !== '' && pass !== confirm) {
            alert('⚠️ Las contraseñas no coinciden.');
            e.preventDefault();
        }
    });
</script>

</body>
</html>
