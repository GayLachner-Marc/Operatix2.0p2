<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

<div class="editar-usuario-container">
    <h2>Editar Usuario</h2>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert-success">✅ <?= htmlspecialchars($_SESSION['mensaje']) ?></div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert-error">❌ <?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="/admin/usuarios/editar" method="POST" id="editarUsuarioForm">
        <input type="hidden" name="id" value="<?= isset($usuario['id_viajero']) ? htmlspecialchars($usuario['id_viajero']) : '' ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= isset($usuario['nombre']) ? htmlspecialchars($usuario['nombre']) : '' ?>" required>

        <label for="correo">Correo electrónico:</label>
        <input type="email" name="correo" id="correo" value="<?= isset($usuario['email']) ? htmlspecialchars($usuario['email']) : '' ?>" required>

        <label for="password">Nueva contraseña (opcional):</label>
        <input type="password" name="password" id="password">

        <label for="confirm_password">Confirmar contraseña:</label>
        <input type="password" name="confirm_password" id="confirm_password">

        <button type="submit">Guardar Cambios</button>
    </form>

    <div class="volver-menu">
        <a href="/admin/usuarios">← Volver a la gestión de usuarios</a>
    </div>
</div>

<script>
    document.getElementById("editarUsuarioForm").addEventListener("submit", function(e) {
        const pass = document.getElementById("password").value;
        const confirm = document.getElementById("confirm_password").value;

        if (pass && pass !== confirm) {
            alert("⚠️ Las contraseñas no coinciden.");
            e.preventDefault();
        }
    });
</script>

</body>
</html>
