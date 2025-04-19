<!-- perfil.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <h2>Editar Perfil</h2>

    <!-- Mensajes de éxito o error desde la sesión -->
    <?php if (isset($_SESSION['mensaje'])): ?>
        <p style="color:green;"><?= htmlspecialchars($_SESSION['mensaje']) ?></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php elseif (isset($_SESSION['error'])): ?>
        <p style="color:red;"><?= htmlspecialchars($_SESSION['error']) ?></p>
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
        <p>Usuario no encontrado.</p>
    <?php endif; ?>

    <p><a href="/cliente/home">← Volver al inicio</a></p>

    <!-- Validación simple en el navegador -->
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
