<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <h1>Editar Hotel</h1>

    <?php if (isset($hotel)): ?>
        <form action="/admin/hoteles/editar" method="POST">
            <input type="hidden" name="id_hotel" value="<?= htmlspecialchars($hotel['id_hotel']) ?>">

            <label for="id_zona">ID Zona:</label>
            <input type="text" name="id_zona" id="id_zona" value="<?= htmlspecialchars($hotel['id_zona']) ?>" required>

            <label for="comision">Comisión (%):</label>
            <input type="text" name="comision" id="comision" value="<?= htmlspecialchars($hotel['Comision']) ?>" required>

            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?= htmlspecialchars($hotel['usuario']) ?>" required>

            <label for="password">Nueva Contraseña (dejar en blanco para mantener):</label>
            <input type="password" name="password" id="password" placeholder="********">

            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="********">

            <button type="submit">Guardar Cambios</button>
        </form>
    <?php else: ?>
        <p style="color:red;">❌ Hotel no encontrado.</p>
    <?php endif; ?>

    <p><a href="/admin/hoteles">← Volver a la gestión de hoteles</a></p>

    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
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
